<!DOCTYPE html>
<html lang="en">

<head>
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
        <div class="profile-role">{{ Auth::user()->role ?? 'User' }}</div>
        <div class="profile-info">
            <label>Email</label>
            <p>{{ Auth::user()->email }}</p>
            <label>Phone</label>
            <p>{{ Auth::user()->phone ?? '-' }}</p>
            <label>Country</label>
            <p>{{ Auth::user()->country ?? '-' }}</p>
        </div>
        <a href="{{ route('profile.edit') }}">
            <button class="edit-btn">Edit Profile</button>
        </a>
    </div>
</body>

</html>