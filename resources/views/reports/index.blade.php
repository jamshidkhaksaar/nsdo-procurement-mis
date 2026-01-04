<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Asset Reports') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-4xl mx-auto">
        <div class="p-6 bg-white border-b border-gray-200">
            <form action="" method="GET" id="reportForm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Project Filter -->
                    <div>
                        <label for="project_id" class="block text-sm font-medium text-gray-700">Filter by Project</label>
                        <select name="project_id" id="project_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">All Projects</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Condition Filter -->
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700">Filter by Condition</label>
                        <select name="condition" id="condition" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">All Conditions</option>
                            @foreach(['New', 'Good', 'Fair', 'Poor', 'Broken'] as $cond)
                                <option value="{{ $cond }}">{{ $cond }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <button type="submit" formaction="{{ route('reports.export.excel') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded shadow transition">
                        Export to Excel
                    </button>
                    <button type="submit" formaction="{{ route('reports.export.pdf') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow transition">
                        Export to PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
