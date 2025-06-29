<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    protected $fillable = [
        'fund_id',
        'user_id',
        'gateway',
        'amount',
        'image',
        'percentage_applied',
        'transaction_fee',
        'total',
        'status'
    ];
}
