<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        (function() {
            const darkMode = localStorage.getItem('darkMode');
            if (darkMode === 'enabled') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        accent: '#f97316',
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-10px)'
                            },
                        }
                    }
                },
            },
        }

        tailwind.scan()
    </script>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.min.css" />
    @vite('resources/css/app.css')
</head>

<body>
    <a href="javascript:history.back()"
        style="position: absolute; top: 24px; left: 24px; z-index: 1000; text-decoration: none;">
        <button style="background: none; border: none; font-size: 2rem; color: #f59e0b; cursor: pointer;">
            &#8592;
        </button>
    </a>
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
            <label for="name" style="color: var(--dark);">Nama</label>
            <input type="text" id="name" name="name" required autocomplete="off" placeholder="Nama lengkap">
        </div>
        
        <div class="form-group">
            <label for="email" style="color: var(--dark);">Email</label>
            <input type="email" id="email" name="email" required autocomplete="off" placeholder="Alamat email">
        </div>
        
        <div class="form-group">
            <label for="country" style="color: var(--dark);">Negara</label>
            <select id="country" name="country" required style="color: var(--dark);">
                <option value="">Pilih negara</option>
                <option value="Indonesia" data-code="id" data-dial="+62">Indonesia</option>
                <option value="Malaysia" data-code="my" data-dial="+60">Malaysia</option>
                <option value="Singapore" data-code="sg" data-dial="+65">Singapore</option>
                <option value="Thailand" data-code="th" data-dial="+66">Thailand</option>
                <option value="Vietnam" data-code="vn" data-dial="+84">Vietnam</option>
                <option value="Brunei" data-code="bn" data-dial="+673">Brunei</option>
                <option value="Philippines" data-code="ph" data-dial="+63">Philippines</option>
                <option value="Cambodia" data-code="kh" data-dial="+855">Cambodia</option>
                <option value="Laos" data-code="la" data-dial="+856">Laos</option>
                <option value="Myanmar" data-code="mm" data-dial="+95">Myanmar</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="phone" style="color: var(--dark);">No. HP</label>
            <input id="phone" name="phone" type="tel" required autocomplete="off" placeholder="Nomor HP">
            <div id="phone-error" style="color: red; font-size: 0.85em; margin-top: 5px; display: none;"></div>
        </div>
        
        <div class="form-group">
            <label for="password" style="color: var(--dark);">Password</label>
            <div style="position:relative;">
                <input type="password" id="password" name="password" required autocomplete="off" placeholder="Password"
                    style="padding-right:40px;">
                <span id="togglePassword"
                    style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer; width:28px; height:28px; display:flex; align-items:center;">
                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" style="display:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1.5 12s4-7.5 10.5-7.5S22.5 12 22.5 12s-4 7.5-10.5 7.5S1.5 12 1.5 12z" />
                        <circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="2" fill="none" />
                    </svg>
                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" style="display:block;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1.5 12s4-7.5 10.5-7.5S22.5 12 22.5 12s-4 7.5-10.5 7.5S1.5 12 1.5 12z" />
                        <circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="2" fill="none" />
                        <line x1="5" y1="19" x2="19" y2="5" stroke="currentColor" stroke-width="2" />
                    </svg>
                </span>
            </div>
            <span id="password-length-error" style="color:#EEA133; font-size:0.95em; display:none;">Password minimal 8 karakter</span>
        </div>
        
        <div class="form-group">
            <label for="password_confirmation" style="color: var(--dark);">Confirm Password</label>
            <div style="position:relative;">
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    autocomplete="off" placeholder="Ulangi password" style="padding-right:40px;">
                <span id="toggleConfirmPassword"
                    style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer; width:28px; height:28px; display:flex; align-items:center;">
                    <svg id="eyeOpenConfirm" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" style="display:none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1.5 12s4-7.5 10.5-7.5S22.5 12 22.5 12s-4 7.5-10.5 7.5S1.5 12 1.5 12z" />
                        <circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="2" fill="none" />
                    </svg>
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
            <label style="color: var(--dark);">Role</label>
            <div class="role-group" style="display:flex; gap:20px;">
                <label class="custom-checkbox" style="color: var(--dark);">
                    <input type="radio" name="role" value="ekspor" required>
                    <span class="checkmark"></span>
                    Ekspor
                </label>
                <label class="custom-checkbox" style="color: var(--dark);">
                    <input type="radio" name="role" value="impor" required>
                    <span class="checkmark"></span>
                    Impor
                </label>
            </div>
        </div>
        
        <button type="submit" class="signup-btn" id="signupBtn" disabled>Daftar</button>
        <a href="{{ route('login') }}" class="login-link" style="color: var(--dark);">Sudah punya akun? Login</a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
    <script>
        // Konfigurasi negara ASEAN dengan validasi yang tepat
        const countryConfig = {
            'Indonesia': { code: 'id', dial: '+62', minLength: 9, maxLength: 13, pattern: /^[0-9]{9,13}$/ },
            'Malaysia': { code: 'my', dial: '+60', minLength: 9, maxLength: 11, pattern: /^[0-9]{9,11}$/ },
            'Singapore': { code: 'sg', dial: '+65', minLength: 8, maxLength: 8, pattern: /^[0-9]{8}$/ },
            'Thailand': { code: 'th', dial: '+66', minLength: 9, maxLength: 9, pattern: /^[0-9]{9}$/ },
            'Vietnam': { code: 'vn', dial: '+84', minLength: 9, maxLength: 10, pattern: /^[0-9]{9,10}$/ },
            'Brunei': { code: 'bn', dial: '+673', minLength: 7, maxLength: 7, pattern: /^[0-9]{7}$/ },
            'Philippines': { code: 'ph', dial: '+63', minLength: 10, maxLength: 10, pattern: /^[0-9]{10}$/ },
            'Cambodia': { code: 'kh', dial: '+855', minLength: 8, maxLength: 9, pattern: /^[0-9]{8,9}$/ },
            'Laos': { code: 'la', dial: '+856', minLength: 8, maxLength: 10, pattern: /^[0-9]{8,10}$/ },
            'Myanmar': { code: 'mm', dial: '+95', minLength: 9, maxLength: 10, pattern: /^[0-9]{9,10}$/ }
        };

        const phoneInput = document.querySelector("#phone");
        const countrySelect = document.getElementById('country');
        const phoneError = document.getElementById('phone-error');
        
        // Initialize intl-tel-input
        const iti = window.intlTelInput(phoneInput, {
            initialCountry: "id",
            onlyCountries: ["id", "my", "sg", "th", "vn", "bn", "ph", "kh", "la", "mm"],
            nationalMode: false,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js"
        });

        // Sinkronisasi dropdown negara dengan intl-tel-input
        countrySelect.addEventListener('change', function() {
            const selectedCountry = this.value;
            if (selectedCountry && countryConfig[selectedCountry]) {
                const config = countryConfig[selectedCountry];
                iti.setCountry(config.code);
                phoneInput.placeholder = `Contoh: ${getPlaceholder(selectedCountry)}`;
                validatePhone();
            }
        });

        // Update dropdown negara ketika flag berubah
        phoneInput.addEventListener('countrychange', function() {
            const countryData = iti.getSelectedCountryData();
            const countryName = getCountryNameByCode(countryData.iso2);
            if (countryName) {
                countrySelect.value = countryName;
            }
        });

        // Fungsi untuk mendapatkan nama negara berdasarkan kode
        function getCountryNameByCode(code) {
            for (const [name, config] of Object.entries(countryConfig)) {
                if (config.code === code) {
                    return name;
                }
            }
            return null;
        }

        // Fungsi untuk mendapatkan placeholder contoh nomor
        function getPlaceholder(country) {
            const examples = {
                'Indonesia': '081234567890',
                'Malaysia': '0123456789',
                'Singapore': '91234567',
                'Thailand': '812345678',
                'Vietnam': '912345678',
                'Brunei': '7123456',
                'Philippines': '9171234567',
                'Cambodia': '12345678',
                'Laos': '20123456',
                'Myanmar': '912345678'
            };
            return examples[country] || '123456789';
        }

        // Validasi nomor telepon
        function validatePhone() {
            const selectedCountry = countrySelect.value;
            const phoneNumber = phoneInput.value.replace(/\D/g, ''); // Hapus semua non-digit
            
            if (!selectedCountry || !phoneNumber) {
                phoneError.style.display = 'none';
                return true;
            }

            const config = countryConfig[selectedCountry];
            if (!config) {
                phoneError.textContent = 'Negara tidak valid';
                phoneError.style.display = 'block';
                return false;
            }

            // Validasi panjang dan pola
            if (phoneNumber.length < config.minLength || phoneNumber.length > config.maxLength) {
                phoneError.textContent = `Nomor HP harus ${config.minLength}-${config.maxLength} digit untuk ${selectedCountry}`;
                phoneError.style.display = 'block';
                return false;
            }

            if (!config.pattern.test(phoneNumber)) {
                phoneError.textContent = `Format nomor HP tidak valid untuk ${selectedCountry}`;
                phoneError.style.display = 'block';
                return false;
            }

            phoneError.style.display = 'none';
            return true;
        }

        // Event listener untuk validasi real-time
        phoneInput.addEventListener('input', validatePhone);
        phoneInput.addEventListener('blur', validatePhone);

        // Validasi password
        const password = document.getElementById('password');
        const confirm = document.getElementById('password_confirmation');
        const btn = document.getElementById('signupBtn');
        const error = document.getElementById('password-error');

        function validatePassword() {
            let isValid = true;

            if (password.value && password.value.length < 8) {
                document.getElementById('password-length-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('password-length-error').style.display = 'none';
            }

            if (password.value && confirm.value && password.value !== confirm.value) {
                btn.disabled = true;
                error.style.display = 'block';
                isValid = false;
            } else if (password.value && confirm.value && password.value === confirm.value) {
                error.style.display = 'none';
            } else {
                error.style.display = 'none';
            }

            const phoneValid = validatePhone();
            btn.disabled = !(password.value.length >= 8 && password.value === confirm.value && phoneValid);
        }

        password.addEventListener('input', validatePassword);
        confirm.addEventListener('input', validatePassword);

        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        togglePassword.addEventListener('click', function() {
            const isHidden = password.type === 'password';
            password.type = isHidden ? 'text' : 'password';
            eyeOpen.style.display = isHidden ? 'block' : 'none';
            eyeClosed.style.display = isHidden ? 'none' : 'block';
        });

        const confirmPasswordInput = document.getElementById('password_confirmation');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const eyeOpenConfirm = document.getElementById('eyeOpenConfirm');
        const eyeClosedConfirm = document.getElementById('eyeClosedConfirm');

        toggleConfirmPassword.addEventListener('click', function() {
            const isHidden = confirmPasswordInput.type === 'password';
            confirmPasswordInput.type = isHidden ? 'text' : 'password';
            eyeOpenConfirm.style.display = isHidden ? 'block' : 'none';
            eyeClosedConfirm.style.display = isHidden ? 'none' : 'block';
        });

        // Form submission
        document.getElementById('signupForm').addEventListener('submit', function(e) {
            const phoneValid = validatePhone();
            
            if (!phoneValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Nomor HP tidak valid!',
                    text: 'Silakan periksa nomor HP Anda.',
                    background: '#e3342f',
                    color: '#ffffff'
                });
                phoneInput.focus();
                return false;
            }

            // Set nomor telepon dengan format internasional
            const fullNumber = iti.getNumber();
            phoneInput.value = fullNumber;
        });

        // Initialize
        window.addEventListener('DOMContentLoaded', function() {
            validatePassword();
            validatePhone();
        });
    </script>
</body>

</html>