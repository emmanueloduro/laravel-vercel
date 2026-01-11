<!DOCTYPE html>
<html>
<head>
    <title>Mobile Money Payment</title>
    <style>
        body { font-family: Arial; max-width: 500px; margin: 0 auto; padding: 20px; }
        input, button { width: 100%; padding: 10px; margin: 10px 0; }
        button { background: #4CAF50; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h2>📱 Mobile Money Payment</h2>
    <a href="{{ route('home') }}">← Back</a>

    <form action="{{ route('payment.process.mobile-money') }}" method="POST">
        @csrf
        <input type="number" name="amount" placeholder="Amount (GHS)" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="tel" name="phone" placeholder="Phone (0501234567)" required>
        <button type="submit">Pay with Mobile Money</button>
    </form>
</body>
</html>
