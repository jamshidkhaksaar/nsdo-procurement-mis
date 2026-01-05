<div class="space-y-6">
    <!-- Filter Card -->
    <div class="bg-white shadow-sm sm:rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700">Search</label>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Vendor or Reference..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
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
                <button wire:click="$set('search', ''); $set('project_id', '');" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-md shadow-sm text-center text-sm transition">
                    Reset Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Contracts Table -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vendor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reference</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dates</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($contracts as $contract)
                        <tr wire:key="contract-{{ $contract->id }}" 
                            class="hover:bg-gray-50 transition">
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $contract->vendor_name }}</div>
                                <div class="text-xs text-gray-500">{{ $contract->project->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $contract->contract_reference }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-xs text-gray-900">{{ $contract->start_date->format('M d, Y') }} -</div>
                                <div class="text-xs font-bold {{ $contract->expiry_date->isPast() ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $contract->expiry_date->format('M d, Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ number_format($contract->contract_amount, 2) }} {{ $contract->currency }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <button wire:click="viewContract({{ $contract->id }})" class="text-blue-600 hover:text-blue-900">View</button>
                                <a href="{{ route('contracts.show', $contract) }}" class="text-green-600 hover:text-green-900">Amend</a>
                                <a href="{{ route('contracts.edit', $contract) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">No contracts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t">
            {{ $contracts->links() }}
        </div>
    </div>

    <!-- View Modal -->
    @if($showModal && $selectedContract)
        <div class="fixed z-50 inset-0 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-xl font-bold text-gray-900 border-b pb-3 mb-4">Contract: {{ $selectedContract->vendor_name }}</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Reference</p>
                                <p class="font-semibold">{{ $selectedContract->contract_reference }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Project</p>
                                <p class="font-semibold">{{ $selectedContract->project->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Start Date</p>
                                <p>{{ $selectedContract->start_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Expiry Date</p>
                                <p class="font-bold text-indigo-600">{{ $selectedContract->expiry_date->format('M d, Y') }}</p>
                            </div>
                            <div class="col-span-2 bg-indigo-50 p-3 rounded">
                                <p class="text-gray-500">Contract Amount</p>
                                <p class="text-lg font-bold text-indigo-700">{{ number_format($selectedContract->contract_amount, 2) }} {{ $selectedContract->currency }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end space-x-3">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>