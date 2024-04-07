<?php

namespace App\Http\Controllers\Admin\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Events\PaymentProcessed;
use App\Models\Plan;
use App\Models\Payment;
use App\Models\Subscriber;
use App\Models\User;
use Carbon\Carbon;

class CoinbaseWebhookController extends Controller
{
    /**
     * Stripe Webhook processing, unless you are familiar with 
     * Stripe's PHP API, we recommend not to modify it
     */
    public function handleCoinbase(Request $request)
    {
        $payload = json_decode($request->getContent());

        $computedSignature = hash_hmac('sha256', $request->getContent(), config('services.coinbase.webhook_secret'));

        if (hash_equals($computedSignature, $request->server('HTTP_X_CC_WEBHOOK_SIGNATURE'))) {

            $metadata = $payload->event->data->metadata ?? null;

            if (isset($metadata->user)) {

                $user = User::where('id', $metadata->user)->first();

                if ($user) {

                    if ($payload->event->type == 'charge:confirmed' || $payload->event->type == 'charge:resolved') {
                        
                        $payment = Payment::where('order_id', $payload->event->data->code)->first();
                        $plan = Plan::where('id', $metadata->plan_id)->first();

                        if ($payment) {

                            $duration = $plan->payment_frequency;
                            if ($duration == 'monthly') {
                                $days = 30;
                            } elseif ($duration == 'yearly') {
                                $days = 365;
                            } else {
                                $days = 36500;
                            }

                            $subscription_id = Str::random(10);

                            $subscription = Subscriber::create([
                                'user_id' => $user->id,
                                'plan_id' => $plan->id,
                                'status' => 'Active',
                                'created_at' => now(),
                                'gateway' => 'Coinbase',
                                'frequency' => $plan->payment_frequency,
                                'plan_name' => $plan->plan_name,
                                'storage_total' => $plan->storage_total,
                                'subscription_id' => $subscription_id,
                                'active_until' => Carbon::now()->addDays($days),
                            ]);

                            $payment->status = 'completed';
                            $payment->save();

                            $group = ($user->hasRole('admin'))? 'admin' : 'subscriber';

                            $user->syncRoles($group);    
                            $user->group = $group;
                            $user->plan_id = $plan->id;
                            $user->storage_total = $plan->storage_total;
                            $user->download_limit = $plan->download_limit;
                            $user->save();

                            event(new PaymentProcessed($user));

                        }                                       
                    }
                }
            }

        } else {

            Log::info('Coinbase signature validation failed.');

            return response()->json(['status' => 400], 400);
        }

        return response()->json(['status' => 200], 200);
    }
    
}
