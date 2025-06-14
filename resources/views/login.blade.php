<!DOCTYPE html>
<html lang="en">

<head>
    <script>
        (function () {
            const darkMode = localStorage.getItem('darkMode');
            if (darkMode === 'enabled') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<body>
    <a href="javascript:history.back()"
        style="position: absolute; top: 24px; left: 24px; z-index: 1000; text-decoration: none;">
        <button style="background: none; border: none; font-size: 2rem; color: var(--dark); cursor: pointer;">
            &#8592;
        </button>
    </a>
    <div class="circle circle1"></div>
    <div class="circle circle2"></div>
    <div class="circle circle3"></div>

    <form class="signup-container z-10" id="signupForm" action="{{ route('login.authenticate') }}" method='POST'>
        @csrf
        <div class="signup-title">Login</div>
        <div class="signup-subtitle">Selamat Datang Kembali</div>
        <div class="form-group">
            <label for="email">Email</label>
            <div class="input-icon-wrapper">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor">
                    <rect x="2" y="4" width="20" height="16" rx="3" ry="3" />
                    <path d="M22 6l-10 7L2 6" />
                </svg>
                <input type="email" id="email" name="email" required autocomplete="off" placeholder="Alamat email">
            </div>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-icon-wrapper">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor">
                    <path d="M16 10V7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7V10" />
                    <rect x="4" y="10" width="16" height="11" rx="2" />
                    <circle cx="12" cy="16" r="1" />
                </svg>
                <div style="position:relative;">
                    <input type="password" id="password" name="password" required autocomplete="off"
                        placeholder="Password" style="padding-right:40px;">
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
            </div>
        </div>
        <button type="submit" class="signup-btn" id="signupBtn">Login</button>
        <a href="{{ route('signup') }}" class="login-link">Belum punya akun? Daftar</a>
    </form>
</body>

@if ($errors->any())
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            background: '#ff3b3b',
            color: '#fff',
            iconColor: '#fff',
            confirmButtonColor: '#fff',
            confirmButtonText: 'OK',
            customClass: {
                icon: 'swal2-x-mark-animate'
            }
        });
    </script>
@endif

<script>
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
</script>

</html>