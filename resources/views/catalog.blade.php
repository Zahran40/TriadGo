<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TriadGO</title>
    @vite('resources/css/app.css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        .body {
            font-family: poppins, sans-serif;
        }
    </style>
    {{-- <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> --> --}}

    <script src="https://cdn.tailwindcss.com">

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
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                },
            },
        }

        tailwind.scan()
    </script>
</head>
<body>
    @include('layouts.navbarimportir')

   test
</body>
</html>