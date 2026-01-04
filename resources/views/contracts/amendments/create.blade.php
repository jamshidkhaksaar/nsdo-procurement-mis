<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Amendment to {{ $contract->contract_reference }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-2xl mx-auto">
        <div class="p-6 bg-white border-b border-gray-200">
            <form action="{{ route('contracts.amendments.store', $contract) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="amendment_number" class="block text-sm font-medium text-gray-700">Amendment Number (e.g., AMD-001)</label>
                        <input type="text" name="amendment_number" id="amendment_number" value="{{ old('amendment_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>

                    <div>
                        <label for="new_expiry_date" class="block text-sm font-medium text-gray-700">New Expiry Date</label>
                        <input type="date" name="new_expiry_date" id="new_expiry_date" value="{{ old('new_expiry_date', $contract->expiry_date->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>

                    <div>
                        <label for="document" class="block text-sm font-medium text-gray-700">Amendment Document (PDF/Scan)</label>
                        <input type="file" name="document" id="document" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes / Reason for Amendment</label>
                        <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end">
                    <a href="{{ route('contracts.show', $contract) }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                        Add Amendment
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
