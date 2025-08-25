<div>
    @livewire('component-layout')
    <div id="main-content" class="relative h-full w-full overflow-x-scroll bg-gray-50 dark:bg-gray-900 lg:ms-64">
        <main>
            <div>
                <div class="p-6 bg-white rounded-xl shadow space-y-4">
                    <h1 class="text-xl font-bold">Audit Trail</h1>

                    <!-- Search + Filters -->
                    <div class="flex justify-between items-center">
                        <input type="text" wire:model.lazy="search"
                            wire:keydown.enter="$refresh"
                            placeholder="Search actions..."
                            class="border rounded p-2 w-1/3">
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left border border-gray-200">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-2">User</th>
                                    <th class="px-4 py-2">Action</th>
                                    <th class="px-4 py-2">Old Values</th>
                                    <th class="px-4 py-2">New Values</th>
                                    <th class="px-4 py-2">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse($logs as $log)
                                <tr>
                                    <td class="px-4 py-2">{{ $log->user->name ?? 'System' }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 text-xs rounded
                                @if($log->action == 'Create') bg-green-200 text-green-800
                                @elseif($log->action == 'Cpdate') bg-blue-200 text-blue-800
                                @elseif($log->action == 'Delete') bg-red-200 text-red-800
                                @else bg-gray-200 text-gray-800 @endif">
                                            {{ ucfirst($log->action) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">
                                        <pre class="text-xs text-gray-600">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                                    </td>
                                    <td class="px-4 py-2">
                                        <pre class="text-xs text-gray-600">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                                    </td>
                                    <td class="px-4 py-2 text-gray-500">{{ $log->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                                        No audit logs found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div>
                        {{ $logs->links() }}
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>