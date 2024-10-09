<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Exception;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customerService;
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $customers = $this->customerService->getAllCustomers($request);
            return $this->sendResponse($customers, "customers retrieved successfully", 200);
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        try {
            $validated = $request->validated();
            $customer = $this->customerService->createCustomer($validated);
            return $this->sendResponse($customer, "Customer created Successfully", 201);
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($customerId)
    {

        try {
            $customer = $this->customerService->showCustomer($customerId);
            return $this->sendResponse($customer, "Customer retrived successfully", 200);
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, $customerId)
    {

        try {
            $validated = $request->validated();
            $customer = $this->customerService->updateCustomer($validated, $customerId);
            return $this->sendResponse($customer, "Customer Updated successfully", 200);
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($customerId)
    {

        try {
            $this->customerService->deleteCustomer($customerId);
            return $this->sendResponse(null, "Customer deleted successfully", 200);
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 404);
        }
    }

    public function forceDelete($customerId)
    {

        try {
            $this->customerService->forceDeleteCustomer($customerId);
            return $this->sendResponse(null, "Customer deleted permanently", 200);
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 404);
        }
    }

    public function restore($customerId)
    {
        try {
            $customer = $this->customerService->restoreCustomer($customerId);
            return $this->sendResponse($customer, "Customer restored successfully", 200);
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 404);
        }
    }
    public function getCustomerOrders($customerId)
    {
        try {
            $orders = $this->customerService->getCustomerOrders($customerId);
            return $this->sendResponse($orders, 'Orders retrieved successfully');
        } catch (Exception $e) {
            return $this->sendError(null, $e->getMessage(), 404);
        }
    }

    public function getLatestPayment($customerId)
    {
        $payment = $this->customerService->getLatestPayment($customerId);
        return $this->sendResponse($payment, "Latest payment retrieved successfully");
    }

    public function getOldestPayment($customerId)
    {

        $payment = $this->customerService->getOldestPayment($customerId);
        return $this->sendResponse($payment, "Oldest payment retrieved successfully");
    }

    public function getHighestPayment($customerId)
    {

        $payment = $this->customerService->getHighestPayment($customerId);
        return $this->sendResponse($payment, "Highest payment retrieved successfully");
    }

    public function getLowestPayment($customerId)
    {

        $payment = $this->customerService->getLowestPayment($customerId);
        return $this->sendResponse($payment, "Lowest payment retrieved successfully");
    }
}
