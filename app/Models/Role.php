<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    protected $fillable = [
        'name', 'alias'
    ];
    public function scopelist()
    {
        return $this->pluck('name', 'id')->prepend('Select Role', '');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User', 'id', 'role_id');
    }
}
