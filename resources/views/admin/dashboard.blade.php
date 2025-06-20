<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TriadGo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold">TriadGo Admin</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span>Welcome, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg min-h-screen">
            <div class="p-4">
                <ul class="space-y-2">                    <li>
                        <a href="{{ route('admin1.dashboard') }}" class="flex items-center p-2 text-gray-700 hover:bg-blue-50 rounded {{ request()->routeIs('admin1.dashboard') ? 'bg-blue-100' : '' }}">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin1.users') }}" class="flex items-center p-2 text-gray-700 hover:bg-blue-50 rounded {{ request()->routeIs('admin1.users') ? 'bg-blue-100' : '' }}">
                            <i class="fas fa-users mr-3"></i>
                            Users
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin1.products') }}" class="flex items-center p-2 text-gray-700 hover:bg-blue-50 rounded {{ request()->routeIs('admin1.products') ? 'bg-blue-100' : '' }}">
                            <i class="fas fa-box mr-3"></i>
                            Products
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin1.orders') }}" class="flex items-center p-2 text-gray-700 hover:bg-blue-50 rounded {{ request()->routeIs('admin1.orders') ? 'bg-blue-100' : '' }}">
                            <i class="fas fa-shopping-cart mr-3"></i>
                            Orders
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
                <p class="text-gray-600">Overview of your application</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-700">Total Users</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-box text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-700">Total Products</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_products'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-shopping-cart text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-700">Total Orders</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-700">Pending Orders</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_orders'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-700">Completed Orders</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['completed_orders'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-dollar-sign text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-700">Total Revenue</h3>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600">Recent activity will be displayed here...</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
