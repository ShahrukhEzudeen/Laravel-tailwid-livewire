<div>
    @livewire('component-layout')
    <div id="main-content" class="relative h-full w-full overflow-x-scroll bg-gray-50 dark:bg-gray-900 lg:ms-64">
        <main>
            <div class="p-6 bg-white shadow rounded">
                <div x-data class="p-6 bg-white shadow rounded">

                    <h2 class="text-xl font-bold mb-4">Purchase List</h2>

                    <table class="w-full border border-gray-300 rounded">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2 text-left">Invoice</th>
                                <th class="p-2 text-left">Date</th>
                                <th class="p-2 text-right">Items</th>
                                <th class="p-2 text-right">Total Cost</th>
                                <th class="p-2 text-center">Status</th>
                                <th class="p-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchases as $purchase)
                            <tr class="border-t">
                                <td class="p-2">{{ $purchase->invoice_no }}</td>
                                <td class="p-2">{{ $purchase->purchase_date }}</td>
                                <td class="p-2 text-right">{{ $purchase->items_count }}</td>
                                <td class="p-2 text-right">RM {{ number_format($purchase->total_cost, 2) }}</td>
                                <td class="p-2 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-semibold
                                      {{ $purchase->status == 1 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $purchase->status == 1 ? 'Draft' : 'Received' }}
                                    </span>
                                </td>
                                <td class="p-2 text-center">
                                    @if ($purchase->status == 1)
                                    <button wire:click="confirmReceive({{ $purchase->id }})"
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded text-sm">
                                        Receive
                                    </button>
                                    @else
                                    <span class="text-gray-400 text-sm">Received</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    document.addEventListener('livewire:init', () => {

                        Livewire.on('confirm-receive', event => {
                            Swal.fire({
                                title: 'Receive this purchase?',
                                text: 'This will update stock quantities.',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#10B981',
                                cancelButtonColor: '#EF4444',
                                confirmButtonText: 'Yes, receive it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Livewire.dispatch('receiveConfirmed', {
                                        data: event[0].id
                                    });
                                }
                            });
                        });

                        Livewire.on('notify', event => {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: event[0].type,
                                title: event[0].message,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        });

                    })
                </script>

            </div>
        </main>
    </div>
</div>