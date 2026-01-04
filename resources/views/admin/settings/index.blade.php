<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('General Settings') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-2xl mx-auto">
        <div class="p-6 bg-white border-b border-gray-200">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-6">
                    <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                    <input type="text" name="company_name" id="company_name" value="{{ $settings['company_name'] ?? 'Procurement MIS' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Current Logo</label>
                    <div class="mt-2 flex items-center">
                        @if(isset($settings['company_logo']))
                            <img src="{{ Storage::url($settings['company_logo']) }}" alt="Company Logo" class="h-16 w-auto object-contain border p-1 rounded">
                        @else
                            <div class="h-16 w-16 bg-gray-100 flex items-center justify-center text-xs text-gray-400 border rounded">
                                No Logo
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mb-6">
                    <label for="company_logo" class="block text-sm font-medium text-gray-700">Upload New Logo</label>
                    <input type="file" name="company_logo" id="company_logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xs text-gray-500 mt-1">Recommended size: 200x50px. Max 2MB.</p>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
