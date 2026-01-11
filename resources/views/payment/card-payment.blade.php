<!DOCTYPE html>
<html>
<head>
    <title>Card Payment</title>
    <style>
        body { font-family: Arial; padding: 20px; max-width: 500px; margin: 0 auto; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #4CAF50; color: white; padding: 12px; border: none; width: 100%; cursor: pointer; }
        .error { background: #ffebee; color: #c62828; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .note { background: #e8f5e9; padding: 10px; border-radius: 5px; margin: 20px 0; }
    </style>
</head>
<body>
    <h2>💳 Card Payment</h2>
    <a href="/">← Back</a>

    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <div class="note">
        <strong>Note:</strong> You will be redirected to Paystack's secure page to complete payment.
    </div>

    <form action="{{ route('payment.process.card') }}" method="POST" id="paymentForm">
        @csrf

        <div class="form-group">
            <label>Amount (GHS)</label>
            <input type="number" name="amount" value="100" step="0.01" required>
        </div>

        <div class="form-group">
            <label>Card Number</label>
            <input type="text" name="card_number" value="4567901109631750" required>
        </div>

        <div style="display: flex; gap: 10px;">
            <div style="flex: 1;">
                <label>Expiry Month</label>
                <input type="text" name="expiry_month" value="04" required>
            </div>
            <div style="flex: 1;">
                <label>Expiry Year</label>
                <input type="text" name="expiry_year" value="2026" required>
            </div>
            <div style="flex: 1;">
                <label>CVV</label>
                <input type="password" name="cvv" value="787" required>
            </div>
        </div>

        <button type="submit" id="submitBtn">Proceed to Paystack</button>
    </form>

    <script>
        document.getElementById('paymentForm').addEventListener('submit', function() {
            document.getElementById('submitBtn').textContent = 'Redirecting to Paystack...';
            document.getElementById('submitBtn').disabled = true;
        });
    </script>
</body>
</html>
