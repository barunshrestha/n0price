<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wallet extends Model
{
    use HasFactory;
    protected $table = 'portfolios';
    protected $fillable = [
        'portfolio_id',
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

        $chunks = str_split($value, 100); // split the string into 100-character chunks
        $decrypted_chunks = [];

        foreach ($chunks as $chunk) {
            $decrypted_chunk = DB::selectOne("SELECT AES_DECRYPT('$chunk', '$secret_key') AS dec_str");
            $decrypted_chunks[] = $decrypted_chunk->dec_str;
        }
        return implode('', $decrypted_chunks);
    }
}
