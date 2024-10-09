<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'phone'
    ];

    public function scopeStatus(Builder $query, $status)
    {
        $query->whereRelation('orders', 'status', $status);
    }
    public function scopeOrderDate(Builder $query, $orderDate)
    {
        $query->whereRelation('orders', 'order_date', $orderDate);
    }

    public function scopeBetweenTwoDate(Builder $query, $startDate, $endDate)
    {
        $query->whereRelation('orders', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate]);
        });
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function oldestPayment()
    {
        return $this->hasOne(Payment::class)->oldestOfMany();
    }

    public function highestPayment()
    {
        return $this->hasOne(Payment::class)->ofMany('amount', 'max');
    }

    public function lowestPayment()
    {
        return $this->hasOne(Payment::class)->ofMany('amount', 'min');
    }
}
