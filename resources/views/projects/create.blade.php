<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Project') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-2xl mx-auto">
        <div class="p-6 bg-white border-b border-gray-200">
            <form action="{{ route('projects.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="project_code" class="block text-sm font-medium text-gray-700">Project Code</label>
                    <input type="text" name="project_code" id="project_code" value="{{ old('project_code') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                </div>

                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700">Project Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                </div>

                <div class="flex items-center justify-end">
                    <a href="{{ route('projects.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                        Save Project
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
