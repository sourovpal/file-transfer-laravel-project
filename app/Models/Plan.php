<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'paypal_gateway_plan_id',
        'stripe_gateway_plan_id',
        'paystack_gateway_plan_id',
        'razorpay_gateway_plan_id',
        'status',
        'plan_name',
        'price',
        'currency',
        'storage_total',
        'payment_frequency',
        'primary_heading', 
        'featured',
        'plan_features', 
        'free',
        'parallel_transfers',
        'password_protection',
        'custom_expiration',
        'download_limit',
        'available_days',
        'transfer_size'
    ];

    /**
     * Plan can have many subscribers
     * 
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
