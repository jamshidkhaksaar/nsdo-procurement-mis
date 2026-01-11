<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Asset') }}: {{ $asset->name }}
            </h2>
            @if($asset->condition !== 'Broken')
                <button type="button" onclick="document.getElementById('condition').value = 'Broken'; document.getElementById('condition').classList.add('bg-red-100', 'text-red-900'); alert('Condition set to Broken. Please click Update Asset to save.');" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow text-sm">
                    Mark as Damaged
                </button>
            @endif
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <form action="{{ route('assets.update', $asset) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Info -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Basic Information</h3>
                        
                        <div>
                            <label for="project_id" class="block text-sm font-medium text-gray-700">Project <span class="text-red-500">*</span></label>
                            <select name="project_id" id="project_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Select Project</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id', $asset->project_id) == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="asset_type_id" class="block text-sm font-medium text-gray-700">Asset Type</label>
                            <select name="asset_type_id" id="asset_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Select Type</option>
                                @foreach($assetTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('asset_type_id', $asset->asset_type_id) == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="asset_tag" class="block text-sm font-medium text-gray-700">Asset Tag <span class="text-red-500">*</span></label>
                                <input type="text" name="asset_tag" id="asset_tag" value="{{ old('asset_tag', $asset->asset_tag) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="serial_number" class="block text-sm font-medium text-gray-700">Serial Number</label>
                                <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $asset->serial_number) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Asset Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $asset->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="purchase_date" class="block text-sm font-medium text-gray-700">Purchase Date</label>
                                <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', $asset->purchase_date ? $asset->purchase_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="useful_life_years" class="block text-sm font-medium text-gray-700">Useful Life (Years)</label>
                                <input type="number" step="0.1" name="useful_life_years" id="useful_life_years" value="{{ old('useful_life_years', $asset->useful_life_years) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity <span class="text-red-500">*</span></label>
                                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $asset->quantity) }}" min="1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="condition" class="block text-sm font-medium text-gray-700">Condition <span class="text-red-500">*</span></label>
                                <select name="condition" id="condition" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="New" {{ old('condition', $asset->condition) == 'New' ? 'selected' : '' }}>New</option>
                                    <option value="Good" {{ old('condition', $asset->condition) == 'Good' ? 'selected' : '' }}>Good</option>
                                    <option value="Fair" {{ old('condition', $asset->condition) == 'Fair' ? 'selected' : '' }}>Fair</option>
                                    <option value="Poor" {{ old('condition', $asset->condition) == 'Poor' ? 'selected' : '' }}>Poor</option>
                                    <option value="Broken" {{ old('condition', $asset->condition) == 'Broken' ? 'selected' : '' }}>Broken</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $asset->description) }}</textarea>
                        </div>
                    </div>

                    <!-- Location & Assignment -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Location & Assignment</h3>
                        
                        <div>
                            <label for="province_id" class="block text-sm font-medium text-gray-700">Province</label>
                            <select name="province_id" id="province_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Select Province</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}" {{ old('province_id', $asset->province_id) == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="department_id" class="block text-sm font-medium text-gray-700">Department / Location</label>
                            <select name="department_id" id="department_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Select Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id', $asset->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="room_number" class="block text-sm font-medium text-gray-700">Room Number / Office</label>
                            <input type="text" name="room_number" id="room_number" value="{{ old('room_number', $asset->room_number) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="handed_over_by" class="block text-sm font-medium text-gray-700">Handed Over By</label>
                            <input type="text" name="handed_over_by" id="handed_over_by" value="{{ old('handed_over_by', $asset->handed_over_by) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="handover_date" class="block text-sm font-medium text-gray-700">Handover Date</label>
                            <input type="date" name="handover_date" id="handover_date" value="{{ old('handover_date', $asset->handover_date ? $asset->handover_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="staff_id" class="block text-sm font-medium text-gray-700">Handedover to (Staff Member)</label>
                            <select name="staff_id" id="staff_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Select Staff</option>
                                @foreach($staffMembers as $staff)
                                    <option value="{{ $staff->id }}" {{ old('staff_id', $asset->staff_id) == $staff->id ? 'selected' : '' }}>{{ $staff->name }} ({{ $staff->department->name ?? 'N/A' }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700">Change Asset Photo</label>
                            <input type="file" name="photo" id="photo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Documents</label>
                            <!-- Existing Documents -->
                            @if($asset->documents->count() > 0)
                                <ul class="mb-3 border rounded divide-y bg-gray-50">
                                    @foreach($asset->documents as $doc)
                                        <li class="px-3 py-2 flex justify-between items-center text-sm">
                                            <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="text-indigo-600 hover:underline">View Document ({{ $doc->created_at->format('M d, Y') }})</a>
                                            <!-- Delete functionality can be added later if requested, for now just View -->
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            
                            <label for="documents" class="block text-xs font-medium text-gray-500 mt-2">Upload New Documents (Appends to list)</label>
                            <input type="file" name="documents[]" id="documents" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('assets.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Asset
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>