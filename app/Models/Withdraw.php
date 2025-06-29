<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $fillable = [
        'user_id',
        'payout_id',
        'payout_details',
        'amount',
        'status',
        'process_date'
    ];

}
