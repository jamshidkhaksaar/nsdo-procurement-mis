<div class="space-y-6">
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
        <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <div class="flex justify-between items-center border-b pb-3 mb-4">
                                    <h3 class="text-xl leading-6 font-bold text-gray-900" id="modal-title">
                                        Asset Details: {{ $selectedAsset->asset_tag }}
                                    </h3>
                                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-500">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                                    <div class="space-y-3">
                                        <div>
                                            <p class="text-gray-500 text-xs uppercase font-semibold">Asset Name</p>
                                            <p class="text-lg text-gray-900">{{ $selectedAsset->name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-xs uppercase font-semibold">Condition</p>
                                            <p class="text-gray-900">{{ $selectedAsset->condition }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-xs uppercase font-semibold">Type</p>
                                            <p class="text-gray-900">{{ $selectedAsset->assetType->name ?? 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-xs uppercase font-semibold">Project</p>
                                            <p class="text-gray-900">{{ $selectedAsset->project->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-3 border-l pl-6">
                                        <div>
                                            <p class="text-gray-500 text-xs uppercase font-semibold">Location</p>
                                            <p class="text-gray-900">
                                                {{ $selectedAsset->province->name ?? $selectedAsset->location_province ?? 'N/A' }} / 
                                                {{ $selectedAsset->department->name ?? $selectedAsset->location_department ?? 'N/A' }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-xs uppercase font-semibold">Room / Office</p>
                                            <p class="text-gray-900">{{ $selectedAsset->room_number ?? 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-xs uppercase font-semibold">Assigned To</p>
                                            <p class="text-gray-900 font-bold">{{ $selectedAsset->staff->name ?? $selectedAsset->handed_over_to ?? 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-xs uppercase font-semibold">Added By</p>
                                            <p class="text-gray-900">{{ $selectedAsset->creator->name ?? 'System' }}</p>
                                        </div>
                                    </div>

                                    <div class="col-span-2 pt-4 border-t">
                                        <p class="text-gray-500 text-xs uppercase font-semibold mb-1">Description / Specifications</p>
                                        <p class="text-gray-700 bg-gray-50 p-3 rounded italic">{{ $selectedAsset->description ?: 'No description provided.' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
