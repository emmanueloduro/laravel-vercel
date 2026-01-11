{{-- resources/views/payment/processing.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Processing Payment</title>
    <style>
        body { font-family: Arial; text-align: center; padding: 50px; background: #f5f5f5; }
        .loader { border: 5px solid #f3f3f3; border-top: 5px solid #4CAF50; border-radius: 50%; width: 50px; height: 50px; animation: spin 1s linear infinite; margin: 20px auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .info-box { background: white; padding: 20px; border-radius: 10px; max-width: 400px; margin: 20px auto; text-align: left; }
        .success { color: #4CAF50; }
    </style>
</head>
<body>
    <div class="loader"></div>
    <h2>Processing Payment...</h2>
    <p>Please wait while we process your payment</p>

    <div class="info-box">
        <p><strong>Reference:</strong> {{ $reference }}</p>
        <p><strong>Amount:</strong> GHS {{ $amount }}</p>
        <p><strong>Card:</strong> **** **** **** {{ $card_data['last4'] ?? 'XXXX' }}</p>
        <p><strong>Expiry:</strong> {{ $card_data['expiry'] ?? 'MM/YY' }}</p>
    </div>

    <script>
        // Simulate payment processing
        setTimeout(function() {
            window.location.href = "{{ route('payment.success') }}";
        }, 3000); // 3 seconds delay

        // Optional: Show countdown
        let countdown = 3;
        setInterval(function() {
            document.querySelector('p').innerHTML = `Redirecting in ${countdown} seconds...`;
            countdown--;
        }, 1000);
    </script>
</body>
</html>
