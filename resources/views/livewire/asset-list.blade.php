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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tag</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asset Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Condition</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Added By</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($assets as $asset)
                        <tr wire:key="asset-{{ $asset->id }}" class="hover:bg-gray-50 transition {{ $asset->condition === 'Broken' ? 'bg-red-50' : '' }}">
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
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                <div class="flex justify-end items-center space-x-3">
                                    <a href="{{ route('assets.show', $asset) }}" target="_blank" class="text-blue-600 hover:text-blue-900 font-bold">View</a>
                                    
                                    @if($asset->condition !== 'Broken')
                                        <form action="{{ route('assets.mark-damaged', $asset) }}" method="POST" onsubmit="return confirm('Mark as broken?')">
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
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">No assets found matching your criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t">
            {{ $assets->links() }}
        </div>
    </div>
</div>