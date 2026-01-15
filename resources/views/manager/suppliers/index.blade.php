<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Supplier Management') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Add / Search Supplier -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Search -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Search Suppliers</h3>
                        <form method="GET" action="{{ route('manager.suppliers.index') }}" class="flex gap-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">Search</button>
                            @if(request('search'))
                                <a href="{{ route('manager.suppliers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">Reset</a>
                            @endif
                        </form>
                    </div>

                    <!-- Add New -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Supplier</h3>
                        <form method="POST" action="{{ route('manager.suppliers.store') }}" class="flex gap-2">
                            @csrf
                            <div class="flex-grow">
                                <input type="text" name="name" required placeholder="Supplier Name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">Add</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Suppliers List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supplier Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($suppliers as $supplier)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $supplier->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <form action="{{ route('manager.suppliers.update', $supplier) }}" method="POST" class="flex gap-2">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="name" value="{{ $supplier->name }}" class="border-gray-300 rounded-md shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 px-2 py-1 w-full md:w-64">
                                                <button type="submit" class="text-indigo-600 hover:text-indigo-900 text-xs uppercase font-bold">Update</button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $supplier->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('manager.suppliers.destroy', $supplier) }}" method="POST" onsubmit="return confirm('Are you sure? This will unlink this supplier from all assets.');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No suppliers found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $suppliers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
