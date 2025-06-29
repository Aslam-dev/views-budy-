<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    protected $fillable = [
        'name',
        'transaction_fee'
    ];
}
