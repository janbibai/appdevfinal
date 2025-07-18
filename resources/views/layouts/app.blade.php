<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-gray-100 text-base">

@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
    $unreadNotifications = $user->unreadNotifications;
    $notificationCount = $unreadNotifications->count();
@endphp

<div class="drawer lg:drawer-open">
    <input id="sidebar-toggle" type="checkbox" class="drawer-toggle" />

    <!-- Main content -->
    <div class="drawer-content flex flex-col">
        <!-- Navbar -->
        <div class="navbar bg-white shadow px-6 py-3">
            <!-- Hamburger for mobile -->
            <div class="flex-none lg:hidden">
                <label for="sidebar-toggle" class="btn btn-square btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </label>
            </div>

            <!-- Title -->
            <div class="flex-1">
                <span class="text-xl font-semibold">@yield('title', 'Dashboard')</span>
            </div>

            <!-- Right: Notifications + User Info -->
            <div class="flex-none flex items-center gap-4">
                <!-- Notifications Dropdown -->
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                        <div class="indicator">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1h6z" />
                            </svg>
                            @if($notificationCount > 0)
                                <span class="badge badge-error badge-sm indicator-item">{{ $notificationCount }}</span>
                            @endif
                        </div>
                    </div>
                    <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-72">
                        @forelse ($unreadNotifications as $notification)
                            <li class="flex justify-between items-center text-sm">
                                <span class="truncate w-48">{{ $notification->data['message'] }}</span>
                                <form method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-xs btn-outline ml-2">✔</button>
                                </form>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500">No new notifications</li>
                        @endforelse
                    </ul>
                </div>

                <!-- User Avatar -->
                <span class="font-medium text-gray-700">👤 {{ $user->name ?? 'Admin' }}</span>
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <img src="https://i.pravatar.cc/100?u={{ $user->id }}" alt="Profile" />
                        </div>
                    </div>
                    <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                        <li><a>Profile</a></li>
                        <li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left hover:text-red-600">
                                Logout
                            </button>
                             </form>

                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <main class="p-6">
            @yield('content')
        </main>
    </div>

    <!-- Sidebar -->
    <div class="drawer-side">
        <label for="sidebar-toggle" class="drawer-overlay"></label>
        <aside class="w-64 bg-base-100 text-base-content shadow-lg min-h-screen flex flex-col">
            <!-- Branding -->
            <div class="p-4 border-b border-gray-200">
                <a href="{{ route('home.index') }}" class="text-2xl font-bold">📦 Inventory</a>
            </div>

            <!-- Menu -->
            <ul class="menu p-4 flex-1 overflow-y-auto space-y-2 text-sm">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('home.index') }}" class="flex items-center gap-3 text-gray-700 hover:text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 3h7v7H3V3zm0 11h7v7H3v-7zm11-11h7v7h-7V3zm0 11h7v7h-7v-7z" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Products -->
                <li>
                    <a href="{{ route('products.index') }}" class="flex items-center gap-3 text-gray-700 hover:text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 3h18M9 3v18m6-18v18M3 9h18M3 15h18" />
                        </svg>
                        <span>Products</span>
                    </a>
                </li>

                <!-- Product Suppliers -->
                <li>
                    <a href="{{ route('prodSupply.supp') }}" class="flex items-center gap-3 text-gray-700 hover:text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M20 13V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6m16 0l-8 8-8-8" />
                        </svg>
                        <span>Product Suppliers</span>
                    </a>
                </li>

                <!-- Product Categories -->
                <li>
                    <a href="{{ route('product-categories.category') }}" class="flex items-center gap-3 text-gray-700 hover:text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span>Product Categories</span>
                    </a>
                </li>
            </ul>
        </aside>
    </div>
</div>

@stack('scripts')
</body>
</html>
