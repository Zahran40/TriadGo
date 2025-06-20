<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TriadGO')</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Include Navbar based on user role -->
    @auth
        @if(Auth::user()->role === 'impor')
            @include('layouts.navbarimportir')
        @elseif(Auth::user()->role === 'ekspor')
            @include('layouts.navbarekspor')
        @else
            @include('layouts.navbarguest')
        @endif
    @else
        @include('layouts.navbarguest')
    @endauth

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>
