<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Manajemen Hotel</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div x-data="{ sidebarOpen: true }" class="flex h-screen">
        <div :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-sky-700 text-white transition-all duration-300 shadow-lg">
            <div class="p-4 flex justify-between items-center">
                <h2 :class="sidebarOpen ? 'block' : 'hidden'" class="font-bold text-xl">Hotel App</h2>
                <button @click="sidebarOpen = !sidebarOpen" class="text-white p-1 rounded hover:bg-sky-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 hover:bg-sky-800 {{ request()->routeIs('admin.dashboard') ? 'bg-sky-800' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    <span :class="sidebarOpen ? 'ml-3 block' : 'hidden'" class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('rooms.index') }}" class="flex items-center px-4 py-3 hover:bg-sky-800 {{ request()->routeIs('rooms*') ? 'bg-sky-800' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                    </svg>
                    <span :class="sidebarOpen ? 'ml-3 block' : 'hidden'" class="font-medium">Kamar</span>
                </a>
                
                <a href="{{ route('room-types.index') }}" class="flex items-center px-4 py-3 hover:bg-sky-800 {{ request()->routeIs('room-types*') ? 'bg-sky-800' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3 1h10v8H5V6z" clip-rule="evenodd" />
                    </svg>
                    <span :class="sidebarOpen ? 'ml-3 block' : 'hidden'" class="font-medium">Tipe Kamar</span>
                </a>
                <a href="{{ route('reservations.index') }}" class="flex items-center px-4 py-3 hover:bg-sky-800 {{ request()->routeIs('reservations*') ? 'bg-sky-800' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    <span :class="sidebarOpen ? 'ml-3 block' : 'hidden'" class="font-medium">Reservasi</span>
                </a>
            </nav>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow">
                <div class="flex items-center justify-between px-6 py-3">
                    <div class="flex-1">
                        <h2 class="text-2xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <div x-data="{ isOpen: false }" class="relative">
                            <button @click="isOpen = !isOpen" class="flex items-center focus:outline-none">
                                <span class="mr-2 text-gray-700">{{ Auth::user()->name }}</span>
                                <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" alt="User avatar">
                            </button>
                            
                            <div x-show="isOpen" @click.away="isOpen = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Keluar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>