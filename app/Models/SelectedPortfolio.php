<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectedPortfolio extends Model
{
    use HasFactory;
    protected $table = 'selected_portfolios';

    protected $fillable = [
        'user_id',
        'portfolio_id',
    ];
}
