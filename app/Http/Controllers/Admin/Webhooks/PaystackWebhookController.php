<?php

namespace App\Http\Controllers\Admin\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\PaymentProcessed;
use App\Models\Subscriber;
use App\Models\Plan;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;

class PaystackWebhookController extends Controller
{
    /**
     * Stripe Webhook processing, unless you are familiar with 
     * Stripe's PHP API, we recommend not to modify it
     */
    public function handlePaystack(Request $request)
    {
        // only a post with paystack signature header gets our attention
        if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' ) || !array_key_exists('x-paystack-signature', $_SERVER) ) {
            exit();
        }
            
        // Retrieve the request's body
        $input = @file_get_contents("php://input");

        define('PAYSTACK_SECRET_KEY', config('services.paystack.api_secret'));

        // validate event do all at once to avoid timing attack
        if($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $input, PAYSTACK_SECRET_KEY)) {
            exit();
        }
            
        http_response_code(200);

        // parse event (which is json string) as object
        // Do something - that will not take long - with $event
        $event = json_decode($input);

        switch ($event->event) {
            case 'subscription.disable': 
                $subscription = Subscriber::where('subscription_id', $event->data->subscription_code)->firstOrFail();
                $subscription->update(['status'=>'Cancelled', 'active_until' => Carbon::createFromFormat('Y-m-d H:i:s', now())->endOfMonth()]);

                $user = User::where('id', $subscription->user_id)->firstOrFail();
                $group = ($user->hasRole('admin'))? 'admin' : 'user';
                if ($group == 'user' || $group = 'subscriber') {
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
            case 'charge.success':
                $subscription = Subscriber::where('subscription_id', $event->data->subscription_code)->where('status', 'Expired')->firstOrFail();

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
                    $record_payment->gateway = 'Paystack';
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
