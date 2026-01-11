<!DOCTYPE html>
<html>
<head>
    <title>Payment Failed</title>
    <style>
        body { font-family: Arial; text-align: center; padding: 50px; }
        .failed { color: #f44336; font-size: 48px; }
    </style>
</head>
<body>
    <div class="failed">❌</div>
    <h1>Payment Failed</h1>
    <p>Something went wrong with your payment.</p>
    <a href="{{ route('home') }}">Try Again</a>
</body>
</html>
