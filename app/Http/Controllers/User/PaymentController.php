<?php

namespace App\Http\Controllers\User;

use App\Traits\InvoiceGeneratorTrait;
use App\Http\Controllers\Controller;
use App\Events\PaymentReferrerBonus;
use App\Services\PaymentPlatformResolverService;
use App\Events\PaymentProcessed;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PaymentPlatform;
use App\Models\Payment;
use App\Models\Subscriber;
use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;


class PaymentController extends Controller
{   
    use InvoiceGeneratorTrait;

    protected $paymentPlatformResolver;

    
    public function __construct(PaymentPlatformResolverService $paymentPlatformResolver)
    {
        $this->paymentPlatformResolver = $paymentPlatformResolver;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pay(Request $request, Plan $id)
    {
        if ($id->free) {

            $order_id = $this->registerFreeSubscription($id);
            $plan = Plan::where('id', $id->id)->first();

            return view('user.plans.success', compact('plan', 'order_id'));

        } else {

            $rules = [
                'payment_platform' => ['required', 'exists:payment_platforms,id'],
            ];

            $request->validate($rules);

            $paymentPlatform = $this->paymentPlatformResolver->resolveService($request->payment_platform);

            session()->put('subscriptionPlatformID', $request->payment_platform);
            session()->put('gatewayID', $request->payment_platform);
            
            return $paymentPlatform->handlePaymentSubscription($request, $id);
        }
    }


    /**
     * Process prepaid plan request
     */
    public function payPrePaid(Request $request, Plan $id)
    {
        $rules = [
            'payment_platform' => ['required', 'exists:payment_platforms,id'],
        ];

        $request->validate($rules);


        $paymentPlatform = $this->paymentPlatformResolver->resolveService($request->payment_platform);
           

        session()->put('paymentPlatformID', $request->payment_platform);
    
        return $paymentPlatform->handlePaymentPrePaid($request, $id);       
    }

    /**
     * Process approved prepaid plan requests
     */
    public function approved(Request $request)
    {   
        if (session()->has('paymentPlatformID')) {
            $paymentPlatform = $this->paymentPlatformResolver->resolveService(session()->get('paymentPlatformID'));

            return $paymentPlatform->handleApproval($request);
        }

        toastr()->error(__('There was an error while retrieving payment gateway. Please try again'));
        return redirect()->back();
    }


    /**
     * Process approved prepaid plan request for Razorpay
     */
    public function approvedRazorpayPrepaid(Request $request)
    {   
        if (session()->has('paymentPlatformID')) {
            $paymentPlatform = $this->paymentPlatformResolver->resolveService(session()->get('paymentPlatformID'));

            return $paymentPlatform->handleApproval($request);
        }

        toastr()->error(__('There was an error while retrieving payment gateway. Please try again'));
        return redirect()->back();
    }


    /**
     * Process approved prepaid plan request for Braintree
     */
    public function braintreeSuccess(Request $request)
    {
        $plan = Plan::where('id', $request->plan)->first();
        $order_id = request('amp;order');
        
        return view('user.plans.success', compact('plan', 'order_id'));
    }


    /**
     * Process cancelled prepaid plan requests
     */
    public function cancelled()
    {
        toastr()->warning(__('You cancelled the payment process. Would like to try again?'));
        return redirect()->route('user.plans');
    }


    /**
     * Process approved subscription plan requests
     */
    public function approvedSubscription(Request $request)
    {   
        if (session()->has('subscriptionPlatformID')) {
            $paymentPlatform = $this->paymentPlatformResolver->resolveService(session()->get('subscriptionPlatformID'));

            if (session()->has('subscriptionID')) {
                $subscriptionID = session()->get('subscriptionID');
            }

            if ($paymentPlatform->validateSubscriptions($request)) {

                $plan = Plan::where('id', $request->plan_id)->firstOrFail();
                $user = $request->user();

                $gateway_id = session()->get('gatewayID');
                $gateway = PaymentPlatform::where('id', $gateway_id)->firstOrFail();
                $duration = $plan->payment_frequency;
                if ($duration == 'monthly') {
                    $days = 30;
                } elseif ($duration == 'yearly') {
                    $days = 365;
                } else {
                    $days = 36500;
                }

                $subscription = Subscriber::create([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'status' => 'Active',
                    'created_at' => now(),
                    'gateway' => $gateway->name,
                    'frequency' => $plan->payment_frequency,
                    'plan_name' => $plan->plan_name,
                    'storage_total' => $plan->storage_total,
                    'subscription_id' => $subscriptionID,
                    'active_until' => Carbon::now()->addDays($days),
                ]);       

                // Only for Paystack
                if ($gateway_id == 4) {
                    $reference = $paymentPlatform->addPaystackFields($request->reference, $subscription->id);
                }

                session()->forget('gatewayID');

                $this->registerSubscriptionPayment($plan, $user, $subscriptionID, $gateway->name);               
                $order_id = $subscriptionID;
                
                return view('user.plans.success', compact('plan', 'order_id'));
            }
        }

        toastr()->error(__('There was an error while checking your subscription. Please try again'));
        return redirect()->back();
    }


    /**
     * Process approved razorpay subscription plan requests
     */
    public function approvedRazorpaySubscription(Request $request)
    {   
        if (session()->has('subscriptionPlatformID')) {
            $paymentPlatform = $this->paymentPlatformResolver->resolveService(session()->get('subscriptionPlatformID'));

            if (session()->has('subscriptionID')) {
                $subscriptionID = session()->get('subscriptionID');
            }

            if ($paymentPlatform->validateSubscriptions($request)) {

                $plan = Plan::where('id', $request->plan_id)->firstOrFail();

                $gateway_id = session()->get('gatewayID');
                $gateway = PaymentPlatform::where('id', $gateway_id)->firstOrFail();
                $duration = $plan->payment_frequency;
                if ($duration == 'monthly') {
                    $days = 30;
                } elseif ($duration == 'yearly') {
                    $days = 365;
                } else {
                    $days = 36500;
                }

                $subscription = Subscriber::create([
                    'user_id' => auth()->user()->id,
                    'plan_id' => $plan->id,
                    'status' => 'Active',
                    'created_at' => now(),
                    'gateway' => $gateway->name,
                    'frequency' => $plan->payment_frequency,
                    'plan_name' => $plan->plan_name,
                    'storage_total' => $plan->storage_total,
                    'subscription_id' => $subscriptionID,
                    'active_until' => Carbon::now()->addDays($days),
                ]);       

                session()->forget('gatewayID');

                $this->registerSubscriptionPayment($plan, auth()->user(), $subscriptionID, $gateway->name);               
                $order_id = $subscriptionID;

                return view('user.plans.success', compact('plan', 'order_id'));
            }
        }

        toastr()->error(__('There was an error with payment verification. Please try again or contact support'));
        return redirect()->route('user.subscriptions');
    }


    /**
     * Process cancelled subscription plan requests
     */
    public function cancelledSubscription()
    {   
        toastr()->warning(__('You cancelled the payment process. Would like to try again?'));
        return redirect()->route('user.plans');
    }


    /**
     * Register subscription payment in DB
     */
    private function registerSubscriptionPayment(Plan $plan, User $user, $subscriptionID, $gateway)
    {
        $tax_value = (config('payment.payment_tax') > 0) ? $plan->price * config('payment.payment_tax') / 100 : 0;
        $total_price = $tax_value + $plan->price;

        if (config('payment.referral.payment.enabled') == 'on') {
            if (config('payment.referral.payment.policy') == 'first') {
                if (Payment::where('user_id', $user->id)->where('status', 'completed')->exists()) {
                    /** User already has at least 1 payment */
                } else {
                    event(new PaymentReferrerBonus(auth()->user(), $subscriptionID, $total_price, $gateway));
                }
            } else {
                event(new PaymentReferrerBonus(auth()->user(), $subscriptionID, $total_price, $gateway));
            }
        }

        $record_payment = new Payment();
        $record_payment->user_id = $user->id;
        $record_payment->plan_id = $plan->id;
        $record_payment->order_id = $subscriptionID;
        $record_payment->plan_name = $plan->plan_name;
        $record_payment->plan_type = 'subscription';
        $record_payment->frequency = $plan->payment_frequency;
        $record_payment->price = $total_price;
        $record_payment->currency = $plan->currency;
        $record_payment->gateway = $gateway;
        $record_payment->status = 'completed';
        $record_payment->storage_total = $plan->storage_total;
        $record_payment->save();
        
        $group = ($user->hasRole('admin'))? 'admin' : 'subscriber';

        $user = User::where('id', $user->id)->first();
        $user->syncRoles($group);    
        $user->group = $group;
        $user->plan_id = $plan->id;
        $user->storage_total = $plan->storage_total;
        $user->download_limit = $plan->download_limit;
        $user->save();       

        event(new PaymentProcessed(auth()->user()));
   
    }   
    
    
    /**
     * Generate Invoice after payment
     */
    public function generatePaymentInvoice($order_id)
    {              
        $this->generateInvoice($order_id);
    }


    /**
     * Bank Transfer Invoice
     */
    public function bankTransferPaymentInvoice($order_id)
    {
        $this->bankTransferInvoice($order_id);
    }


    /**
     * Show invoice for past payments
     */
    public function showPaymentInvoice(Payment $id)
    {   
        if ($id->gateway == 'BankTransfer' && $id->status != 'completed') {
            $this->bankTransferInvoice($id->order_id);
        } else {          
            $this->showInvoice($id);
        }
    }


    /**
     * Cancel active subscription
     */
    public function stopSubscription(Request $request)
    {   
        if ($request->ajax()) {

            $id = Subscriber::where('id', $request->id)->first();

            if ($id->status == 'Cancelled') {
                $data['status'] = 200;
                $data['message'] = __('This subscription was already cancelled before');
                return $data;
            } elseif ($id->status == 'Suspended') {
                $data['status'] = 400;
                $data['message'] = __('Subscription has been suspended due to failed renewal payment');
                return $data;
            } elseif ($id->status == 'Expired') {
                $data['status'] = 400;
                $data['message'] = __('Subscription has been expired, please create a new one');
                return $data;
            }
            
            if ($id->frequency == 'lifetime') {
                $id->update(['status'=>'Cancelled', 'active_until' => Carbon::createFromFormat('Y-m-d H:i:s', now())]);
                $user = User::where('id', $id->user_id)->firstOrFail();
                $user->plan_id = null;
                $user->group = 'user';
                $user->download_limit = 1;
                $user->storage_total = config('settings.default_storage_size');
                $user->save();

                $data['status'] = 200;
                $data['message'] = __('Subscription has been successfully cancelled');
                return $data;

            } else {

                switch ($id->gateway) {
                    case 'PayPal':
                        $platformID = 1;
                        break;
                    case 'Stripe':
                        $platformID = 2;
                        break;
                    case 'BankTransfer':
                        $platformID = 3;
                        break;
                    case 'Paystack':
                        $platformID = 4;
                        break;
                    case 'Razorpay':
                        $platformID = 5;
                        break;
                    case 'Mollie':
                        $platformID = 7;
                        break;
                    case 'FREE':
                        $platformID = 99;
                        break;
                    default:
                        $platformID = 1;
                        break;
                }


                if ($id->gateway == 'PayPal' || $id->gateway == 'Stripe' || $id->gateway == 'Paystack' || $id->gateway == 'Razorpay' || $id->gateway == 'Mollie') {
                    $paymentPlatform = $this->paymentPlatformResolver->resolveService($platformID);

                    $status = $paymentPlatform->stopSubscription($id->subscription_id);

                    if ($platformID == 2) {
                        if ($status->cancel_at) {
                            $id->update(['status'=>'Cancelled', 'active_until' => Carbon::createFromFormat('Y-m-d H:i:s', now())]);
                            $user = User::where('id', $id->user_id)->firstOrFail();
                            $user->plan_id = null;
                            $user->group = 'user';
                            $user->download_limit = 1;
                            $user->storage_total = config('settings.default_storage_size');
                            $user->save();
                        }
                    } elseif ($platformID == 4) {
                        if ($status->status) {
                            $id->update(['status'=>'Cancelled', 'active_until' => Carbon::createFromFormat('Y-m-d H:i:s', now())]);
                            $user = User::where('id', $id->user_id)->firstOrFail();
                            $user->plan_id = null;
                            $user->group = 'user';
                            $user->download_limit = 1;
                            $user->storage_total = config('settings.default_storage_size');
                            $user->save();
                        }
                    } elseif ($platformID == 5) {
                        if ($status->status == 'cancelled') {
                            $id->update(['status'=>'Cancelled', 'active_until' => Carbon::createFromFormat('Y-m-d H:i:s', now())]);
                            $user = User::where('id', $id->user_id)->firstOrFail();
                            $user->plan_id = null;
                            $user->group = 'user';
                            $user->download_limit = 1;
                            $user->storage_total = config('settings.default_storage_size');
                            $user->save();
                        }
                    } elseif ($platformID == 7) {
                        if ($status->status == 'Canceled') {
                            $id->update(['status'=>'Cancelled', 'active_until' => Carbon::createFromFormat('Y-m-d H:i:s', now())]);
                            $user = User::where('id', $id->user_id)->firstOrFail();
                            $user->plan_id = null;
                            $user->group = 'user';
                            $user->download_limit = 1;
                            $user->storage_total = config('settings.default_storage_size');
                            $user->save();
                        }
                    } elseif ($platformID == 99) { 
                        $id->update(['status'=>'Cancelled', 'active_until' => Carbon::createFromFormat('Y-m-d H:i:s', now())]);
                        $user = User::where('id', $id->user_id)->firstOrFail();
                        $user->plan_id = null;
                        $user->group = 'user';
                        $user->download_limit = 1;
                        $user->storage_total = config('settings.default_storage_size');
                        $user->save();
                    } else {
                        if (is_null($status)) {
                            $id->update(['status'=>'Cancelled', 'active_until' => Carbon::createFromFormat('Y-m-d H:i:s', now())]);
                            $user = User::where('id', $id->user_id)->firstOrFail();
                            $user->plan_id = null;
                            $user->group = 'user';
                            $user->download_limit = 1;
                            $user->storage_total = config('settings.default_storage_size');
                            $user->save();
                        }
                    }
                } else {
                    $id->update(['status'=>'Cancelled', 'active_until' => Carbon::createFromFormat('Y-m-d H:i:s', now())]);
                    $user = User::where('id', $id->user_id)->firstOrFail();
                    $user->plan_id = null;
                    $user->group = 'user';
                    $user->download_limit = 1;
                    $user->storage_total = config('settings.default_storage_size');
                    $user->save();
                }
                
                $data['status'] = 200;
                $data['message'] = __('Subscription has been successfully cancelled');
                return $data;
            }

        }
        
    }


    /**
     * Register free subscription
     */
    private function registerFreeSubscription(Plan $plan)
    {
        $order_id = Str::random(10);
        $subscription = Str::random(10);
        $duration = $plan->payment_frequency;
        if ($duration == 'monthly') {
            $days = 30;
        } elseif ($duration == 'yearly') {
            $days = 365;
        } else {
            $days = 36500;
        }

        $record_payment = new Payment();
        $record_payment->user_id = auth()->user()->id;
        $record_payment->plan_id = $plan->id;
        $record_payment->frequency = $plan->payment_frequency;
        $record_payment->order_id = $order_id;
        $record_payment->plan_name = $plan->plan_name;
        $record_payment->price = 0;
        $record_payment->currency = $plan->currency;
        $record_payment->gateway = 'FREE';
        $record_payment->status = 'Success';
        $record_payment->storage_total = $plan->storage_total;
        $record_payment->save();

        $subscription = Subscriber::create([
            'user_id' => auth()->user()->id,
            'plan_id' => $plan->id,
            'status' => 'Active',
            'created_at' => now(),
            'gateway' => 'FREE',
            'frequency' => $plan->payment_frequency,
            'storage_total' => $plan->storage_total,
            'subscription_id' => $subscription,
            'active_until' => Carbon::now()->addDays($days),
        ]); 
        
        $group = (auth()->user()->hasRole('admin'))? 'admin' : 'subscriber';

        $user = User::where('id', auth()->user()->id)->first();
        $user->syncRoles($group);    
        $user->group = $group;
        $user->plan_id = $plan->id;
        $user->storage_total = $plan->storage_total;
        $user->download_limit = $plan->download_limit;
        $user->save();       
        
        return $order_id;
    } 
}
