<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetMatrixConstraints extends Model
{
    use HasFactory;
    protected $table = 'asset_matrix_constraints';

    protected $fillable = [
        'user_id',
        'market_cap',
        'risk',
        'percentage_allocation',
        'color',
        'created_at',
        'updated_at'
    ];
}
