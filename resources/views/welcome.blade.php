<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Blog - Welcome</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
<div class="auth-container" style="text-align: center;">
    <h2>Welcome to Our Blog</h2>
    <p style="margin: 20px 0; color: #555; font-size: 18px;">
        Share your thoughts with the world
    </p>

    <div style="margin: 30px 0;">
        <a href="{{ route('login') }}" class="btn" style="display: inline-block; width: 45%; margin-right: 10px;">
            Login
        </a>
        <a href="{{ route('register') }}" class="btn" style="display: inline-block; width: 45%;">
            Register
        </a>
    </div>
</div>
</body>
</html>
