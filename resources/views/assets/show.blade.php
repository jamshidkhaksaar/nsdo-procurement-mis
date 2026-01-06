<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    Asset File: <span class="text-indigo-600">{{ $asset->asset_tag }}</span>
                </h2>
                <p class="text-sm text-gray-500 mt-1">Detailed specification and tracking record</p>
            </div>
            <div class="flex flex-wrap gap-2">
                @if($asset->condition !== 'Broken')
                    <form action="{{ route('assets.mark-damaged', $asset) }}" method="POST" onsubmit="return confirm('Are you sure this asset is damaged/broken?')">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 15c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Mark as Damaged
                        </button>
                    </form>
                @endif
                <a href="{{ route('assets.export-pdf', $asset) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export PDF
                </a>
                <a href="{{ route('assets.edit', $asset) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                    Edit Details
                </a>
                <a href="{{ route('assets.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6 pb-12">
        <!-- Main Info Card -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    
                    <!-- Left: Photo -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-50 rounded-2xl p-4 border-2 border-dashed border-gray-200 flex flex-col items-center justify-center min-h-[300px]">
                            @if($asset->photo_path)
                                <img src="{{ Storage::url($asset->photo_path) }}" alt="{{ $asset->name }}" class="max-w-full max-h-[400px] rounded-xl shadow-lg object-contain bg-white">
                            @else
                                <div class="text-gray-300 flex flex-col items-center">
                                    <svg class="w-24 h-24 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class="font-medium">No Image Uploaded</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right: Details -->
                    <div class="lg:col-span-2">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $asset->name }}</h3>
                            <span class="px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-wide
                                @if($asset->condition == 'New') bg-green-100 text-green-800 
                                @elseif($asset->condition == 'Good') bg-blue-100 text-blue-800 
                                @elseif($asset->condition == 'Fair') bg-yellow-100 text-yellow-800 
                                @elseif($asset->condition == 'Poor') bg-orange-100 text-orange-800 
                                @else bg-red-100 text-red-800 @endif">
                                {{ $asset->condition }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Asset Type</label>
                                    <p class="text-gray-900 font-medium">{{ $asset->assetType->name ?? 'Uncategorized' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Project Assignment</label>
                                    <p class="text-gray-900 font-medium">{{ $asset->project->name }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Quantity</label>
                                    <p class="text-gray-900 font-medium">{{ $asset->quantity }} Unit(s)</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Assigned To (Staff)</label>
                                    <p class="text-indigo-700 font-bold text-lg">{{ $asset->staff->name ?? $asset->handed_over_to ?? 'Not Assigned' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Handover Status</label>
                                    <p class="text-gray-900 font-medium italic">Handed over by: {{ $asset->handed_over_by ?? 'Logistics' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Assignment Record</label>
                                    <p class="text-gray-900 font-medium">Assigned by: {{ $asset->assigned_by ?? 'N/A' }}</p>
                                    <p class="text-gray-500 text-xs mt-1">Date: {{ $asset->assigned_date ? $asset->assigned_date->format('M d, Y') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Current Location</label>
                                    <p class="text-gray-900 font-medium">
                                        {{ $asset->province->name ?? $asset->location_province ?? 'N/A' }} / 
                                        {{ $asset->department->name ?? $asset->location_department ?? 'N/A' }}
                                        @if($asset->room_number) (Room: {{ $asset->room_number }}) @endif
                                    </p>
                                </div>
                            </div>

                            <div class="col-span-full pt-4 border-t">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2">Specifications / Description</label>
                                <div class="bg-gray-50 p-4 rounded-xl text-gray-700 leading-relaxed border border-gray-100">
                                    {{ $asset->description ?: 'No additional specifications provided.' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Documents Section -->
            <div class="lg:col-span-1 bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-2.828-6.828l-6.414 6.586a6 6 0 008.486 8.486L20.5 13"></path></svg>
                    <h3 class="font-bold text-gray-800">Attachments</h3>
                </div>
                <div class="p-6">
                    <ul class="space-y-3">
                        @forelse($asset->documents as $doc)
                            <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition border border-transparent hover:border-gray-200">
                                <span class="text-sm font-medium text-gray-600 truncate max-w-[150px]">{{ basename($doc->file_path) }}</span>
                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="text-indigo-600 hover:underline text-xs font-bold uppercase tracking-wider">Download</a>
                            </li>
                        @empty
                            <li class="text-sm text-gray-400 italic py-4 text-center">No documents attached.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Audit Trail Section -->
            <div class="lg:col-span-2 bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="font-bold text-gray-800">History & Audit Trail</h3>
                </div>
                <div class="p-0 max-h-[400px] overflow-y-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="px-6 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Event</th>
                                <th class="px-6 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Modified By</th>
                                <th class="px-6 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Changes</th>
                                <th class="px-6 py-3 text-right text-[10px] font-bold text-gray-400 uppercase tracking-widest">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($asset->audits->sortByDesc('created_at') as $audit)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase
                                            @if($audit->event == 'created') bg-green-100 text-green-700 
                                            @elseif($audit->event == 'deleted') bg-red-100 text-red-700 
                                            @else bg-blue-100 text-blue-700 @endif">
                                            {{ $audit->event }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                        {{ $audit->user->name ?? 'System' }}
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-500 max-w-xs truncate">
                                        @foreach($audit->getModified() as $attribute => $modified)
                                            <div class="mb-1">
                                                <span class="font-bold text-gray-700">{{ ucfirst($attribute) }}:</span>
                                                @if(isset($modified['old']))
                                                    <span class="text-red-400 line-through">{{ $modified['old'] }}</span> →
                                                @endif
                                                <span class="text-green-600 font-semibold">{{ $modified['new'] }}</span>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs text-gray-400">
                                        {{ $audit->created_at->format('M d, Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>