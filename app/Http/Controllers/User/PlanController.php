<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\PaymentPlatform;
use App\Models\Setting;
use App\Models\Plan;

class PlanController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $monthly = Plan::where('status', 'active')->where('payment_frequency', 'monthly')->count();
        $yearly = Plan::where('status', 'active')->where('payment_frequency', 'yearly')->count();
        $lifetime = Plan::where('status', 'active')->where('payment_frequency', 'lifetime')->count();

        $monthly_subscriptions = Plan::where('status', 'active')->where('payment_frequency', 'monthly')->get();
        $yearly_subscriptions = Plan::where('status', 'active')->where('payment_frequency', 'yearly')->get();
        $lifetime_subscriptions = Plan::where('status', 'active')->where('payment_frequency', 'lifetime')->get();

        return view('user.plans.index', compact('monthly', 'yearly', 'lifetime', 'monthly_subscriptions', 'yearly_subscriptions', 'lifetime_subscriptions'));
    }


    /**
     * Checkout for Subscription plans only.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Plan $id)
    {           
        $payment_platforms = PaymentPlatform::where('enabled', 1)->where('subscriptions_enabled', 1)->get();

        $tax_value = (config('payment.payment_tax') > 0) ? $tax = $id->price * config('payment.payment_tax') / 100 : 0;

        $total_value = $tax_value + $id->price;
        $currency = $id->currency;
        $gateway_plan_id = $id->gateway_plan_id;

        $bank_information = ['bank_instructions', 'bank_requisites'];
        $bank = [];
        $settings = Setting::all();

        foreach ($settings as $row) {
            if (in_array($row['name'], $bank_information)) {
                $bank[$row['name']] = $row['value'];
            }
        }

        $bank_order_id = 'BT-' . strtoupper(Str::random(10));
        session()->put('bank_order_id', $bank_order_id);

        return view('user.plans.subscribe-checkout', compact('id', 'payment_platforms', 'tax_value', 'total_value', 'currency', 'gateway_plan_id', 'bank', 'bank_order_id'));
    } 


    /**
     * Checkout for Prepaid plans only.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkout(Plan $id)
    {   
        $payment_platforms = PaymentPlatform::where('enabled', 1)->get();
        
        $tax_value = (config('payment.payment_tax') > 0) ? $tax = $id->price * config('payment.payment_tax') / 100 : 0;

        $total_value = $tax_value + $id->price;
        $currency = $id->currency;

        $bank_information = ['bank_instructions', 'bank_requisites'];
        $bank = [];
        $settings = Setting::all();

        foreach ($settings as $row) {
            if (in_array($row['name'], $bank_information)) {
                $bank[$row['name']] = $row['value'];
            }
        }

        $bank_order_id = 'BT-' . strtoupper(Str::random(10));
        session()->put('bank_order_id', $bank_order_id);
        
        return view('user.plans.prepaid-checkout', compact('id', 'payment_platforms', 'tax_value', 'total_value', 'currency', 'bank', 'bank_order_id'));
    }
}
