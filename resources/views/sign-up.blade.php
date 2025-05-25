<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up</title>
    @vite('resources/css/app.css')
</head>

<body class="auth-bg">
    <div class="circle circle1"></div>
    <div class="circle circle2"></div>
    <div class="circle circle3"></div>

    @if ($errors->any())
        <div style="color:red; margin-bottom:10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="signup-container z-10" id="signupForm" action="{{ route('signup.store') }}" method='POST'>
        @csrf
        <div class="signup-title">Sign Up</div>
        <div class="signup-subtitle">Bergabunglah dengan TriadGO untuk ekspor & impor lebih mudah!</div>
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="name" name="name" required autocomplete="off" placeholder="Nama lengkap">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required autocomplete="off" placeholder="Alamat email">
        </div>
        <div class="form-group">
            <label for="negara">Negara</label>
            <select id="country" name="country" required>
                <option value="">Pilih negara</option>
                <option value="Indonesia" data-code="+62">Indonesia</option>
                <option value="Malaysia" data-code="+60">Malaysia</option>
                <option value="Singapore" data-code="+65">Singapore</option>
                <option value="Thailand" data-code="+66">Thailand</option>
                <option value="Vietnam" data-code="+84">Vietnam</option>
                <option value="Brunei" data-code="+673">Brunei</option>
                <option value="Philippines" data-code="+63">Philippines</option>
                <option value="Cambodia" data-code="+855">Cambodia</option>
                <option value="Laos" data-code="+856">Laos</option>
                <option value="Myanmar" data-code="+95">Myanmar</option>
                <option value="Timor-Leste" data-code="+670">Timor-Leste</option>
            </select>
        </div>
        <div class="form-group" id='phone' name='phone'>
            <label for="nohp">No. HP</label>
            <div class="flex">
                <input type="text" id="kodeNegara" name="kodeNegara"
                    class="w-20 px-2 py-2 rounded-l-lg border border-[#186094] bg-[#FAF9F9] text-[#003355] font-semibold text-center"
                    value="" readonly tabindex="-1">
                <input type="text" id="phone" name="phone" required autocomplete="off" placeholder="Nomor HP"
                    class="flex-1 px-4 py-2 rounded-r-lg border-t border-b border-r border-[#186094] bg-[#FAF9F9] text-[#003355] focus:outline-none focus:border-[#EEA133] transition"
                    pattern="[0-9]+" inputmode="numeric">
            </div>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <div style="position:relative;">
                <input type="password" id="password" name="password" required autocomplete="off" placeholder="Password"
                    style="padding-right:40px;">
                <span id="togglePassword"
                    style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer; width:28px; height:28px; display:flex; align-items:center;">
                    <!-- Mata terbuka -->
                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" style="display:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1.5 12s4-7.5 10.5-7.5S22.5 12 22.5 12s-4 7.5-10.5 7.5S1.5 12 1.5 12z" />
                        <circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="2" fill="none" />
                    </svg>
                    <!-- Mata silang -->
                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" style="display:block;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1.5 12s4-7.5 10.5-7.5S22.5 12 22.5 12s-4 7.5-10.5 7.5S1.5 12 1.5 12z" />
                        <circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="2" fill="none" />
                        <line x1="5" y1="19" x2="19" y2="5" stroke="currentColor" stroke-width="2" />
                    </svg>
                </span>
            </div>
            <span id="password-length-error" style="color:#EEA133; font-size:0.95em; display:none;">Password minimal 8
                karakter</span>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <div style="position:relative;">
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    autocomplete="off" placeholder="Ulangi password" style="padding-right:40px;">
                <span id="toggleConfirmPassword"
                    style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer; width:28px; height:28px; display:flex; align-items:center;">
                    <!-- Mata terbuka -->
                    <svg id="eyeOpenConfirm" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" style="display:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1.5 12s4-7.5 10.5-7.5S22.5 12 22.5 12s-4 7.5-10.5 7.5S1.5 12 1.5 12z" />
                        <circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="2" fill="none" />
                    </svg>
                    <!-- Mata silang -->
                    <svg id="eyeClosedConfirm" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" style="display:block;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1.5 12s4-7.5 10.5-7.5S22.5 12 22.5 12s-4 7.5-10.5 7.5S1.5 12 1.5 12z" />
                        <circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="2" fill="none" />
                        <line x1="5" y1="19" x2="19" y2="5" stroke="currentColor" stroke-width="2" />
                    </svg>
                </span>
            </div>
            <span id="password-error" style="color:#EEA133; font-size:0.95em; display:none;">Password tidak sama</span>
        </div>
        <div class="form-group">
            <label>Role</label>
            <div class="role-group">
                <label><input type="radio" name="role" value="ekspor" required> Ekspor</label>
                <label><input type="radio" name="role" value="impor" required> Impor</label>
            </div>
        </div>
        <button type="submit" class="btn-gradient-move signup-btn" id="signupBtn" disabled>Daftar</button>
        <a href="{{ route('login') }}" class="login-link">Sudah punya akun? Login</a>
    </form>
    <script>
        // Kode negara untuk nomor hp
        const negaraSelect = document.getElementById('country');
        const kodeNegaraInput = document.getElementById('kodeNegara');
        const nohpInput = document.getElementById('phone');

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
            let isValid = true;

            // Validasi panjang password
            if (password.value && password.value.length < 8) {
                document.getElementById('password-length-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('password-length-error').style.display = 'none';
            }

            // Validasi konfirmasi password
            if (password.value && confirm.value && password.value !== confirm.value) {
                btn.disabled = true;
                error.style.display = 'block';
                isValid = false;
            } else if (password.value && confirm.value && password.value === confirm.value) {
                error.style.display = 'none';
            } else {
                error.style.display = 'none';
            }

            // Tombol hanya aktif jika password cukup panjang dan konfirmasi sama
            btn.disabled = !(password.value.length >= 8 && password.value === confirm.value);
        }

        password.addEventListener('input', validatePassword);
        confirm.addEventListener('input', validatePassword);
        window.addEventListener('DOMContentLoaded', function () {
            validatePassword();
            kodeNegaraInput.value = "";
            nohpInput.disabled = true;
        });

        // Toggle Password
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        togglePassword.addEventListener('click', function () {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            eyeOpen.style.display = isHidden ? 'block' : 'none';
            eyeClosed.style.display = isHidden ? 'none' : 'block';
        });

        // Toggle Confirm Password
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const eyeOpenConfirm = document.getElementById('eyeOpenConfirm');
        const eyeClosedConfirm = document.getElementById('eyeClosedConfirm');

        toggleConfirmPassword.addEventListener('click', function () {
            const isHidden = confirmPasswordInput.type === 'password';
            confirmPasswordInput.type = isHidden ? 'text' : 'password';
            eyeOpenConfirm.style.display = isHidden ? 'block' : 'none';
            eyeClosedConfirm.style.display = isHidden ? 'none' : 'block';
        });
    </script>
</body>

</html>