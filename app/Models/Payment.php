<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'customer_id',
        'amount',
        'payment_date',
        'status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
