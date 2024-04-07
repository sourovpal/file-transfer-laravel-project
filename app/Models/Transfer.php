<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'file_name',
        'transfer_id',
        'transfer_url',
        'file_ext',
        'file_type',
        'size',
        'share_type',
        'protected',
        'password',
        'expires_at',
        'sent_to',
        'sent_from',
        'message',
        'object_key',
        'plan_type',
        'storage',
        'views',
        'downloads'
    ];
}
