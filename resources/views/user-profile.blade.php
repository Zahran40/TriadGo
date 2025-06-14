@php
    $country = Auth::user()->country ?? '';
    $phone = Auth::user()->phone ?? '';

    $countryCodes = [
        'Indonesia' => '+62',
        'Malaysia' => '+60',
        'Singapore' => '+65',
        'Thailand' => '+66',
        'Vietnam' => '+84',
        'Brunei' => '+673',
        'Philippines' => '+63',
        'Cambodia' => '+855',
        'Laos' => '+856',
        'Myanmar' => '+95',
        'Timor-Leste' => '+670'
    ];
    $countryCode = $countryCodes[$country] ?? '';
    $displayPhone = $phone ? ($countryCode . $phone) : '-';
    $role = Auth::user()->role ?? 'User';
@endphp

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
    <title>User Profile - TriadGO</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="profile-container">
        <div class="profile-header">
            <h2>User Profile</h2>
        </div>
        <img src="{{ Auth::user()->avatar_url ?? 'https://randomuser.me/api/portraits/men/32.jpg' }}" alt="User Avatar"
            class="avatar">
        <div class="profile-name">{{ Auth::user()->name }}</div>
        <div class="profile-info"><br>
            <label>Email</label>
            <p>{{ Auth::user()->email }}</p>

            <label>Phone</label>
            <p>{{ $displayPhone }}</p>

            <label>Country</label>
            <p>{{ $country ?: '-' }}</p>

            <label>Role</label>
            <p>{{ $role }}</p>

        </div>
        <a href="#">
            <button class="edit-btn">Edit Profile</button>
        </a>
    </div>
</body>

</html>