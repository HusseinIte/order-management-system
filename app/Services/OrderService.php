<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Customer;
use App\Models\Order;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public function getAllOrders()
    {
        try {
            $orders = Order::with('customer')->get();
            return $orders;
        } catch (Exception $e) {
            Log::error("An unexpected error while retrieving orders: " . $e->getMessage());
            throw new Exception("An unexpected error while retrieving orders");
        }
    }
    public function createOrder(array $data)
    {
        try {
            return Order::create([
                'customer_id'   => $data['customer_id'],
                'product_name'  => $data['product_name'],
                'quantity'      => $data['quantity'],
                'price'         => $data['price'],
                'order_date'    => $data['order_date']
            ]);
        } catch (Exception $e) {
            Log::error("An unexpected error while creating order: " . $e->getMessage());
            throw new Exception("An unexpected error while creating Order");
        }
    }
    public function updateOrder(array $data, $orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            $order->update(array_filter($data));
            return $order;
        } catch (ModelNotFoundException $e) {
            Log::error("Order id $orderId not found for updating: " . $e->getMessage());
            throw new Exception("Order Not Found");
        } catch (Exception $e) {
            Log::error("An unexpected error while updating order id $orderId: " . $e->getMessage());
            throw new Exception("An unexpected error while updating order");
        }
    }
    public function showOrder($orderId)
    {
        try {
            $order = Order::with('customer')->findOrFail($orderId);
            return $order;
        } catch (ModelNotFoundException $e) {
            Log::error("Order id $orderId not found for retrieving: " . $e->getMessage());
            throw new Exception("Order Not Found");
        } catch (Exception $e) {
            Log::error("An unexpected error while retrieving order id $orderId: " . $e->getMessage());
            throw new Exception("An unexpected error while retrieving order");
        }
    }
    public function deleteOrder($orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            $order->delete();
        } catch (ModelNotFoundException $e) {
            Log::error("Order id $orderId not found for deleting: " . $e->getMessage());
            throw new Exception("Order Not Found");
        } catch (Exception $e) {
            Log::error("An unexpected error while deleting order id $orderId: " . $e->getMessage());
            throw new Exception("An unexpected error while deleting order");
        }
    }


    public function forceDeleteOrder($orderId)
    {
        try {
            $order = Order::onlyTrashed()->findOrFail($orderId);
            $order->forceDelete();
        } catch (ModelNotFoundException $e) {
            Log::error("Order id $orderId not found for force deleting: " . $e->getMessage());
            throw new Exception("Order Not Found");
        } catch (Exception $e) {
            Log::error("An unexpected error while force deleting order id $orderId: " . $e->getMessage());
            throw new Exception("An unexpected error while force deleting order");
        }
    }

    public function restoreOrder($orderId)
    {
        try {
            $order = Order::onlyTrashed()->findOrFail($orderId);
            $order->restore();
        } catch (ModelNotFoundException $e) {
            Log::error("Order id $orderId not found for restore: " . $e->getMessage());
            throw new Exception("Order Not Found");
        } catch (Exception $e) {
            Log::error("An unexpected error while restore order id $orderId: " . $e->getMessage());
            throw new Exception("An unexpected error while restore order");
        }
    }
}
