<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('System Audit Logs') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details (Modifications)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($audits as $audit)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $audit->user->name ?? 'System/Unknown' }} 
                                    <span class="text-xs text-gray-400 block">ID: {{ $audit->user_id }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($audit->event == 'created') bg-green-100 text-green-800 
                                        @elseif($audit->event == 'updated') bg-blue-100 text-blue-800 
                                        @elseif($audit->event == 'deleted') bg-red-100 text-red-800 
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($audit->event) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ class_basename($audit->auditable_type) }} <br>
                                    <span class="text-xs">ID: {{ $audit->auditable_id }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <div class="max-w-xs overflow-hidden">
                                        @foreach($audit->getModified() as $attribute => $modified)
                                            <div class="mb-1 text-xs">
                                                <strong>{{ $attribute }}:</strong>
                                                @if(isset($modified['old']))
                                                    <span class="text-red-500 line-through">{{ Str::limit($modified['old'], 20) }}</span> ->
                                                @endif
                                                <span class="text-green-600">{{ Str::limit($modified['new'] ?? 'N/A', 20) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $audit->created_at->format('Y-m-d H:i:s') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No logs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $audits->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
