<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'coin_id',
        'units',
        'partial_units_debited',
        'profit_earned',
        'current_rate',
        'purchase_price',
        'investment_type',
        'purchase_date',
        'symbol'
    ];
}
