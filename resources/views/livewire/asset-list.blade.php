<div class="space-y-6" wire:poll.10s>
    <!-- Filter Card -->
    <div class="bg-white shadow-sm sm:rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700">Search</label>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Tag or Name..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Project</label>
                <select wire:model.live="project_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">All Projects</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Condition</label>
                <select wire:model.live="condition" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">All Conditions</option>
                    @foreach(['New', 'Good', 'Fair', 'Poor', 'Broken'] as $cond)
                        <option value="{{ $cond }}">{{ $cond }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <button wire:click="$set('search', ''); $set('project_id', ''); $set('condition', '');" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-md shadow-sm text-center text-sm transition">
                    Reset Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Assets Table -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tag</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Asset Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Condition</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Added By</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($assets as $asset)
                        <tr wire:key="asset-{{ $asset->id }}" 
                            class="hover:bg-gray-50 transition {{ $asset->condition === 'Broken' ? 'bg-red-50' : '' }}">
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600">
                                {{ $asset->asset_tag }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $asset->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($asset->condition == 'New') bg-green-100 text-green-800 
                                    @elseif($asset->condition == 'Good') bg-blue-100 text-blue-800 
                                    @elseif($asset->condition == 'Fair') bg-yellow-100 text-yellow-800 
                                    @elseif($asset->condition == 'Poor') bg-orange-100 text-orange-800 
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $asset->condition }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                {{ $asset->creator->name ?? 'System' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <button wire:click="viewAsset({{ $asset->id }})" class="text-blue-600 hover:text-blue-900">View</button>
                                
                                @can('isAdmin')
                                    <a href="{{ route('admin.audits.index', ['model_type' => 'App\Models\Asset', 'model_id' => $asset->id]) }}" class="text-gray-600 hover:text-gray-900">Audit</a>
                                @endcan

                                <a href="{{ route('assets.edit', $asset) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">No assets found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t">
            {{ $assets->links() }}
        </div>
    </div>

    <!-- View Modal (Pure Livewire) -->
    @if($showModal && $selectedAsset)
        <div wire:key="asset-modal-{{ $selectedAsset->id }}" 
             x-data="{ open: false }" 
             x-init="$nextTick(() => open = true)"
             x-show="open"
             class="fixed inset-0 z-[100] overflow-y-auto" 
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Glassy Backdrop with Strong Dimming -->
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-black/70 backdrop-blur-sm" 
                     aria-hidden="true" 
                     wire:click="closeModal"></div>

                <!-- Spacer for centering -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Panel with Zoom Animation -->
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative z-[110] inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full border border-gray-200">
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <div class="flex justify-between items-center border-b pb-3 mb-4">
                                    <h3 class="text-xl leading-6 font-bold text-gray-900" id="modal-title">
                                        Asset Details: {{ $selectedAsset->asset_tag }}
                                    </h3>
                                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-500 transition">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                                    <!-- Photo Column -->
                                    <div class="col-span-1 flex items-center justify-center bg-gray-50 rounded-lg p-2 border border-gray-100">
                                        @if($selectedAsset->photo_path)
                                            <img src="{{ Storage::url($selectedAsset->photo_path) }}" 
                                                 alt="Asset Photo" 
                                                 class="max-h-64 w-full object-contain rounded-md shadow-sm bg-white">
                                        @else
                                            <div class="text-gray-400 flex flex-col items-center py-12">
                                                <svg class="h-16 w-16 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                <p class="text-xs mt-2 font-medium">No Image Available</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-gray-500 text-xs uppercase font-bold tracking-wider">Asset Name</p>
                                            <p class="text-lg text-gray-900 font-semibold">{{ $selectedAsset->name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-xs uppercase font-bold tracking-wider">Condition</p>
                                            <span class="px-2 py-1 rounded-full text-xs font-bold
                                                @if($selectedAsset->condition == 'New') bg-green-100 text-green-800 
                                                @elseif($selectedAsset->condition == 'Good') bg-blue-100 text-blue-800 
                                                @elseif($selectedAsset->condition == 'Fair') bg-yellow-100 text-yellow-800 
                                                @elseif($selectedAsset->condition == 'Poor') bg-orange-100 text-orange-800 
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ $selectedAsset->condition }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-xs uppercase font-bold tracking-wider">Type</p>
                                            <p class="text-gray-900 font-medium">{{ $selectedAsset->assetType->name ?? 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-xs uppercase font-bold tracking-wider">Project</p>
                                            <p class="text-gray-900 font-medium">{{ $selectedAsset->project->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-4 border-l pl-6">
                                        <div>
                                            <p class="text-gray-500 text-xs uppercase font-bold tracking-wider">Location</p>
                                            <p class="text-gray-900 font-medium">
                                                {{ $selectedAsset->province->name ?? $selectedAsset->location_province ?? 'N/A' }} / 
                                                {{ $selectedAsset->department->name ?? $selectedAsset->location_department ?? 'N/A' }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-xs uppercase font-bold tracking-wider">Room / Office</p>
                                            <p class="text-gray-900 font-medium">{{ $selectedAsset->room_number ?? 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-xs uppercase font-bold tracking-wider">Assigned To</p>
                                            <p class="text-gray-900 font-bold text-indigo-700">{{ $selectedAsset->staff->name ?? $selectedAsset->handed_over_to ?? 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-xs uppercase font-bold tracking-wider">Handed Over By</p>
                                            <p class="text-gray-900 font-medium">{{ $selectedAsset->handed_over_by ?? 'Logistics' }}</p>
                                        </div>
                                    </div>

                                    <div class="col-span-3 pt-4 border-t mt-2">
                                        <p class="text-gray-500 text-xs uppercase font-bold tracking-wider mb-1">Description / Specifications</p>
                                        <p class="text-gray-700 bg-gray-50 p-3 rounded-lg italic border border-gray-100">{{ $selectedAsset->description ?: 'No description provided.' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-row-reverse space-x-reverse space-x-3 border-t">
                        <a href="{{ route('assets.export-pdf', $selectedAsset) }}" class="inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none transition sm:w-auto sm:text-sm">
                            Export PDF / Print
                        </a>
                        <button type="button" wire:click="closeModal" class="inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition sm:w-auto sm:text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-row-reverse space-x-reverse space-x-3">
                        <a href="{{ route('assets.export-pdf', $selectedAsset) }}" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:w-auto sm:text-sm">
                            Export PDF / Print
                        </a>
                        <button type="button" wire:click="closeModal" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:w-auto sm:text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
