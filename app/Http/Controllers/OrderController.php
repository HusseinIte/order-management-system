<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $orders = $this->orderService->getAllOrders();
            return $this->sendResponse($orders, "Orders retrieved successfully");
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        try {
            $validated = $request->validated();
            $order = $this->orderService->createOrder($validated);
            return $this->sendResponse($order, "Order created successfully");
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($orderId)
    {
        try {
            $order = $this->orderService->showOrder($orderId);
            return $this->sendResponse($order, "Order rettieved successfully");
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, $orderId)
    {
        try {
            $validated = $request->validated();
            $order = $this->orderService->updateOrder($validated, $orderId);
            return $this->sendResponse($order, "Order updated successfully");
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($orderId)
    {
        try {
            $this->orderService->deleteOrder($orderId);
            return $this->sendResponse(null, "Order deleted successfully");
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 404);
        }
    }

    public function forceDelete($orderId)
    {
        try {
            $this->orderService->forceDeleteOrder($orderId);
            return $this->sendResponse(null, "Order deleted permanently");
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 404);
        }
    }

    public function restore($orderId)
    {
        try {
            $this->orderService->restoreOrder($orderId);
            return $this->sendResponse(null, "Order restored successfully");
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 404);
        }
    }
}
