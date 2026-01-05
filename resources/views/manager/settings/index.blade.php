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

        <!-- General Settings Form -->
        <div class="bg-white overflow-hidden shadow sm:rounded-lg max-w-2xl">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Notification Settings</h3>
                <form action="{{ route('manager.settings.update') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="manager_email" class="block text-sm font-medium text-gray-700">Manager Notification Email</label>
                        <p class="text-xs text-gray-500 mb-2">Email for receiving automated reports and alerts.</p>
                        <input type="email" name="manager_email" id="manager_email" value="{{ $settings['manager_email'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                            Save Email Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>