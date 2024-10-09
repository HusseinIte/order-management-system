<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\StorePaymentRequest;
use App\Http\Requests\Payment\UpdatePaymentRequest;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = $this->paymentService->getAllPayments();

        if ($payments->isEmpty()) {
            return $this->sendResponse($payments, "No payments found");
        }
        return $this->sendResponse($payments, "Payments retrieving successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        $validated = $request->validated();
        $payment = $this->paymentService->createPayment($validated);
        return $this->sendResponse($payment, "Payment created successsfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($paymentId)
    {
        $payment = $this->paymentService->showPayment($paymentId);
        return $this->sendResponse($payment, "Payment retrieved successfully", 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, $paymentId)
    {
        $validated = $request->validated();
        $payment = $this->paymentService->updatePayment($validated, $paymentId);
        return $this->sendResponse($payment, "Payment updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($paymentId)
    {
        $this->paymentService->deletePayment($paymentId);
        return $this->sendResponse(null, "Payment deleted successfully");
    }

    public function forceDelete($paymentId)
    {
        $this->paymentService->forceDeletePayment($paymentId);
        return $this->sendResponse(null, "Payment deleted permanently");
    }

    public function restore($paymentId)
    {
        $payment = $this->paymentService->restorePayment($paymentId);
        return $this->sendResponse($payment, "Payment restored successfully");
    }
}
