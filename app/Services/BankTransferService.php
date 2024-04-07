<?php

namespace App\Services;

use App\Traits\ConsumesExternalServiceTrait;
use App\Events\PaymentReferrerBonus;
use Illuminate\Http\Request;
use App\Events\PaymentProcessed;
use App\Models\Payment;
use App\Models\Subscriber;
use App\Models\Plan;
use App\Models\Setting;
use Carbon\Carbon;

class BankTransferService 
{
    use ConsumesExternalServiceTrait;

    public function handlePaymentSubscription(Request $request, Plan $id)
    {   
        if (session()->has('bank_order_id')) {
            $orderID = session()->get('bank_order_id');
            session()->forget('bank_order_id');
        }

        $duration = $id->payment_frequency;
        if ($duration == 'monthly') {
            $days = 30;
        } elseif ($duration == 'yearly') {
            $days = 365;
        } else {
            $days = 36500;
        }

        $subscription = Subscriber::create([
            'active_until' => Carbon::now()->addDays($days),
            'user_id' => auth()->user()->id,
            'plan_id' => $id->id,
            'status' => 'Pending',
            'created_at' => now(),
            'gateway' => 'BankTransfer',
            'frequency' => $id->payment_frequency,
            'plan_name' => $id->plan_name,
            'storage_total' => $id->storage_total,
            'subscription_id' => $orderID,
        ]);

        $tax_value = (config('payment.payment_tax') > 0) ? $tax = $id->price * config('payment.payment_tax') / 100 : 0;
        $total_price = $tax_value + $id->price;

        if (config('payment.referral.payment.enabled') == 'on') {
            if (config('payment.referral.payment.policy') == 'first') {
                if (Payment::where('user_id', auth()->user()->id)->where('status', 'Success')->exists()) {
                    /** User already has at least 1 payment and referrer already received credit for it */
                } else {
                    event(new PaymentReferrerBonus(auth()->user(), $orderID, $total_price, 'BankTransfer'));
                }
            } else {
                event(new PaymentReferrerBonus(auth()->user(), $orderID, $total_price, 'BankTransfer'));
            }
        }

        $record_payment = new Payment();
        $record_payment->user_id = auth()->user()->id;
        $record_payment->plan_id = $id->id;
        $record_payment->plan_type = 'prepaid';
        $record_payment->order_id = $orderID;
        $record_payment->plan_name = $id->plan_name;
        $record_payment->frequency = $id->payment_frequency;
        $record_payment->price = $total_price;
        $record_payment->currency = $id->currency;
        $record_payment->gateway = 'BankTransfer';
        $record_payment->status = 'pending';
        $record_payment->storage_total = $id->storage_total;
        $record_payment->save();      

        event(new PaymentProcessed(auth()->user()));

        $bank_information = ['bank_requisites'];
        $bank = [];
        $settings = Setting::all();

        foreach ($settings as $row) {
            if (in_array($row['name'], $bank_information)) {
                $bank[$row['name']] = $row['value'];
            }
        }

        $plan_type = 'subscription';

        return view('user.plans.banktransfer-success', compact('id', 'orderID', 'bank', 'total_price', 'plan_type'));
    }


    public function handlePaymentPrePaid(Request $request, Plan $id)
    {   
        if (session()->has('bank_order_id')) {
            $orderID = session()->get('bank_order_id');
            session()->forget('bank_order_id');
        }

        $duration = $id->payment_frequency;
        if ($duration == 'monthly') {
            $days = 30;
        } elseif ($duration == 'yearly') {
            $days = 365;
        } else {
            $days = 36500;
        }

        $subscription = Subscriber::create([
            'active_until' => Carbon::now()->addDays($days),
            'user_id' => auth()->user()->id,
            'plan_id' => $id->id,
            'status' => 'Pending',
            'created_at' => now(),
            'gateway' => 'BankTransfer',
            'frequency' => $id->payment_frequency,
            'plan_name' => $id->plan_name,
            'storage_total' => $id->storage_total,
            'subscription_id' => $orderID,
        ]);

        $tax_value = (config('payment.payment_tax') > 0) ? $tax = $id->price * config('payment.payment_tax') / 100 : 0;
        $total_value = $tax_value + $id->price;

        if (config('payment.referral.payment.enabled') == 'on') {
            if (config('payment.referral.payment.policy') == 'first') {
                if (Payment::where('user_id', auth()->user()->id)->where('status', 'Success')->exists()) {
                    /** User already has at least 1 payment and referrer already received credit for it */
                } else {
                    event(new PaymentReferrerBonus(auth()->user(), $orderID, $total_value, 'BankTransfer'));
                }
            } else {
                event(new PaymentReferrerBonus(auth()->user(), $orderID, $total_value, 'BankTransfer'));
            }
        }

        $record_payment = new Payment();
        $record_payment->user_id = auth()->user()->id;
        $record_payment->order_id = $orderID;
        $record_payment->plan_id = $id->id;
        $record_payment->plan_name = $id->plan_name;
        $record_payment->price = $total_value;
        $record_payment->frequency = $id->payment_frequency;
        $record_payment->currency = $id->currency;
        $record_payment->gateway = 'BankTransfer';
        $record_payment->status = 'pending';
        $record_payment->storage_total = $id->storage_total;
        $record_payment->save();
             
        event(new PaymentProcessed(auth()->user()));

        $bank_information = ['bank_requisites'];
        $bank = [];
        $settings = Setting::all();

        foreach ($settings as $row) {
            if (in_array($row['name'], $bank_information)) {
                $bank[$row['name']] = $row['value'];
            }
        }

        return view('user.plans.banktransfer-success', compact('id', 'orderID', 'bank', 'total_value'));
    }

}