<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Portfolio extends Model
{
    use HasFactory;
    protected $table = 'portfolios';
    protected $fillable = [
        'user_id',
        'portfolio_name',
        'status'
    ];
    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }
}
