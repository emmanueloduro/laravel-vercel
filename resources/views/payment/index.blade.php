<!DOCTYPE html>
<html>
<head>
    <title>Payment Options - Ghana</title>
    <style>
        body { font-family: Arial; padding: 20px; text-align: center; }
        .options { display: flex; justify-content: center; gap: 20px; margin-top: 40px; }
        .option { padding: 30px; border: 2px solid #ddd; border-radius: 10px; width: 200px; text-decoration: none; color: #333; }
        .option:hover { border-color: #4CAF50; background: #f9f9f9; }
        h1 { color: #333; }
    </style>
</head>
<body>
    <h1>🇬🇭 Choose Payment Method</h1>
    <p>Select how you want to pay</p>

    <div class="options">
        <a href="#" class="option">
            <h3>📱 Mobile Money</h3>
            <p>Pay with MTN, Vodafone, AirtelTigo</p>
        </a>

        <a href="{{ route('payment.card') }}" class="option">
            <h3>💳 Card</h3>
            <p>Visa, Mastercard, Verve</p>
        </a>

        <a href="#" class="option">
            <h3>🏦 Bank Transfer</h3>
            <p>Direct bank transfer</p>
        </a>
    </div>
</body>
</html>
