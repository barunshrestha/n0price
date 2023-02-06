<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        'symbol',
        'purchase_price_per_unit'
    ];

    public $secret_key = "BPCJY!US619";

    public function setUnitsAttribute($value)
    {
        $this->attributes['units'] = DB::raw("AES_ENCRYPT('$value', '$this->secret_key')");
    }
    public function setPurchasePricePerUnitAttribute($value)
    {
        $this->attributes['purchase_price_per_unit'] = DB::raw("AES_ENCRYPT('$value', '$this->secret_key')");
    }
    public function setPurchasePriceAttribute($value)
    {
        $this->attributes['purchase_price'] = DB::raw("AES_ENCRYPT('$value', '$this->secret_key')");
    }

    public function getUnitsAttribute($value)
    {
        return (DB::select("select AES_DECRYPT('$value', '$this->secret_key') as dec_str"))[0]->dec_str;
    }
    public function getPurchasePricePerUnitAttribute($value)
    {
        return (DB::select("select AES_DECRYPT('$value', '$this->secret_key') as dec_str"))[0]->dec_str;
    }
    public function getPurchasePriceAttribute($value)
    {
        return (DB::select("select AES_DECRYPT('$value', '$this->secret_key') as dec_str"))[0]->dec_str;
    }
}
