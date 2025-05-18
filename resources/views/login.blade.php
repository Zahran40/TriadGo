<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<body class="auth-bg">
    <div class="circle circle1"></div>
    <div class="circle circle2"></div>
    <div class="circle circle3"></div>

    <form class="signup-container z-10" id="signupForm">
        <div class="signup-title">Login</div>
        <div class="signup-subtitle">Selamat Datang Kembali</div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required autocomplete="off" placeholder="Alamat email">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required autocomplete="off" placeholder="Password">
        </div>
        <button type="submit" class="signup-btn" id="signupBtn" disabled>Login</button>
        <a href="{{ route('signup') }}" class="login-link">Belum punya akun? Daftar</a>
    </form>
</body>

</html>