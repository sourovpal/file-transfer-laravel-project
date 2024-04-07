<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentPlatform;
use App\Models\Setting;


class FinanceSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank_information = ['bank_instructions', 'bank_requisites'];
        $bank = [];
        $settings = Setting::all();

        foreach ($settings as $row) {
            if (in_array($row['name'], $bank_information)) {
                $bank[$row['name']] = $row['value'];
            }
        }
        
        return view('admin.finance.settings.index', compact('bank'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        request()->validate([
            'tax' => 'required',
            'currency' => 'required',

            'enable-paypal' => 'sometimes|required',
            'paypal_client_id' => 'required_if:enable-paypal,on',
            'paypal_client_secret' => 'required_if:enable-paypal,on',
            'paypal_base_uri' => 'required_if:enable-paypal,on',
            'paypal_webhook_uri' => 'required_if:enable-paypal,on',
            'paypal_webhook_id' => 'required_if:enable-paypal,on',

            'enable-stripe' => 'sometimes|required',
            'stripe_key' => 'required_if:enable-stripe,on',
            'stripe_secret_key' => 'required_if:enable-stripe,on',
            'stripe_base_uri' => 'required_if:enable-stripe,on',            
            'stripe_webhook_uri' => 'required_if:enable-stripe,on',
            'stripe_webhook_secret' => 'required_if:enable-stripe,on',

            'enable-bank-prepaid' => 'sometimes|required',
            'bank_instructions' => 'required_if:enable-bank-prepaid,on',
            'bank_requisites' => 'required_if:enable-bank-prepaid,on',

            'enable-paystack' => 'sometimes|required',
            'paystack_secret_key' => 'required_if:enable-paystack,on',
            'paystack_public_key' => 'required_if:enable-paystack,on',
            'paystack_base_uri' => 'required_if:enable-paystack,on',
            'paystack_secret_key' => 'required_if:enable-paystack,on',
            'paystack_webhook_uri' => 'required_if:enable-paystack,on',

            'enable-razorpay' => 'sometimes|required',
            'razorpay_key_id' => 'required_if:enable-razorpay,on',
            'razorpay_key_secret' => 'required_if:enable-razorpay,on',
            'razorpay_base_uri' => 'required_if:enable-razorpay,on',
            'razorpay_webhook_secret' => 'required_if:enable-razorpay,on',
            'razorpay_webhook_uri' => 'required_if:enable-razorpay,on',

            'enable-mollie' => 'sometimes|required',
            'mollie_key_id' => 'required_if:enable-mollie,on',
            'mollie_base_uri' => 'required_if:enable-mollie,on',
            'mollie_webhook_uri' => 'required_if:enable-mollie,on',

            'enable-braintree' => 'sometimes|required',
            'braintree_env' => 'required_if:enable-braintree,on',
            'braintree_merchant_id' => 'required_if:enable-braintree,on',
            'braintree_private_key' => 'required_if:enable-braintree,on',
            'braintree_public_key' => 'required_if:enable-braintree,on',

            'enable-coinbase' => 'sometimes|required',
            'coinbase_api_key' => 'required_if:enable-coinbase,on',
            'coinbase_webhook_uri' => 'required_if:enable-coinbase,on',
            'coinbase_webhook_secret' => 'required_if:enable-coinbase,on',

        ]);
       

        $this->storeConfiguration('PAYMENT_TAX', request('tax'));       
        $this->storeConfiguration('DEFAULT_SYSTEM_CURRENCY', request('currency'));     
     
        if (request('currency')) {
            $newName = "'" . config('currencies.all.' . request('currency') . '.symbol') . "'";
            $this->storeWithQuotes('DEFAULT_SYSTEM_CURRENCY_SYMBOL', $newName);
        }  
        
        $this->storeConfiguration('STRIPE_ENABLED', request('enable-stripe'));
        $this->storeConfiguration('STRIPE_KEY', request('stripe_key'));
        $this->storeConfiguration('STRIPE_SECRET', request('stripe_secret_key'));  
        $this->storeConfiguration('STRIPE_BASE_URI', request('stripe_base_uri'));  
        $this->storeConfiguration('STRIPE_WEBHOOK_URI', request('stripe_webhook_uri'));  
        $this->storeConfiguration('STRIPE_WEBHOOK_SECRET', request('stripe_webhook_secret'));  

        $this->storeConfiguration('PAYPAL_ENABLED', request('enable-paypal'));
        $this->storeConfiguration('PAYPAL_CLIENT_ID', request('paypal_client_id'));      
        $this->storeConfiguration('PAYPAL_CLIENT_SECRET', request('paypal_client_secret'));  
        $this->storeConfiguration('PAYPAL_BASE_URI', request('paypal_base_uri'));  
        $this->storeConfiguration('PAYPAL_WEBHOOK_URI', request('paypal_webhook_uri'));  
        $this->storeConfiguration('PAYPAL_WEBHOOK_ID', request('paypal_webhook_id'));  

        $this->storeConfiguration('PAYSTACK_ENABLED', request('enable-paystack'));
        $this->storeConfiguration('PAYSTACK_SECRET_KEY', request('paystack_secret_key'));
        $this->storeConfiguration('PAYSTACK_PUBLIC_KEY', request('paystack_public_key'));  
        $this->storeConfiguration('PAYSTACK_BASE_URI', request('paystack_base_uri'));  
        $this->storeConfiguration('PAYSTACK_WEBHOOK_URI', request('paystack_webhook_uri'));   

        $this->storeConfiguration('RAZORPAY_ENABLED', request('enable-razorpay'));
        $this->storeConfiguration('RAZORPAY_KEY_ID', request('razorpay_key_id'));
        $this->storeConfiguration('RAZORPAY_KEY_SECRET', request('razorpay_key_secret'));  
        $this->storeConfiguration('RAZORPAY_BASE_URI', request('razorpay_base_uri'));  
        $this->storeConfiguration('RAZORPAY_WEBHOOK_URI', request('razorpay_webhook_uri'));  
        $this->storeConfiguration('RAZORPAY_WEBHOOK_SECRET', request('razorpay_webhook_secret'));  

        $this->storeConfiguration('MOLLIE_ENABLED', request('enable-mollie'));
        $this->storeConfiguration('MOLLIE_KEY_ID', request('mollie_key_id'));
        $this->storeConfiguration('MOLLIE_BASE_URI', request('mollie_base_uri'));
        $this->storeConfiguration('MOLLIE_WEBHOOK_URI', request('mollie_webhook_uri'));

        $this->storeConfiguration('BRAINTREE_ENABLED', request('enable-braintree'));
        $this->storeConfiguration('BRAINTREE_PRIVATE_KEY', request('braintree_private_key'));
        $this->storeConfiguration('BRAINTREE_PUBLIC_KEY', request('braintree_public_key'));  
        $this->storeConfiguration('BRAINTREE_MERCHANT_ID', request('braintree_merchant_id'));  
        $this->storeConfiguration('BRAINTREE_ENV', request('braintree_env')); 

        $this->storeConfiguration('COINBASE_ENABLED', request('enable-coinbase'));
        $this->storeConfiguration('COINBASE_API_KEY', request('coinbase_api_key'));  
        $this->storeConfiguration('COINBASE_WEBHOOK_URI', request('coinbase_webhook_uri'));  
        $this->storeConfiguration('COINBASE_WEBHOOK_SECRET', request('coinbase_webhook_secret')); 

        $this->storeConfiguration('BANK_TRANSFER_ENABLED', request('enable-bank'));  
        

        $rows = ['bank_instructions', 'bank_requisites'];
        
        foreach ($rows as $row) {
            Setting::where('name', $row)->update(['value' => $request->input($row)]);
        }
        
        # Enable/Disable Payment Gateways
        if (request('enable-paypal') == 'on') {
            $paypal = PaymentPlatform::where('name', 'PayPal')->first();
            $paypal->enabled = 1;
            $paypal->subscriptions_enabled = 1;
            $paypal->save();

        } else {
            $paypal = PaymentPlatform::where('name', 'PayPal')->first();
            $paypal->enabled = 0;
            $paypal->subscriptions_enabled = 0;
            $paypal->save();
        }

        if (request('enable-stripe') == 'on') {
            $stripe = PaymentPlatform::where('name', 'Stripe')->first();
            $stripe->enabled = 1;
            $stripe->subscriptions_enabled = 1;
            $stripe->save();

        } else {
            $stripe = PaymentPlatform::where('name', 'Stripe')->first();
            $stripe->enabled = 0;
            $stripe->subscriptions_enabled = 0;
            $stripe->save();
        }

        if (request('enable-paystack') == 'on') {
            $stripe = PaymentPlatform::where('name', 'Paystack')->first();
            $stripe->enabled = 1;
            $stripe->subscriptions_enabled = 1;
            $stripe->save();

        } else {
            $stripe = PaymentPlatform::where('name', 'Paystack')->first();
            $stripe->enabled = 0;
            $stripe->subscriptions_enabled = 0;
            $stripe->save();
        }

        if (request('enable-razorpay') == 'on') {
            $stripe = PaymentPlatform::where('name', 'Razorpay')->first();
            $stripe->enabled = 1;
            $stripe->subscriptions_enabled = 1;
            $stripe->save();

        } else {
            $stripe = PaymentPlatform::where('name', 'Razorpay')->first();
            $stripe->enabled = 0;
            $stripe->subscriptions_enabled = 0;
            $stripe->save();
        }

        if (request('enable-mollie') == 'on') {
            $stripe = PaymentPlatform::where('name', 'Mollie')->first();
            $stripe->enabled = 1;
            $stripe->subscriptions_enabled = 1;
            $stripe->save();

        } else {
            $stripe = PaymentPlatform::where('name', 'Mollie')->first();
            $stripe->enabled = 0;
            $stripe->subscriptions_enabled = 0;
            $stripe->save();
        }

        if (request('enable-braintree') == 'on') {
            $stripe = PaymentPlatform::where('name', 'Braintree')->first();
            $stripe->enabled = 1;
            $stripe->save();

        } else {
            $stripe = PaymentPlatform::where('name', 'Braintree')->first();
            $stripe->enabled = 0;
            $stripe->save();
        }

        if (request('enable-coinbase') == 'on') {
            $stripe = PaymentPlatform::where('name', 'Coinbase')->first();
            $stripe->enabled = 1;
            $stripe->save();

        } else {
            $stripe = PaymentPlatform::where('name', 'Coinbase')->first();
            $stripe->enabled = 0;
            $stripe->save();
        }

        if (request('enable-bank') == 'on') {
            $bank_transfer = PaymentPlatform::where('name', 'BankTransfer')->first();
            $bank_transfer->enabled = 1;
            $bank_transfer->subscriptions_enabled = 1;
            $bank_transfer->save();

        } else {
            $bank_transfer = PaymentPlatform::where('name', 'BankTransfer')->first();
            $bank_transfer->enabled = 0;
            $bank_transfer->subscriptions_enabled = 0;
            $bank_transfer->save();
        }

        toastr()->success(__('Payment settings successfully updated'));
        return redirect()->back();
    }

    /**
     * Record in .env file
     */
    private function storeConfiguration($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {

            file_put_contents($path, str_replace(
                $key . '=' . env($key), $key . '=' . $value, file_get_contents($path)
            ));         

        }
    }

    private function storeWithQuotes($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {

            file_put_contents($path, str_replace(
                $key . '=' . '\'' . env($key) . '\'', $key . '=' . $value, file_get_contents($path)
            ));

        }
    }

}
