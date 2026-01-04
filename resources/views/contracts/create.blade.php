<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register New Contract') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-2xl mx-auto">
        <div class="p-6 bg-white border-b border-gray-200">
            <form action="{{ route('contracts.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="vendor_name" class="block text-sm font-medium text-gray-700">Vendor Name</label>
                        <input type="text" name="vendor_name" id="vendor_name" value="{{ old('vendor_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>

                    <div>
                        <label for="contract_reference" class="block text-sm font-medium text-gray-700">Contract Reference #</label>
                        <input type="text" name="contract_reference" id="contract_reference" value="{{ old('contract_reference') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="signed_date" class="block text-sm font-medium text-gray-700">Signed Date</label>
                            <input type="date" name="signed_date" id="signed_date" value="{{ old('signed_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        </div>
                        <div>
                            <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                            <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end">
                    <a href="{{ route('contracts.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                        Save Contract
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
