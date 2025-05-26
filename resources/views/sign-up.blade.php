<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.min.css" />
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
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" required autocomplete="off" placeholder="Nama lengkap">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required autocomplete="off" placeholder="Alamat email">
        </div>
        <div class="form-group">
            <label for="country">Negara</label>
            <select id="country" name="country" required>
                <option value="">Pilih negara</option>
                <option value="Indonesia">Indonesia</option>
                <option value="Malaysia">Malaysia</option>
                <option value="Singapore">Singapore</option>
                <option value="Thailand">Thailand</option>
                <option value="Vietnam">Vietnam</option>
                <option value="Brunei">Brunei</option>
                <option value="Philippines">Philippines</option>
                <option value="Cambodia">Cambodia</option>
                <option value="Laos">Laos</option>
                <option value="Myanmar">Myanmar</option>
            </select>
        </div>
        <div class="form-group">
            <label for="phone">No. HP</label>
            <div style="display: flex; align-items: center; gap: 8px;">
                <!-- Kode negara (readonly, otomatis) -->
                <input type="text" id="country_code" name="country_code" readonly
                    style="width: 80px; text-align: center; border: 1px solid #ccc;">
                <!-- Input nomor HP (tanpa kode negara) -->
                <input id="phone" name="phone" type="tel" required autocomplete="off" placeholder="Nomor HP"
                    style="flex:1;">
            </div>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <div style="position:relative;">
                <input type="password" id="password" name="password" required autocomplete="off" placeholder="Password"
                    style="padding-right:40px;">
                <span id="togglePassword"
                    style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer; width:28px; height:28px; display:flex; align-items:center;">
                    <!-- Show Password -->
                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" style="display:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1.5 12s4-7.5 10.5-7.5S22.5 12 22.5 12s-4 7.5-10.5 7.5S1.5 12 1.5 12z" />
                        <circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="2" fill="none" />
                    </svg>
                    <!-- Hide Password -->
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
                    <!-- Show Password -->
                    <svg id="eyeOpenConfirm" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" style="display:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1.5 12s4-7.5 10.5-7.5S22.5 12 22.5 12s-4 7.5-10.5 7.5S1.5 12 1.5 12z" />
                        <circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="2" fill="none" />
                    </svg>
                    <!-- Hide Password -->
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
            <div class="role-group" style="display:flex; gap:20px;">
                <label class="custom-checkbox">
                    <input type="radio" name="role" value="ekspor" required>
                    <span class="checkmark"></span>
                    Ekspor
                </label>
                <label class="custom-checkbox">
                    <input type="radio" name="role" value="impor" required>
                    <span class="checkmark"></span>
                    Impor
                </label>
            </div>
        </div>
        <button type="submit" class="btn-gradient-move signup-btn" id="signupBtn" disabled>Daftar</button>
        <a href="{{ route('login') }}" class="login-link">Sudah punya akun? Login</a>
    </form>
    <script>
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

    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
    <script>
        const aseanCountries = [
            "id", // Indonesia
            "my", // Malaysia
            "sg", // Singapore
            "th", // Thailand
            "vn", // Vietnam
            "bn", // Brunei
            "ph", // Philippines
            "kh", // Cambodia
            "la", // Laos
            "mm"  // Myanmar
        ];

        const input = document.querySelector("#phone");
        const countryCodeInput = document.getElementById('country_code');
        const iti = window.intlTelInput(input, {
            initialCountry: "id",
            onlyCountries: aseanCountries,
            nationalMode: true, // agar input hanya nomor lokal
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
            formatOnDisplay: false
        });

        // Mengganti kode negara sesuai dengan bendera yang dipilih
        function updateCountryCode() {
            const dialCode = iti.getSelectedCountryData().dialCode;
            countryCodeInput.value = '+' + dialCode;
        }

        input.addEventListener('countrychange', updateCountryCode);
        window.addEventListener('DOMContentLoaded', updateCountryCode);

        // Validasi dan submit
        document.getElementById('signupForm').addEventListener('submit', function (e) {
            if (!iti.isValidNumber()) {
                e.preventDefault();
                alert('Nomor HP tidak valid!');
                input.focus();
                return false;
            }
            // Set kode negara (untuk jaga-jaga jika user submit tanpa ganti negara)
            updateCountryCode();
            // Input nomor hp hanya nomor lokal (tanpa kode negara)
            input.value = iti.getNumber('national').replace(/\D/g, '');
        });
    </script>
</body>

</html>