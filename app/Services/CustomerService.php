<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\Customer;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerService
{
    public function getAllCustomers(Request $request)
    {
        try {
            $query = Customer::with('orders');
            if ($request->filled('status')) {
                $query->status($request->input('status'));
            }
            if ($request->filled('order_date')) {
                $query->orderDate($request->input('order_date'));
            }
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->betweenTwoDate($request->input('start_date'), $request->input('end_date'));
            }
            $customers = $query->get();
            return $customers;
        } catch (QueryException $e) {
            Log::error("Database query error while retrieving customers: " . $e->getMessage());
            throw new Exception("Database query error while retrieving customers");
        } catch (Exception $e) {
            Log::error("An unexpected error while retrieving customers");
            throw new Exception("An unexpected error while retrieving customers");
        }
    }
    public function createCustomer(array $data)
    {
        try {
            return Customer::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone']
            ]);
        } catch (QueryException $e) {
            Log::error("Database query error while creating customer: " . $e->getMessage());
            throw new Exception("Database query error while creating customer");
        } catch (Exception $e) {
            Log::error("An unexpected error while creating customer");
            throw new Exception("An unexpected error while creating customer");
        }
    }

    public function updateCustomer(array $data, $customerId)
    {
        try {
            $customer = Customer::findOrFail($customerId);
            $customer->update(array_filter($data));
            return $customer;
        } catch (ModelNotFoundException $e) {
            Log::error("Customer id $customerId not found for updating: " . $e->getMessage());
            throw new Exception("Customer not found");
        } catch (QueryException $e) {
            Log::error("Database query error while updating customer" . $e->getMessage());
            throw new Exception("Database query error while updating customer");
        } catch (Exception $e) {
            Log::error("An unexoected error while updating customer: " . $e->getMessage());
            throw new Exception("An unexpected error while updating cusyomer");
        }
    }

    public function showCustomer($customerId)
    {
        try {
            $customer = Customer::findOrFail($customerId);
            return $customer;
        } catch (ModelNotFoundException $e) {
            Log::error("Customer id $customerId not found for retrieving: " . $e->getMessage());
            throw new Exception("Customer not found");
        } catch (QueryException $e) {
            Log::error("Database query error while retrieving customer" . $e->getMessage());
            throw new Exception("Database query error while retrieving customer");
        } catch (Exception $e) {
            Log::error("An unexoected error while retrieving customer: " . $e->getMessage());
            throw new Exception("An unexpected error while retrieving customer");
        }
    }
    public function deleteCustomer($customerId)
    {
        try {
            $customer = Customer::findOrFail($customerId);
            $customer->delete();
        } catch (ModelNotFoundException $e) {
            Log::error("Customer id $customerId not found for deleting: " . $e->getMessage());
            throw new Exception("Customer not found");
        } catch (Exception $e) {
            Log::error("An unexoected error while deleting customer: " . $e->getMessage());
            throw new Exception("An unexpected error while deleting customer");
        }
    }

    public function forceDeleteCustomer($customerId)
    {
        try {
            $customer = Customer::onlyTrashed()->findOrFail($customerId);
            $customer->forceDelete();
        } catch (ModelNotFoundException $e) {
            Log::error("Customer id $customerId not found for force deleting: " . $e->getMessage());
            throw new Exception("Customer not found");
        } catch (Exception $e) {
            Log::error("An unexoected error while force deleting customer: " . $e->getMessage());
            throw new Exception("An unexpected error while force deleting customer");
        }
    }
    public function restoreCustomer($customerId)
    {
        try {
            $customer = Customer::onlyTrashed()->findOrFail($customerId);
            $customer->restore();
            return $customer;
        } catch (ModelNotFoundException $e) {
            Log::error("Customer id $customerId not found for restore: " . $e->getMessage());
            throw new Exception("Customer not found");
        } catch (Exception $e) {
            Log::error("An unexoected error while restore customer: " . $e->getMessage());
            throw new Exception("An unexpected error while restore customer");
        }
    }

    public function getCustomerOrders($customerId)
    {
        try {
            $customer = Customer::findOrFail($customerId);
            return $customer->orders;
        } catch (ModelNotFoundException $e) {
            Log::error("Customer id $customerId  was not found to retrieve orders: " . $e->getMessage());
            throw new Exception("Customer not found");
        } catch (Exception $e) {
            Log::error("An unexpected error while retrieving orders for  customer id $customerId : " . $e->getMessage());
            throw new Exception("An unexpected error while retrieving orders for  customer");
        }
    }

    public function getLatestPayment($customerId)
    {
        try {
            $customer = Customer::findOrFail($customerId);
            return $customer->latestPayment;
        } catch (ModelNotFoundException $e) {
            Log::error("Customer id $customerId not found for get latest payment: " . $e->getMessage());
            throw new CustomException("Customer not found", 404);
        } catch (Exception $e) {
            Log::error("An unexpected error  while retrieving latest payment for customer: " . $e->getMessage());
            throw new CustomException("An unexpected error  while retrieving latest payment for customer", 500);
        }
    }

    public function getOldestPayment($customerId)
    {
        try {
            $customer = Customer::findOrFail($customerId);
            return $customer->oldestPayment;
        } catch (ModelNotFoundException $e) {
            Log::error("Customer id $customerId not found for get oldest payment: " . $e->getMessage());
            throw new CustomException("Customer Not Found", 404);
        } catch (Exception $e) {
            Log::error("An unexpected error  while retrieving oldest payment for customer: " . $e->getMessage());
            throw new CustomException("An unexpected error  while retrieving oldest payment for customer", 500);
        }
    }

    public function getHighestPayment($customerId)
    {
        try {
            $customer = Customer::findOrFail($customerId);
            return $customer->highestPayment;
        } catch (ModelNotFoundException $e) {
            Log::error("Customer id $customerId not found for get highest payment: " . $e->getMessage());
            throw new CustomException("Customer Not Found", 404);
        } catch (Exception $e) {
            Log::error("An unexpected error  while retrieving highest payment for customer: " . $e->getMessage());
            throw new CustomException("An unexpected error  while retrieving highest payment for customer", 500);
        }
    }

    public function getLowestPayment($customerId)
    {
        try {
            $customer = Customer::findOrFail($customerId);
            return $customer->lowestPayment;
        } catch (ModelNotFoundException $e) {
            Log::error("Customer id $customerId not found for get lowest payment: " . $e->getMessage());
            throw new CustomException("Customer not found", 404);
        } catch (Exception $e) {
            Log::error("An unexpected error  while retrieving lowest payment for customer: " . $e->getMessage());
            throw new CustomException("An unexpected error  while retrieving lowest payment for customer", 500);
        }
    }
}
