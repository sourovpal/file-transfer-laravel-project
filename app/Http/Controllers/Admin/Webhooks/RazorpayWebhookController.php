<?php

namespace App\Http\Controllers\Admin\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\PaymentProcessed;
use App\Models\Subscriber;
use App\Models\Plan;
use App\Models\User;
use App\Models\Payment;
use Carbon\Carbon;

class RazorpaykWebhookController extends Controller
{
    /**
     * Stripe Webhook processing, unless you are familiar with 
     * Stripe's PHP API, we recommend not to modify it
     */
    public function handleRazorpay(Request $request)
    {
        $input = file_get_contents('php://input');
        $webhook_signature = $request->header('x-razorpay-signature');
        
        $body = json_decode($input, true);            

        $generated_signature = hash_hmac('sha256', $input, config('services.razorpay.webhook_secret'));

        if($generated_signature != $webhook_signature ) {
            exit();
        }

        switch ($body->event) {
            case 'subscription.cancelled': 
                $subscription = Subscriber::where('subscription_id', $body->payload->subscription->id)->firstOrFail();
                $subscription->update(['status'=>'Cancelled', 'active_until' => Carbon::createFromFormat('Y-m-d H:i:s', now())->endOfMonth()]);
                
                $user = User::where('id', $subscription->user_id)->firstOrFail();
                $group = ($user->hasRole('admin')) ? 'admin' : 'user';
                if ($group == 'user') {
                    $user->syncRoles($group);    
                    $user->group = $group;
                    $user->plan_id = null;
                    $user->download_limit = 1;
                    $user->storage_total = config('settings.default_storage_size');
                    $user->save();
                } else {
                    $user->syncRoles($group);    
                    $user->group = $group;
                    $user->plan_id = null;
                    $user->save();
                }
                
                break;
            case 'subscription.charged':
                $subscription = Subscriber::where('paystack_customer_code', $body->payload->subscription->id)->where('status', 'Expired')->firstOrFail();

                if ($subscription) {
                    $plan = Plan::where('id', $subscription->plan_id)->firstOrFail();
                    $duration = $plan->payment_frequency;
                    if ($duration == 'monthly') {
                        $days = 30;
                    } elseif ($duration == 'yearly') {
                        $days = 365;
                    } else {
                        $days = 36500;
                    }

                    $subscription->update([
                        'status' => 'Active', 
                        'active_until' => Carbon::now()->addDays($days)
                    ]);
                    
                    $user = User::where('id', $subscription->user_id)->firstOrFail();

                    $tax_value = (config('payment.payment_tax') > 0) ? $plan->price * config('payment.payment_tax') / 100 : 0;
                    $total_price = $tax_value + $plan->price;

                    $record_payment = new Payment();
                    $record_payment->user_id = $user->id;
                    $record_payment->plan_id = $plan->id;
                    $record_payment->order_id = $subscription->plan_id;
                    $record_payment->plan_name = $plan->plan_name;
                    $record_payment->price = $total_price;
                    $record_payment->currency = $plan->currency;
                    $record_payment->gateway = 'Razorpay';
                    $record_payment->frequency = $plan->payment_frequency;
                    $record_payment->status = 'completed';
                    $record_payment->storage_total = $plan->storage_total;
                    $record_payment->save();
                    
                    $group = ($user->hasRole('admin')) ? 'admin' : 'subscriber';

                    $user->syncRoles($group);    
                    $user->group = $group;
                    $user->plan_id = $plan->id;
                    $user->storage_total = $plan->storage_total;
                    $user->download_limit = $plan->download_limit;
                    $user->save();       

                    event(new PaymentProcessed($user));
                }                
          
                break;
        }    
    }
}
