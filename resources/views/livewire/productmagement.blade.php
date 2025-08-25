<div>
    @livewire('component-layout')
    <div id="main-content" class="relative h-full w-full overflow-x-scroll bg-gray-50 dark:bg-gray-900 lg:ms-64">
        <main>

            <div class="min-h-screen flex bg-gray-100">
                <!-- Fullscreen Content -->
                <div class="flex-1 p-6">
                    <div class="bg-white shadow-lg p-6 rounded-xl h-full">
                        <div class="flex justify-between items-center mb-4">
                            <h1 class="text-2xl font-bold text-gray-800">Product Management</h1>
                            <button wire:click="edit()"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition">
                                + Order Product
                            </button>
                        </div>

                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">

                            <input type="text"
                                wire:model.defer="search"
                                class="w-full md:w-1/3 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                                placeholder="Search by name, ID, or SKU...">


                            <select wire:model.defer="status"
                                class="w-full md:w-1/4 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                                <option value="">All Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>


                            <select wire:model.defer="category"
                                class="w-full md:w-1/4 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->code }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>


                            <button wire:click="applyFilters"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Search
                            </button>
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 text-left text-sm font-semibold text-gray-600 uppercase">
                                        <th class="p-4 cursor-pointer" wire:click="sortBy('id')">
                                            ID
                                            @if ($sortField === 'id')
                                            <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </th>
                                        <th class="p-4 cursor-pointer" wire:click="sortBy('id')">
                                            Thumb Nail
                                        </th>

                                        <th class="p-4 cursor-pointer" wire:click="sortBy('id')">
                                            Name
                                        </th>
                                        <th class="p-4 cursor-pointer" wire:click="sortBy('name')">
                                            SKU
                                        </th>
                                        <th class="p-4 cursor-pointer" wire:click="sortBy('cost_price')">
                                            Cost Price
                                            @if ($sortField === 'cost_price')
                                            <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </th>
                                        <th class="p-4 cursor-pointer" wire:click="sortBy('sell_price')">
                                            Selling price
                                            @if ($sortField === 'sell_price')
                                            <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </th>
                                        <th class="p-4 cursor-pointer" wire:click="sortBy('qty_on_hand')">
                                            Quantity On Hand
                                            @if ($sortField === 'qty_on_hand')
                                            <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </th>
                                        <th class="p-4 cursor-pointer" wire:click="sortBy('created_at')">
                                            Created At
                                            @if ($sortField === 'created_at')
                                            <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </th>
                                        <th class="p-4 cursor-pointer" wire:click="sortBy('updated_at')">
                                            Updated At
                                            @if ($sortField === 'updated_at')
                                            <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </th>
                                        <th class="p-4 cursor-pointer">
                                            Status
                                        </th>
                                        <th class="p-4 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                    @forelse($item as $items)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="p-4 font-medium">{{ $items->id }}</td>
                                        <td class="p-4">
                                            <img src="{{ asset('storage/' . $items->thumbnail_path) }}"
                                                alt="Thumbnail"
                                                class="w-30 h-30 object-cover rounded-md">
                                        </td>
                                        <td class="p-4 font-medium">{{ $items->name }}</td>
                                        <td class="p-4">{{ $items->sku }}</td>
                                        <td class="p-4">{{ $items->cost_price }}</td>
                                        <td class="p-4">{{ $items->sell_price }}</td>
                                        <td class="p-4">{{ $items->qty_on_hand }}</td>
                                        <td class="p-4">{{ $items->created_at }}</td>
                                        <td class="p-4">{{ $items->updated_at }}</td>
                                        <td class="p-4 text-center">
                                            <span class="px-2 py-1 rounded text-xs {{ $items->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $items->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-center space-x-2">
                                            <button wire:click="edit({{ $items->id }})"
                                                class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm hover:bg-yellow-200 transition">
                                                Edit
                                            </button>
                                            <button wire:click="confirmDelete({{ $items->id }})"
                                                class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm hover:bg-red-200 transition">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="p-6 text-center text-gray-500">No Product found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <input type="file" wire:model="image" id="hidden-image" class="hidden" accept="image/*">
                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $item->links() }}
                        </div>
                    </div>
                </div>
            </div>



            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener('livewire:init', () => {

                    Livewire.on('show-toast', data => {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    });

                    Livewire.on('show-error', data => {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    });

                    Livewire.on('confirm-delete', data => {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This product will be deleted permanently!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#e3342f',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Delete'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Livewire.dispatch('deleteConfirmed', {
                                    id: data.userId
                                });
                            }
                        });
                    });

                    Livewire.on('open-modal', data => {
                        Swal.fire({
                            title: `<h2 class="text-lg font-semibold mb-3">Product Info</h2>`,
                            html: `
        <div class="grid gap-4 text-left">
            <div>
                <label class="block text-sm font-medium mb-1">Name</label>
                <input id="swal-name" type="text"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                    placeholder="Product Name"
                    value="${data[0]?.product ? data[0]?.product.name : ''}">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">SKU</label>
                <div class="flex gap-2">
                    <input id="swal-sku" type="text"
                        class="flex-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                        placeholder="SKU"
                        value="${data[0]?.product ? data[0]?.product.sku : ''}">
                    <button type="button" id="generate-sku"
                        class="px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                        Generate
                    </button>
                </div>
            </div>

                <div>
        <label class="block text-sm font-medium mb-1">Category</label>
    <select id="swal-category" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
    <option value="">-- Select Category --</option>
    ${data[0]?.categories.map(cat => `
        <option value="${cat.code}" ${data[0]?.product?.category_code == cat.code ? 'selected' : ''}>
            ${cat.name}
        </option>
    `).join('')}
</select>
    </div>
            <div>
                <label class="block text-sm font-medium mb-1">Cost Price</label>
                <input id="swal-cost_price" type="number"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                    placeholder="Cost Price"
                    value="${data[0]?.product ? data[0]?.product.cost_price : ''}">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Selling Price</label>
                <input id="swal-sell_price" type="number"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                    placeholder="Selling Price"
                    value="${data[0]?.product ? data[0]?.product.sell_price : ''}">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Quantity</label>
                <input id="swal-qty_on_hand" type="number"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                    placeholder="Quantity"
                    value="${data[0]?.product ? data[0]?.product.qty_on_hand : ''}">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Image</label>
                <input id="swal-image" type="file" accept="image/*"
                    class="w-full text-sm border rounded-lg px-3 py-2 cursor-pointer bg-white">
            </div>

            <label class="flex items-center justify-center mt-2">
                        <input type="checkbox" id="swal-active" ${data[0]?.product?.is_active ? 'checked' : ''}> Active
                    </label>
        </div>`,
                            focusConfirm: true,
                            showCancelButton: true,
                            confirmButtonText: 'Save',
                            customClass: {
                                popup: 'rounded-2xl p-6',
                                confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg ml-2',
                                cancelButton: 'bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded-lg'
                            },
                            preConfirm: () => {
                                const file = document.getElementById('swal-image').files[0];
                                if (file && file.size > 5 * 1024 * 1024) {
                                    Swal.showValidationMessage('Image size must be less than 5MB');
                                    return false;
                                }

                                return {
                                    id: data[0]?.product ? data[0]?.product.id : null,
                                    name: document.getElementById('swal-name').value,
                                    sku: document.getElementById('swal-sku').value,
                                    category_code: document.getElementById('swal-category').value,
                                    cost_price: document.getElementById('swal-cost_price').value,
                                    sell_price: document.getElementById('swal-sell_price').value,
                                    qty_on_hand: document.getElementById('swal-qty_on_hand').value,
                                    is_active: document.getElementById('swal-active').checked ? 1 : 0,
                                    image: file,
                                }
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Livewire.dispatch('save', {
                                    data: result.value
                                });
                            }
                        });

                        document.getElementById('swal-image').addEventListener('change', (e) => {
                            const hiddenInput = document.getElementById('hidden-image');
                            hiddenInput.files = e.target.files;
                            hiddenInput.dispatchEvent(new Event('change'));
                        });

                        document.getElementById('generate-sku').addEventListener('click', () => {
                            const randomSku = 'SKU-' + Math.random().toString(36).substr(2, 6).toUpperCase();
                            document.getElementById('swal-sku').value = randomSku;
                        });
                    });




                });
            </script>

        </main>
    </div>
</div>
