<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class foods extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = [
        'orders_id',
        'name',
        'quantity',
        'payment',
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'orders_id');
    }
}