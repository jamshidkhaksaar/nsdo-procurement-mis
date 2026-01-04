<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Contracts') }}
            </h2>
            <a href="{{ route('contracts.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                Register New Contract
            </a>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200 text-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Signed Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expiry Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($contracts as $contract)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $contract->contract_reference }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $contract->vendor_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $contract->signed_date->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $contract->expiry_date->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($contract->status == 'Active') bg-green-100 text-green-800 
                                    @elseif($contract->status == 'Expiring Soon') bg-yellow-100 text-yellow-800 
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $contract->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                <a href="{{ route('contracts.show', $contract) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                <a href="{{ route('contracts.edit', $contract) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No contracts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
