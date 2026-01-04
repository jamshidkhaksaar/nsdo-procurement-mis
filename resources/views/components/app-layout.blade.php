<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Procurement MIS') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen">
        <!-- Navbar -->
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            @php
                                $logo = \App\Models\Setting::get('company_logo');
                                $companyName = \App\Models\Setting::get('company_name', 'PMIS-NSDO');
                            @endphp
                            
                            @if($logo)
                                <img src="{{ Storage::url($logo) }}" alt="{{ $companyName }}" class="h-14 w-auto py-1">
                            @else
                                <span class="text-2xl font-bold text-indigo-600">{{ $companyName }}</span>
                            @endif
                        </div>
                        <!-- Navigation Links -->
                        <div class="hidden sm:-my-px sm:ml-10 sm:flex sm:space-x-8">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                Dashboard
                            </a>
                            <a href="{{ route('assets.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('assets.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                Assets
                            </a>
                            <a href="{{ route('projects.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('projects.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                Projects
                            </a>
                            <a href="{{ route('contracts.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('contracts.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                Contracts
                            </a>
                            <a href="{{ route('reports.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('reports.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                Reports
                            </a>
                            
                            <!-- Admin Dropdown (Simplified as links for now) -->
                            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                                <span class="text-gray-300">|</span>
                                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.users.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                    Users
                                </a>
                                <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.settings.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                    Settings
                                </a>
                                <a href="{{ route('admin.audits.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.audits.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                    Logs
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- User Actions -->
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Main Content -->
        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>