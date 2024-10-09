<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\Customer;
use App\Models\Payment;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\CodeCoverage\Report\Thresholds;

class PaymentService
{

    public function getAllPayments()
    {
        try {
            $payments = Payment::all();
            return $payments;
        } catch (Exception $e) {
            Log::error("An unexpected error while retrieving payments: " . $e->getMessage());
            throw new CustomException("An unexpected error while retrieving payments", 500);
        }
    }

    public function createPayment(array $data)
    {
        try {
            return Payment::create([
                'customer_id'   => $data['customer_id'],
                'amount'        => $data['amount'],
                'payment_date'  => isset($data['payment_date']) ? $data['payment_date'] : now(),
                'status'        => $data['status']
            ]);
        } catch (QueryException $e) {
            Log::error("Database query error while creating Payment: " . $e->getMessage());
            throw new CustomException("Database query error while creating Payment", 500);
        } catch (Exception $e) {
            Log::error("An unexpected error while creating Payment");
            throw new CustomException("An unexpected error while creating Payment", 500);
        }
    }

    public function updatePayment(array $data, $paymentId)
    {
        try {
            $payment = Payment::findOrFail($paymentId);
            $payment->update(array_filter($data));
            return $payment;
        } catch (ModelNotFoundException $e) {
            Log::error("Payment id $paymentId not found for upadating: " . $e->getMessage());
            throw new CustomException("Payment Not Found", 404);
        } catch (QueryException $e) {
            Log::error("Database query error while updating Payment: " . $e->getMessage());
            throw new CustomException("Database query error while updating Payment", 500);
        } catch (Exception $e) {
            Log::error("An unexpected error while updating Payment");
            throw new CustomException("An unexpected error while updating Payment", 500);
        }
    }

    public function showPayment($paymentId)
    {
        try {
            $payment = Payment::findOrFail($paymentId);
            return $payment;
        } catch (ModelNotFoundException $e) {
            Log::error("Payment id $paymentId not found for retrieving: " . $e->getMessage());
            throw new CustomException("Payment Not Found", 404);
        } catch (Exception $e) {
            Log::error("An unexpected error while retrieving Payment id $paymentId: " . $e->getMessage());
            throw new CustomException("An unexpected error while retrieving Payment", 500);
        }
    }

    public function deletePayment($paymentId)
    {
        try {
            $payment = Payment::findOrFail($paymentId);
            $payment->delete();
        } catch (ModelNotFoundException $e) {
            Log::error("Payment id $paymentId not found for deleting: " . $e->getMessage());
            throw new CustomException("Payment Not Found", 404);
        } catch (Exception $e) {
            Log::error("An unexpected error while deleting Payment id $paymentId: " . $e->getMessage());
            throw new CustomException("An unexpected error while deleting Payment", 500);
        }
    }

    public function forceDeletePayment($paymentId)
    {
        try {
            $payment = Payment::onlyTrashed()->findOrFail($paymentId);
            $payment->forceDelete();
        } catch (ModelNotFoundException $e) {
            Log::error("Payment id $paymentId not found for force deleting: " . $e->getMessage());
            throw new CustomException("Payment Not Found", 404);
        } catch (Exception $e) {
            Log::error("An unexpected error while force deleting Payment id $paymentId: " . $e->getMessage());
            throw new CustomException("An unexpected error while force deleting Payment", 500);
        }
    }

    public function restorePayment($paymentId)
    {
        try {
            $payment = Payment::onlyTrashed()->findOrFail($paymentId);
            $payment->restore();
            return $payment;
        } catch (ModelNotFoundException $e) {
            Log::error("Payment id $paymentId not found for restore: " . $e->getMessage());
            throw new CustomException("Payment Not Found", 404);
        } catch (Exception $e) {
            Log::error("An unexpected error while restore Payment id $paymentId: " . $e->getMessage());
            throw new CustomException("An unexpected error while restore Payment", 500);
        }
    }
}
