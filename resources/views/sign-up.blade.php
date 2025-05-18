<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up</title>
    @vite('resources/css/app.css')

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>

<body class="min-h-screen flex items-center justify-center relative overflow-x-hidden font-['Inter',Arial,sans-serif]">
    <div class="circle circle1"></div>
    <div class="circle circle2"></div>
    <div class="circle circle3"></div>

    <form class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8 space-y-4">
        <h2 class="text-2xl font-bold text-center text-[#186094] mb-2">Sign Up</h2>
        <p class="text-center text-[#003355] mb-4">Bergabunglah dengan TriadGO untuk ekspor & impor lebih mudah!</p>
        <!-- Nama -->
        <div>
            <label for="nama" class="block font-semibold text-[#003355] mb-1">Nama</label>
            <input type="text" id="nama" name="nama" required autocomplete="off" placeholder="Nama lengkap"
                class="w-full px-4 py-2 rounded-lg border border-[#186094] bg-[#FAF9F9] text-[#003355] focus:outline-none focus:border-[#EEA133] transition" />
        </div>
        <!-- Email -->
        <div>
            <label for="email" class="block font-semibold text-[#003355] mb-1">Email</label>
            <input type="email" id="email" name="email" required autocomplete="off" placeholder="Alamat email"
                class="w-full px-4 py-2 rounded-lg border border-[#186094] bg-[#FAF9F9] text-[#003355] focus:outline-none focus:border-[#EEA133] transition" />
        </div>
        <!-- Negara -->
        <div>
            <label for="negara" class="block font-semibold text-[#003355] mb-1">Negara</label>
            <select id="negara" name="negara" required
                class="w-full px-4 py-2 rounded-lg border border-[#186094] bg-[#FAF9F9] text-[#003355] focus:outline-none focus:border-[#EEA133] transition">
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
                <option value="Timor-Leste">Timor-Leste</option>
            </select>
        </div>
        <!-- No HP -->
        <div>
            <label for="nohp" class="block font-semibold text-[#003355] mb-1">No. HP</label>
            <div class="flex rounded-full border border-[#186094] bg-[#FAF9F9] overflow-hidden">
                <span class="flex items-center px-4 py-2 text-[#003355] font-semibold bg-[#FAF9F9] select-none">
                    +<span id="kodeNegara" class="ml-1"></span>
                </span>
                <div class="w-px bg-[#186094] h-auto my-2"></div>
                <input type="text" id="nohp" name="nohp" required autocomplete="off"
                    placeholder="Nomor tanpa 0 di depan"
                    class="flex-1 px-4 py-2 bg-transparent text-[#003355] focus:outline-none" pattern="[0-9]+"
                    inputmode="numeric" disabled>
            </div>
            <small class="text-xs text-[#186094]">Masukkan nomor tanpa angka 0 di depan</small>
        </div>
        <!-- Password -->
        <div>
            <label for="password" class="block font-semibold text-[#003355] mb-1">Password</label>
            <input type="password" id="password" name="password" required autocomplete="off" placeholder="Password"
                class="w-full px-4 py-2 rounded-lg border border-[#186094] bg-[#FAF9F9] text-[#003355] focus:outline-none focus:border-[#EEA133] transition" />
        </div>
        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block font-semibold text-[#003355] mb-1">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="off"
                placeholder="Ulangi password"
                class="w-full px-4 py-2 rounded-lg border border-[#186094] bg-[#FAF9F9] text-[#003355] focus:outline-none focus:border-[#EEA133] transition" />
            <span id="password-error" class="text-[#EEA133] text-sm hidden">Password tidak sama</span>
        </div>
        <!-- Role -->
        <div>
            <label class="block font-semibold text-[#003355] mb-1">Role</label>
            <div class="flex gap-6 mt-1">
                <label class="flex items-center gap-2 text-[#186094] font-medium cursor-pointer">
                    <input type="radio" name="role" value="ekspor" required class="accent-[#EEA133]" />
                    Ekspor
                </label>
                <label class="flex items-center gap-2 text-[#186094] font-medium cursor-pointer">
                    <input type="radio" name="role" value="impor" required class="accent-[#EEA133]" />
                    Impor
                </label>
            </div>
        </div>
        <button type="submit"
            class="w-full py-3 mt-4 rounded-lg bg-gradient-to-r from-[#186094] to-[#EEA133] text-white font-bold text-lg shadow hover:from-[#003355] hover:to-[#EEA133] transition"
            id="signupBtn" disabled>Daftar</button>
        <a href="login.html"
            class="block text-center mt-4 text-[#186094] hover:text-[#EEA133] font-medium transition">Sudah punya akun?
            Login</a>
    </form>
    <script>
        // Kode negara untuk nomor hp
        const negaraSelect = document.getElementById('negara');
        const kodeNegaraSpan = document.getElementById('kodeNegara');
        const nohpInput = document.getElementById('nohp');

        const kodeNegaraMap = {
            "Indonesia": "62",
            "Malaysia": "60",
            "Singapore": "65",
            "Thailand": "66",
            "Vietnam": "84",
            "Brunei": "673",
            "Philippines": "63",
            "Cambodia": "855",
            "Laos": "856",
            "Myanmar": "95",
            "Timor-Leste": "670"
        };

        negaraSelect.addEventListener('change', function () {
            const kode = kodeNegaraMap[negaraSelect.value] || "";
            kodeNegaraSpan.textContent = kode;
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