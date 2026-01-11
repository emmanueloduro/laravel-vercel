<!DOCTYPE html>
<html>
<head>
    <title>Payment Status</title>
    <style>
        body { font-family: Arial; text-align: center; padding: 50px; }
        .real { color: #4CAF50; }
        .simulated { color: #FF9800; }
        .info-box { background: #f9f9f9; padding: 20px; border-radius: 10px; max-width: 500px; margin: 20px auto; text-align: left; }
    </style>
</head>
<body>
    @if($paymentData['verified'])
        <div style="color: #4CAF50; font-size: 60px;">✅</div>
        <h1 class="real">REAL Payment Successful!</h1>
        <p><strong>💰 Money should be in your Paystack account</strong></p>
    @else
        <div style="color: #FF9800; font-size: 60px;">⚠️</div>
        <h1 class="simulated">SIMULATED Payment</h1>
        <p><strong>❌ No real money was transferred</strong></p>
    @endif

    <div class="info-box">
        <p><strong>Reference:</strong> {{ $paymentData['reference'] }}</p>
        <p><strong>Amount:</strong> GHS {{ $paymentData['amount'] }}</p>
        <p><strong>Type:</strong> {{ $paymentData['type'] ?? 'Standard' }}</p>
        <p><strong>Status:</strong> {{ $paymentData['verified'] ? 'REAL Payment' : 'SIMULATION Only' }}</p>
        <p><strong>Time:</strong> {{ $paymentData['timestamp'] }}</p>
    </div>

    @if(!$paymentData['verified'])
        <div style="background: #fff3cd; padding: 15px; border-radius: 5px; max-width: 500px; margin: 20px auto;">
            <h3>⚠️ Next Steps for REAL Payments:</h3>
            <ol style="text-align: left;">
                <li>Sign up at <a href="https://paystack.com" target="_blank">paystack.com</a></li>
                <li>Get your API keys from Paystack dashboard</li>
                <li>Add keys to your .env file</li>
                <li>Test with real payment</li>
            </ol>
        </div>
    @endif

    <a href="{{ route('home') }}" style="padding: 10px 20px; background: #2196F3; color: white; text-decoration: none; border-radius: 5px;">
        Make Another Payment
    </a>
</body>
</html>
