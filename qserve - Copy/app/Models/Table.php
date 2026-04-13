<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = [
        'name',
        'capacity',
        'qr_code',
        'status'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}