<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('name', 128)->primary();
            $table->text('value')->nullable();
        });

        DB::table('settings')->insert(
            [      
                [
                    'name' => 'invoice_vendor',
                    'value' => 'Cloud File Transfer'
                ], 
                [
                    'name' => 'invoice_vendor_website',
                    'value' => ''
                ],               
                [
                    'name' => 'invoice_address',
                    'value' => ''
                ],
                [
                    'name' => 'invoice_city',
                    'value' => ''
                ],
                [
                    'name' => 'invoice_country',
                    'value' => ''
                ],
                [
                    'name' => 'invoice_phone',
                    'value' => ''
                ],
                [
                    'name' => 'invoice_postal_code',
                    'value' => ''
                ],
                [
                    'name' => 'invoice_state',
                    'value' => ''
                ],
                [
                    'name' => 'invoice_vat_number',
                    'value' => ''
                ],                
                [
                    'name' => 'invoice_currency',
                    'value' => 'USD'
                ],
                [
                    'name' => 'invoice_language',
                    'value' => 'en'
                ], 
                [
                    'name' => 'legal_privacy_url',
                    'value' => ''
                ],
                [
                    'name' => 'legal_terms_url',
                    'value' => ''
                ],
                [
                    'name' => 'title',
                    'value' => 'Cloud File Transfer - File Share and File Transfer Service'
                ],
                [
                    'name' => 'author',
                    'value' => 'Berkine'
                ],
                [
                    'name' => 'keywords',
                    'value' => 'cloud, file transfer'
                ],
                [
                    'name' => 'description',
                    'value' => 'Cloud File Transfer - File Share and File Transfer Service'
                ],
                [
                    'name' => 'referral_headline',
                    'value' => 'Invite your friends, and when they subscribe, you can get a commission of their purchase(s).'
                ],
                [
                    'name' => 'referral_guideline',
                    'value' => '1. Share your referral link with your friends to register
                                2. For their subscription, you will receive a commissions
                                3. Include your Bank Requisites or Paypal ID in My Gateway tab to receive your commissions
                                4. Request payouts under My Payouts tab
                                5. Checkout all your referrals under My Referrals tab'
                ],
                [
                    'name' => 'bank_instructions',
                    'value' => 'Make your payment directly into our bank account. Please use your Order ID Number as the payment reference. Text to Speech Credits will not be allocated to your account until the funds have cleared in our bank account. Thank you.'
                ],
                [
                    'name' => 'bank_requisites',
                    'value' => 'Bank Name: 
                                Account Name:
                                Account Number/IBAN:
                                BIC/Swift:
                                Routing Number:'
                ],
                [
                    'name' => 'css',
                    'value' => ''
                ],
                [
                    'name' => 'js',
                    'value' => ''
                ],
                [
                    'name' => 'license',
                    'value' => ''
                ],
                [
                    'name' => 'username',
                    'value' => ''
                ],
                [
                    'name' => 'disclaimer',
                    'value' => 'Cras nec dolor vehicula, vulputate diam id, imperdiet urna. Donec non ante massa. Proin sagittis nulla a sapien porta, et convallis nisl posuere. Mauris nec leo id turpis gravida viverra eu nec mi. Mauris tortor quam, commodo eget est sit amet, vestibulum semper sem. Proin porttitor odio ac dolor faucibus vehicula lacinia id ligula. Curabitur tempor vehicula turpis, id vulputate enim ultrices at. Duis mollis eu nibh quis lacinia. Nam semper aliquam consectetur. Proin pulvinar mauris a arcu viverra fermentum. Nullam pulvinar porta augue, vel dignissim ipsum. Mauris tortor quam, commodo eget est sit amet, vestibulum semper sem. Proin porttitor odio ac dolor faucibus vehicula lacinia id ligula.'
                ],

            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
