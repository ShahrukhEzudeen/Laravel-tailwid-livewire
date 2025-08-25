<div>
    @livewire('component-layout')
    <div id="main-content" class="relative h-full w-full overflow-x-scroll bg-gray-50 dark:bg-gray-900 lg:ms-64">
        <main>

            <div class="p-6 bg-white shadow rounded">
                <h2 class="text-xl font-bold mb-4">Create Purchase</h2>

                <div class="mb-4">
                    <label class="block font-semibold">Invoice No</label>
                    <input type="text" wire:model="invoice_no" class="w-full border rounded p-2" />
                       @error('invoice_no') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Purchase Date</label>
                    <input type="date" wire:model="purchase_date" class="w-full border rounded p-2" />
                       @error('purchase_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <h3 class="font-semibold mb-2">Items</h3>
                @foreach ($items as $index => $item)
                <div class="grid grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Product</label>
                        <select wire:model="items.{{ $index }}.product_id" class="w-full border rounded p-2">
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                       
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Quantity</label>
                        <input type="number"
                            wire:model="items.{{ $index }}.qty"
                            wire:change="calculateTotal"
                            class="w-full border rounded p-2" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Unit Cost</label>
                        <input type="number"
                            wire:model="items.{{ $index }}.unit_cost"
                            wire:change="calculateTotal"
                            class="w-full border rounded p-2" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Line Total</label>
                        <div class="p-2 border rounded bg-gray-50 text-right font-bold">
                            RM {{ number_format($item['qty'] * $item['unit_cost'], 2) }}
                        </div>
                    </div>
                </div>
                @endforeach

                <button wire:click="addItem" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Add Item</button>

                <div class="text-right font-bold text-lg mb-4">
                    Total: RM {{ number_format($total_cost, 2) }}
                </div>

                <button wire:click="savePurchase" class="bg-green-600 text-white px-6 py-2 rounded">Save Purchase</button>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener('livewire:init', () => {

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
        </main>
    </div>
</div>