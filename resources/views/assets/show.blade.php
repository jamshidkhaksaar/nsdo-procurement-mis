<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Asset Details: {{ $asset->asset_tag }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('assets.edit', $asset) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                    Edit Asset
                </a>
                <a href="{{ route('assets.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded text-sm">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Asset Information -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">General Information</h3>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full 
                        @if($asset->condition == 'New') bg-green-100 text-green-800 
                        @elseif($asset->condition == 'Broken') bg-red-100 text-red-800 
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ $asset->condition }}
                    </span>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Asset Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $asset->name }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Project</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $asset->project->name }} ({{ $asset->project->project_code }})</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Quantity</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $asset->quantity }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Location</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $asset->location_province }} {{ $asset->location_department ? '- ' . $asset->location_department : '' }}
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Handed Over To/By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                To: {{ $asset->handed_over_to ?? 'N/A' }} <br>
                                By: {{ $asset->handed_over_by ?? 'N/A' }}
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $asset->description ?? 'No description provided.' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Documents -->
            <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Attached Documents</h3>
                </div>
                <div class="border-t border-gray-200 p-4">
                    <ul class="divide-y divide-gray-200">
                        @forelse($asset->documents as $doc)
                            <li class="py-3 flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ basename($doc->file_path) }}</span>
                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Download</a>
                            </li>
                        @empty
                            <li class="py-3 text-sm text-gray-500">No documents uploaded.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Sidebar: Photo & History -->
        <div class="space-y-6">
            <!-- Asset Photo -->
            <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Photo</h3>
                </div>
                <div class="p-4 flex justify-center border-t border-gray-200">
                    @if($asset->photo_path)
                        <img src="{{ Storage::url($asset->photo_path) }}" alt="Asset Photo" class="max-w-full h-auto rounded-lg shadow">
                    @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400 rounded-lg">
                            No Photo
                        </div>
                    @endif
                </div>
            </div>

            <!-- Audit History -->
            <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Audit Trail (History)</h3>
                </div>
                <div class="border-t border-gray-200 max-h-96 overflow-y-auto">
                    <ul class="divide-y divide-gray-200">
                        @foreach($asset->audits->sortByDesc('created_at') as $audit)
                            <li class="p-4 text-xs">
                                <div class="flex justify-between font-semibold text-gray-700">
                                    <span>{{ $audit->event }}</span>
                                    <span>{{ $audit->created_at->format('Y-m-d H:i') }}</span>
                                </div>
                                <div class="mt-1 text-gray-600">
                                    @foreach($audit->getModified() as $attribute => $modified)
                                        <div class="mt-1">
                                            <strong>{{ ucfirst($attribute) }}:</strong> 
                                            @if($audit->event == 'updated')
                                                <span class="text-red-500 line-through">{{ $modified['old'] }}</span> → <span class="text-green-600">{{ $modified['new'] }}</span>
                                            @else
                                                <span class="text-green-600">{{ $modified['new'] }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
