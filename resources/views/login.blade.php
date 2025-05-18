<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center relative overflow-x-hidden font-['Inter',Arial,sans-serif]">
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
    <script>
        // Kode negara untuk nomor hp
        const negaraSelect = document.getElementById('negara');
        const kodeNegaraInput = document.getElementById('kodeNegara');
        const nohpInput = document.getElementById('nohp');

        const kodeNegaraMap = {
            "Indonesia": "+62",
            "Malaysia": "+60",
            "Singapore": "+65",
            "Thailand": "+66",
            "Vietnam": "+84",
            "Brunei": "+673",
            "Philippines": "+63",
            "Cambodia": "+855",
            "Laos": "+856",
            "Myanmar": "+95",
            "Timor-Leste": "+670"
        };

        negaraSelect.addEventListener('change', function () {
            const kode = kodeNegaraMap[negaraSelect.value] || "";
            kodeNegaraInput.value = kode;
            nohpInput.value = "";
            nohpInput.disabled = !kode;
        });

        // Khusus angka di field nomor hp
        nohpInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Validasi password + tidak bisa submit jika password tidak sama
        const password = document.getElementById('password');
        const confirm = document.getElementById('password_confirmation');
        const btn = document.getElementById('signupBtn');
        const error = document.getElementById('password-error');

        function validatePassword() {
            if (password.value && confirm.value && password.value !== confirm.value) {
                btn.disabled = true;
                error.style.display = 'block';
            } else if (password.value && confirm.value && password.value === confirm.value) {
                btn.disabled = false;
                error.style.display = 'none';
            } else {
                btn.disabled = true;
                error.style.display = 'none';
            }
        }

        password.addEventListener('input', validatePassword);
        confirm.addEventListener('input', validatePassword);
        window.addEventListener('DOMContentLoaded', function () {
            validatePassword();
            kodeNegaraInput.value = "";
            nohpInput.disabled = true;
        });
    </script>
</body>

</html>