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
        'status',
        'wallet_address'
    ];
    public function setWalletAddressAttribute($value)
    {
        $secret_key = (new Transaction)->secret_key;
        $this->attributes['wallet_address'] = DB::raw("AES_ENCRYPT('$value', '$secret_key')");
    }
    public function getWalletAddressAttribute($value)
    {
        $secret_key = (new Transaction)->secret_key;
        return (DB::select("select AES_DECRYPT('$value', '$secret_key') as dec_str"))[0]->dec_str;
    }
}
