<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sell_log extends Model
{
    use HasFactory;
    protected $table = 'sell_log';

    protected $fillable = [
        'transaction_id',
        'units_debited',
        'profit_loss',
    ];
}
