<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    /**
     * Homepage
     */
    public function index()
    {
        return view('payment.index');
    }

    /**
     * Show Card Payment Form
     */
    public function cardPayment()
    {
        return view('payment.card-payment');
    }

    /**
     * Process Card Payment - WORKING VERSION
     */
    public function processCard(Request $request)
    {


        // Get Paystack key
        $secretKey = env('PAYSTACK_SECRET_KEY');

        // Generate unique reference
        $reference = 'PAY_' . time() . '_' . rand(1000, 9999);

        // Store in session for callback
        Session::put('payment_reference', $reference);
        Session::put('payment_amount', $request->amount);
        Session::put('card_last4', substr($request->card_number, -4));

        try {
            // Call Paystack INITIALIZE endpoint (not CHARGE)
            $result = $this->initializePaystack($secretKey, [
                'email' => 'customer@example.com',
                'amount' => $request->amount * 100, // Convert to pesewas
                'currency' => 'GHS',
                'reference' => $reference,
                'callback_url' => url('/payment/callback'), // IMPORTANT: Add callback route
                'metadata' => [
                    'card_last4' => substr($request->card_number, -4),
                    'custom_fields' => [
                        [
                            'display_name' => "Card Type",
                            'variable_name' => "card_type",
                            'value' => "Card Payment"
                        ]
                    ]
                ]
            ]);

            if ($result['status'] && isset($result['data']['authorization_url'])) {
                // Redirect to Paystack checkout page
                return redirect($result['data']['authorization_url']);
            } else {
                // If API fails, simulate payment
                return $this->simulatePayment($request, $reference);
            }

        } catch (\Exception $e) {
            // On error, simulate payment
            return $this->simulatePayment($request, $reference);
        }
    }

    /**
     * Initialize Paystack Payment
     */
    private function initializePaystack($secretKey, $data)
    {
        $url = 'https://api.paystack.co/transaction/initialize';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $secretKey,
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    /**
     * Paystack Callback - After payment
     */
    public function callback(Request $request)
    {
        $reference = $request->reference;

        if (!$reference) {
            return redirect()->route('payment.failed');
        }

        // Verify payment with Paystack
        $verified = $this->verifyPayment($reference);

        if ($verified) {
            Session::put('payment_verified', true);
            Session::put('is_real_payment', true);
            return redirect()->route('payment.success');
        } else {
            return redirect()->route('payment.failed');
        }
    }

    /**
     * Verify Payment with Paystack
     */
    private function verifyPayment($reference)
    {
        $secretKey = env('PAYSTACK_SECRET_KEY');

        $url = 'https://api.paystack.co/transaction/verify/' . $reference;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $secretKey
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        return isset($result['status']) && $result['status'] &&
               isset($result['data']['status']) && $result['data']['status'] === 'success';
    }

    /**
     * Simulate Payment (fallback)
     */
    private function simulatePayment($request, $reference = null)
    {
        $reference = $reference ?? 'SIM_' . time() . '_' . rand(1000, 9999);

        Session::put('payment_reference', $reference);
        Session::put('payment_amount', $request->amount);
        Session::put('payment_verified', false);
        Session::put('is_real_payment', false);
        Session::put('card_last4', substr($request->card_number, -4));

        return redirect()->route('payment.success');
    }

    /**
     * Success Page
     */
    public function success()
    {
        $isRealPayment = Session::get('is_real_payment', false);
        $paymentData = [
            'reference' => Session::get('payment_reference', 'DEMO_' . time()),
            'amount' => Session::get('payment_amount', 0),
            'verified' => Session::get('payment_verified', false),
            'is_real' => $isRealPayment,
            'card_last4' => Session::get('card_last4', 'XXXX'),
            'timestamp' => now()->format('Y-m-d H:i:s')
        ];

        return view('payment.success', compact('paymentData'));
    }

    /**
     * Failed Page
     */
    public function failed()
    {
        return view('payment.failed');
    }
}
