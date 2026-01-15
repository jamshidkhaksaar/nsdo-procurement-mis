<div class="space-y-6" wire:poll.10s>
    <!-- Filter Card -->
    <div class="bg-white shadow-sm sm:rounded-lg p-4 border border-gray-100">
        <div class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:flex-1">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Search Assets</label>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by Tag, Name or Serial..." class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            
            <div class="w-full md:w-48">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Project</label>
                <select wire:model.live="project_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">All Projects</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-40">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Condition</label>
                <select wire:model.live="condition" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Any Condition</option>
                    @foreach(['New', 'Good', 'Fair', 'Poor', 'Scrap'] as $cond)
                        <option value="{{ $cond }}">{{ $cond }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-24">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Rows</label>
                <select wire:model.live="perPage" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                </select>
            </div>

            <div>
                <button wire:click="$set('search', ''); $set('project_id', ''); $set('condition', ''); $set('perPage', 50);" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 h-[38px]">
                    <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Reset
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tag / Serial</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asset Name</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Added</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Modified</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lifecycle</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Condition</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Docs</th>
                        <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($assets as $asset)
                        <tr wire:key="asset-{{ $asset->id }}" class="hover:bg-gray-50 transition {{ $asset->condition === 'Scrap' ? 'bg-red-50' : '' }}">
                            <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-indigo-600">
                                {{ $asset->asset_tag }}
                                @if($asset->serial_number)
                                    <div class="text-xs text-gray-400 font-normal">SN: {{ $asset->serial_number }}</div>
                                @endif
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                {{ $asset->name }}
                                <div class="text-xs text-gray-500">{{ $asset->assetType->name ?? '' }}</div>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                                @if($asset->purchase_date)
                                    <div>{{ $asset->purchase_date->format('M d, Y') }}</div>
                                @else
                                    <div class="text-xs text-gray-400">Added: {{ $asset->created_at->format('M d, Y') }}</div>
                                @endif
                                <div class="text-xs text-gray-400 mt-1">By: {{ $asset->creator->name ?? 'System' }}</div>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">
                                <div>{{ $asset->updated_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-400 mt-1">By: {{ $asset->editor->name ?? 'System' }}</div>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-sm">
                                @if($asset->purchase_date && $asset->useful_life_years)
                                    <div class="flex flex-col">
                                        <span class="text-xs text-gray-500">Life: {{ $asset->useful_life_years }} yrs</span>
                                        <span class="text-xs font-bold {{ str_contains($asset->remaining_life, 'Expired') ? 'text-red-600' : 'text-green-600' }}">
                                            {{ $asset->remaining_life }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($asset->condition == 'New') bg-green-100 text-green-800 
                                    @elseif($asset->condition == 'Good') bg-blue-100 text-blue-800 
                                    @elseif($asset->condition == 'Fair') bg-yellow-100 text-yellow-800 
                                    @elseif($asset->condition == 'Poor') bg-orange-100 text-orange-800 
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $asset->condition }}
                                </span>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-center">
                                @if($asset->documents_count > 0)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-2.828-6.828l-6.414 6.586a6 6 0 008.486 8.486L20.5 13"></path></svg>
                                        {{ $asset->documents_count }}
                                    </span>
                                @else
                                    <span class="text-gray-300 text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                <div class="flex justify-end items-center space-x-3">
                                    <a href="{{ route('assets.show', $asset) }}" target="_blank" class="text-blue-600 hover:text-blue-900 font-bold">View</a>
                                    
                                    @if($asset->condition !== 'Scrap')
                                        <form action="{{ route('assets.mark-damaged', $asset) }}" method="POST" onsubmit="return confirm('Mark as broken/scrap?')">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Damage</button>
                                        </form>
                                    @endif

                                    @can('isAdmin')
                                        <a href="{{ route('admin.audits.index', ['model_type' => 'App\Models\Asset', 'model_id' => $asset->id]) }}" class="text-gray-600 hover:text-gray-900">Audit</a>
                                    @endcan

                                    <a href="{{ route('assets.edit', $asset) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-10 text-center text-gray-500 italic">No assets found matching your criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-3 py-2 border-t">
            {{ $assets->links() }}
        </div>
    </div>
</div>