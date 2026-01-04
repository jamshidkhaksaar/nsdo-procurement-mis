<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Contract: {{ $contract->contract_reference }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('contracts.amendments.create', $contract) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                    Add Amendment
                </a>
                <a href="{{ route('contracts.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded text-sm">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Contract Summary -->
        <div class="bg-white shadow sm:rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Contract Summary</h3>
                <span class="px-3 py-1 text-sm font-semibold rounded-full 
                    @if($contract->status == 'Active') bg-green-100 text-green-800 
                    @elseif($contract->status == 'Expiring Soon') bg-yellow-100 text-yellow-800 
                    @else bg-red-100 text-red-800 @endif">
                    {{ $contract->status }}
                </span>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Vendor Name</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $contract->vendor_name }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Signed Date</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $contract->signed_date->format('M d, Y') }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Current Expiry Date</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 font-bold">{{ $contract->expiry_date->format('M d, Y') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Amendments History -->
        <div class="bg-white shadow sm:rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 bg-gray-50">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Amendments / Extensions</h3>
            </div>
            <div class="border-t border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">New Expiry</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($contract->amendments as $amendment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $amendment->amendment_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">{{ $amendment->new_expiry_date->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $amendment->notes }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-indigo-600">
                                    @if($amendment->document_path)
                                        <a href="{{ Storage::url($amendment->document_path) }}" target="_blank" class="hover:underline">View Doc</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No amendments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
