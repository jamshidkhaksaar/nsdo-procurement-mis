<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Asset') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-4xl mx-auto">
        <div class="p-6 bg-white border-b border-gray-200">
            <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Project Selection -->
                    <div>
                        <label for="project_id" class="block text-sm font-medium text-gray-700">Project</label>
                        <select name="project_id" id="project_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            <option value="">Select Project</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }} ({{ $project->project_code }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Asset Tag -->
                    <div>
                        <label for="asset_tag" class="block text-sm font-medium text-gray-700">Asset Tag (Manual ID)</label>
                        <input type="text" name="asset_tag" id="asset_tag" value="{{ old('asset_tag') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>

                    <!-- Asset Name -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Asset Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>

                    <!-- Condition -->
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700">Condition</label>
                        <select name="condition" id="condition" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            @foreach(['New', 'Good', 'Fair', 'Poor', 'Broken'] as $cond)
                                <option value="{{ $cond }}" {{ old('condition') == $cond ? 'selected' : '' }}>{{ $cond }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Location Province -->
                    <div>
                        <label for="location_province" class="block text-sm font-medium text-gray-700">Province</label>
                        <input type="text" name="location_province" id="location_province" value="{{ old('location_province') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Location Department -->
                    <div>
                        <label for="location_department" class="block text-sm font-medium text-gray-700">Department</label>
                        <input type="text" name="location_department" id="location_department" value="{{ old('location_department') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Handover Details -->
                    <div>
                        <label for="handed_over_to" class="block text-sm font-medium text-gray-700">Handed Over To</label>
                        <input type="text" name="handed_over_to" id="handed_over_to" value="{{ old('handed_over_to') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="handed_over_by" class="block text-sm font-medium text-gray-700">Handed Over By</label>
                        <input type="text" name="handed_over_by" id="handed_over_by" value="{{ old('handed_over_by') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- File Uploads -->
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700">Asset Photo</label>
                        <input type="file" name="photo" id="photo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>

                    <div>
                        <label for="documents" class="block text-sm font-medium text-gray-700">Handover/Takeover Docs (Multiple)</label>
                        <input type="file" name="documents[]" id="documents" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-end border-t pt-6">
                    <a href="{{ route('assets.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow transition">
                        Save Asset
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
