<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manager Settings & Configurations') }}
        </h2>
    </x-slot>

    <div class="space-y-8">
        <!-- Configuration Tiles -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Asset Types -->
            <a href="{{ route('manager.asset-types.index') }}" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-50 transition">
                <div class="flex items-center mb-3">
                    <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600 mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h5 class="text-xl font-bold tracking-tight text-gray-900">Asset Types</h5>
                </div>
                <p class="font-normal text-gray-700 text-sm">Manage categories and useful life/depreciation settings.</p>
            </a>

            <!-- Provinces -->
            <a href="{{ route('manager.provinces.index') }}" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-50 transition">
                <div class="flex items-center mb-3">
                    <div class="p-2 bg-green-100 rounded-lg text-green-600 mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h5 class="text-xl font-bold tracking-tight text-gray-900">Provinces</h5>
                </div>
                <p class="font-normal text-gray-700 text-sm">Configure provincial office locations.</p>
            </a>

            <!-- Departments -->
            <a href="{{ route('manager.departments.index') }}" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-50 transition">
                <div class="flex items-center mb-3">
                    <div class="p-2 bg-blue-100 rounded-lg text-blue-600 mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h5 class="text-xl font-bold tracking-tight text-gray-900">Departments</h5>
                </div>
                <p class="font-normal text-gray-700 text-sm">Set up organizational departments.</p>
            </a>

            <!-- Staff -->
            <a href="{{ route('manager.staff.index') }}" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-50 transition">
                <div class="flex items-center mb-3">
                    <div class="p-2 bg-yellow-100 rounded-lg text-yellow-600 mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h5 class="text-xl font-bold tracking-tight text-gray-900">Staff Members</h5>
                </div>
                <p class="font-normal text-gray-700 text-sm">Maintain the list of employees for asset assignment.</p>
            </a>
        </div>

        <!-- General Settings Form (Removed as per request) -->
    </div>
</x-app-layout>