<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <a href="{{ route('register') }}">Register</a>
        
        <a href="{{ route('google.login') }}">
        <button style="background-color: #db4437; color: white;">Login with Google</button>
        </a>
        <a href="{{ route('facebook.login') }}">
            <button style="background-color: #4267B2; color: white;">Login with Facebook</button>
        </a>

    </div>
</body>
</html>
