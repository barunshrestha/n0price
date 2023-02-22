<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wallet extends Model
{
    use HasFactory;
    protected $table = 'wallets';
    protected $fillable = [
        'portfolio_id',
        'wallet_address'
    ];
    public function portfolio()
    {
        return $this->belongsTo('portfolios');
    }
    public function setWalletAddressAttribute($value)
    {
        $secret_key = (new Transaction)->secret_key;
        $hex_string = bin2hex($value);
        $this->attributes['wallet_address'] = DB::raw("AES_ENCRYPT(UNHEX('$hex_string'), '$secret_key')");
    }
    public function getWalletAddressAttribute($value)
    {
        $secret_key = (new Transaction)->secret_key;
        $hex_string = bin2hex($value);
        $decrypted_value = DB::select("SELECT AES_DECRYPT(UNHEX('$hex_string'), '$secret_key') as dec_str")[0]->dec_str;
        return $decrypted_value;
    }
    public function encryptAttribute($value)
    {
        $secret_key = (new Transaction)->secret_key;
        return DB::raw("AES_ENCRYPT(UNHEX('$value'), '$secret_key')");
    }
}
