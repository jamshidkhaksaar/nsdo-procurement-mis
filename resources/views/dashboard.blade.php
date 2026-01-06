<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Stats Grid (Livewire Real-time) -->
        <livewire:dashboard-stats />

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column: Asset Breakdown & Quick Actions -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('assets.create') }}" class="flex items-center justify-center p-4 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:text-lg">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Add Asset
                        </a>
                        <a href="{{ route('contracts.create') }}" class="flex items-center justify-center p-4 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:text-lg">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            New Contract
                        </a>
                    </div>
                </div>

                <!-- Asset Condition Breakdown -->
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Asset Conditions</h3>
                    <div class="space-y-4">
                        @foreach($assetConditions as $condition => $count)
                            <div>
                                <div class="flex justify-between text-sm font-medium text-gray-600 mb-1">
                                    <span>{{ $condition }}</span>
                                    <span>{{ $count }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="h-2.5 rounded-full 
                                        @if($condition == 'New') bg-green-500 
                                        @elseif($condition == 'Good') bg-blue-500 
                                        @elseif($condition == 'Fair') bg-yellow-400 
                                        @elseif($condition == 'Poor') bg-orange-500 
                                        @else bg-red-600 @endif" 
                                        style="width: {{ ($count / ($totalAssets > 0 ? $totalAssets : 1)) * 100 }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if($assetConditions->isEmpty())
                            <p class="text-sm text-gray-500 italic">No assets registered yet.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Alerts & Activity -->
            <div class="space-y-6">
                <!-- Expiring Contracts Alert -->
                @if($contractsExpiringSoon > 0)
                    <div class="bg-white shadow sm:rounded-lg overflow-hidden border-t-4 border-yellow-500">
                        <div class="px-4 py-5 sm:px-6 bg-yellow-50 flex justify-between items-center">
                            <h3 class="text-lg leading-6 font-medium text-yellow-800">Expiring Soon (Next 30 Days)</h3>
                        </div>
                        <ul class="divide-y divide-gray-200">
                            @foreach($expiringContractsList as $contract)
                                <li class="p-4 hover:bg-gray-50 transition">
                                    <a href="{{ route('contracts.show', $contract) }}" class="flex justify-between items-center">
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">{{ $contract->vendor_name }}</p>
                                            <p class="text-xs text-gray-500">Ref: {{ $contract->contract_reference }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold text-red-600">{{ $contract->expiry_date->format('M d, Y') }}</p>
                                            <p class="text-xs text-gray-500">{{ $contract->expiry_date->diffForHumans() }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="bg-white shadow sm:rounded-lg p-6 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No expiring contracts</h3>
                        <p class="mt-1 text-sm text-gray-500">All contracts are up to date.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Announcement Modal -->
    @php
        $showAnnouncement = \App\Models\Setting::get('show_announcement', true);
        $announcementTitle = \App\Models\Setting::get('announcement_title', '🚀 Welcome to Procurement MIS v1.0');
        $announcementBody = \App\Models\Setting::get('announcement_body', "
            <ul class='list-disc list-inside space-y-2 text-gray-600'>
                <li><strong>Secure Access:</strong> Dedicated roles for Admins, Managers, and Users.</li>
                <li><strong>Asset Tracking:</strong> Full lifecycle management, history, and 'Mark as Damaged' features.</li>
                <li><strong>Smart Reports:</strong> Generate PDF exports for Room Lists and Asset Details with signatures.</li>
                <li><strong>Contract Alerts:</strong> Track vendor contracts with automatic expiration warnings.</li>
                <li><strong>Real-Time Dashboard:</strong> Live updates on assets and activities without refreshing.</li>
                <li><strong>Manager Hub:</strong> Centralized control for Departments, Staff, and Locations.</li>
            </ul>
        ");
        $announcementVersion = \App\Models\Setting::get('announcement_version', '1.0');
    @endphp

        @if($showAnnouncement)
        <div x-data="{
                open: false,
                version: '{{ $announcementVersion }}'
             }" 
             x-init="
                if (localStorage.getItem('dismissed_announcement') !== version) {
                    setTimeout(() => open = true, 500);
                }
             "
             x-show="open" 
             class="fixed inset-0 z-[100] overflow-y-auto" 
             style="display: none;"
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
            
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Glassy Backdrop -->
                <div x-show="open" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0" 
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-black/40 backdrop-blur-md transition-opacity" 
                     @click="open = false"
                     aria-hidden="true"></div>
    
                <!-- Modal panel -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div x-show="open" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative z-[110] inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                {{ $announcementTitle }}
                            </h3>
                            <div class="mt-2">
                                <div class="text-sm text-gray-500">
                                    {!! $announcementBody !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm"
                            @click="open = false; localStorage.setItem('dismissed_announcement', version)">
                        Got it, thanks!
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
