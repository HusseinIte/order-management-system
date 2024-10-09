<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Type\Integer;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'customer_id',
        'product_name',
        'quantity',
        'price',
        'status',
        'order_date'
    ];

    protected function casts()
    {
        return [
            'price' => 'integer',
            'status' => OrderStatus::class,
        ];
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
