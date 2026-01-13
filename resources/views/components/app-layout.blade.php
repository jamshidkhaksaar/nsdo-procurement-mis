<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $siteTitle = \App\Models\Setting::get('company_name', config('app.name', 'Procurement MIS'));
        $siteFavicon = \App\Models\Setting::get('site_favicon');
    @endphp
    <title>{{ $siteTitle }}</title>
    @if($siteFavicon)
        <link rel="icon" href="{{ Storage::url($siteFavicon) }}">
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        (() => {
            const storageKey = 'theme';
            const stored = localStorage.getItem(storageKey);
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const theme = stored === 'dark' || stored === 'light' ? stored : (prefersDark ? 'dark' : 'light');
            document.documentElement.classList.toggle('dark', theme === 'dark');
            document.documentElement.style.colorScheme = theme;
        })();
    </script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900 dark:bg-slate-900 dark:text-slate-100">
    <div class="min-h-screen">
        <!-- Navbar -->
        <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm dark:bg-slate-900 dark:border-slate-700">
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
                                <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $companyName }}</span>
                            @endif
                        </div>
                        <!-- Navigation Links -->
                        <div class="hidden sm:-my-px sm:ml-10 sm:flex sm:space-x-8">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-indigo-500 text-gray-900 dark:text-slate-100 dark:border-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-slate-300 dark:hover:text-white dark:hover:border-slate-600' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                Dashboard
                            </a>
                            <a href="{{ route('assets.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('assets.index') ? 'border-indigo-500 text-gray-900 dark:text-slate-100 dark:border-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-slate-300 dark:hover:text-white dark:hover:border-slate-600' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                Assets
                            </a>
                            <a href="{{ route('assets.room-list') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('assets.room-list') ? 'border-indigo-500 text-gray-900 dark:text-slate-100 dark:border-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-slate-300 dark:hover:text-white dark:hover:border-slate-600' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                Room List
                            </a>
                            <a href="{{ route('projects.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('projects.*') ? 'border-indigo-500 text-gray-900 dark:text-slate-100 dark:border-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-slate-300 dark:hover:text-white dark:hover:border-slate-600' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                Projects
                            </a>
                            <a href="{{ route('contracts.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('contracts.*') ? 'border-indigo-500 text-gray-900 dark:text-slate-100 dark:border-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-slate-300 dark:hover:text-white dark:hover:border-slate-600' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                Contracts
                            </a>
                            <a href="{{ route('reports.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('reports.*') ? 'border-indigo-500 text-gray-900 dark:text-slate-100 dark:border-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-slate-300 dark:hover:text-white dark:hover:border-slate-600' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                Reports
                            </a>
                            
                            <!-- Admin and Manager Dropdowns -->
                            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                                <span class="text-gray-300 dark:text-slate-600">|</span>
                                
                                @can('isAdmin')
                                    <div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                                        <div @click="open = ! open">
                                            <button class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.*') ? 'border-indigo-500 text-gray-900 dark:text-slate-100 dark:border-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-slate-300 dark:hover:text-white dark:hover:border-slate-600' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                                <div>Admin</div>
                                                <div class="ml-1">
                                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </div>

                                        <div x-show="open"
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="transform opacity-0 scale-95"
                                             x-transition:enter-end="transform opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-75"
                                             x-transition:leave-start="transform opacity-100 scale-100"
                                             x-transition:leave-end="transform opacity-0 scale-95"
                                             class="absolute z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right right-0"
                                             style="display: none;">
                                            <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white dark:bg-slate-800 dark:ring-slate-700/60">
                                                <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out dark:text-slate-200 dark:hover:bg-slate-700/60 dark:focus:bg-slate-700/60">Users</a>
                                                <a href="{{ route('admin.settings.index') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out dark:text-slate-200 dark:hover:bg-slate-700/60 dark:focus:bg-slate-700/60">General Settings</a>
                                                <a href="{{ route('admin.audits.index') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out dark:text-slate-200 dark:hover:bg-slate-700/60 dark:focus:bg-slate-700/60">Audit Logs</a>
                                            </div>
                                        </div>
                                    </div>
                                @endcan

                                @can('isManager')
                                    <div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                                        <div @click="open = ! open">
                                            <button class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('manager.*') ? 'border-indigo-500 text-gray-900 dark:text-slate-100 dark:border-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-slate-300 dark:hover:text-white dark:hover:border-slate-600' }} text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
                                                <div>Manager Settings</div>
                                                <div class="ml-1">
                                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </div>

                                        <div x-show="open"
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="transform opacity-0 scale-95"
                                             x-transition:enter-end="transform opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-75"
                                             x-transition:leave-start="transform opacity-100 scale-100"
                                             x-transition:leave-end="transform opacity-0 scale-95"
                                             class="absolute z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right right-0"
                                             style="display: none;">
                                            <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white dark:bg-slate-800 dark:ring-slate-700/60">
                                                <a href="{{ route('manager.asset-types.index') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out dark:text-slate-200 dark:hover:bg-slate-700/60 dark:focus:bg-slate-700/60">Asset Types</a>
                                                <a href="{{ route('manager.staff.index') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out dark:text-slate-200 dark:hover:bg-slate-700/60 dark:focus:bg-slate-700/60">Staff</a>
                                                <a href="{{ route('manager.departments.index') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out dark:text-slate-200 dark:hover:bg-slate-700/60 dark:focus:bg-slate-700/60">Departments</a>
                                                <a href="{{ route('manager.provinces.index') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out dark:text-slate-200 dark:hover:bg-slate-700/60 dark:focus:bg-slate-700/60">Provinces</a>
                                                <div class="border-t border-gray-100 dark:border-slate-700"></div>
                                                <a href="{{ route('manager.settings.index') }}" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out dark:text-slate-200 dark:hover:bg-slate-700/60 dark:focus:bg-slate-700/60">All Settings</a>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <!-- User Actions -->
                    <div class="flex items-center space-x-4">
                        <button type="button" data-theme-toggle aria-pressed="false" aria-label="Switch to dark mode" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-600 shadow-sm transition hover:border-gray-300 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:text-white dark:focus:ring-indigo-300">
                            <svg class="h-5 w-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z"></path>
                            </svg>
                            <svg class="hidden h-5 w-5 dark:inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v2.25M12 18.75V21M4.219 4.219l1.59 1.59M18.19 18.19l1.59 1.59M3 12h2.25M18.75 12H21M4.219 19.781l1.59-1.59M18.19 5.81l1.59-1.59M12 6.75a5.25 5.25 0 100 10.5 5.25 5.25 0 000-10.5z"></path>
                            </svg>
                        </button>
                        <span class="text-sm font-medium text-gray-700 dark:text-slate-200">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 transition dark:text-red-400 dark:hover:text-red-300">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow dark:bg-slate-900 dark:border-b dark:border-slate-700 dark:shadow-slate-900/40">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 page-heading">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Main Content -->
        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative dark:bg-emerald-900/40 dark:border-emerald-600 dark:text-emerald-200" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative dark:bg-red-900/40 dark:border-red-600 dark:text-red-200" role="alert">
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

    <!-- Scroll to Top Button -->
    <div x-data="{ showScrollTop: false }"
         @scroll.window="showScrollTop = (window.pageYOffset > 300) ? true : false"
         class="fixed bottom-10 right-10 z-50">
        <button x-show="showScrollTop"
                @click="window.scrollTo({top: 0, behavior: 'smooth'})"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-10"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-10"
                class="bg-indigo-600 hover:bg-indigo-700 text-white p-3 rounded-full shadow-lg focus:outline-none transition transform hover:scale-110 dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:shadow-indigo-500/30">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
        </button>
    </div>

    @livewireScripts
</body>
</html>
