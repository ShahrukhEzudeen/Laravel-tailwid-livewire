<div>
    @livewire('component-layout')
    <div id="main-content" class="relative h-full w-full overflow-x-scroll bg-gray-50 dark:bg-gray-900 lg:ms-64">
        <main>
            <div class="min-h-screen flex bg-gray-100">
                <!-- Fullscreen Content -->
                <div class="flex-1 p-6">
                    <div class="bg-white shadow-lg p-6 rounded-xl h-full">
                        <div class="flex justify-between items-center mb-4">
                            <h1 class="text-2xl font-bold text-gray-800">Category Management</h1>
                            <button wire:click="$dispatch('open-modal', { modal: 'add' })"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition">
                                + Add Category
                            </button>
                        </div>

                        <!-- Search + perPage -->
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">
                            <input type="text"
                                wire:model.lazy="search"
                                wire:keydown.enter="$refresh"
                                class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                                placeholder="Search categories by code or name...">
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 text-left text-sm font-semibold text-gray-600 uppercase">
                                        <th class="p-4 cursor-pointer" wire:click="sortBy('code')">
                                            Code
                                            @if ($categories === 'code')
                                            <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </th>
                                        <th class="p-4 cursor-pointer" wire:click="sortBy('name')">
                                            Name
                                            @if ($categories === 'name')
                                            <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                            @endif
                                        </th>
                                        <th class="p-4 text-center">Products</th>
                                        <th class="p-4 text-center">Status</th>
                                        <th class="p-4 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                    @forelse($categories as $cat)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="p-4 font-medium">{{ $cat->code }}</td>
                                        <td class="p-4 font-medium">{{ $cat->name }}</td>
                                        <td class="p-4 text-center">{{ $cat->products_count }}</td>
                                        <td class="p-4 text-center">
                                            <span class="px-2 py-1 rounded text-xs {{ $cat->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $cat->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-center space-x-2">
                                            <button wire:click="edit({{ $cat->id }})"
                                                class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm hover:bg-yellow-200 transition">
                                                Edit
                                            </button>
                                            <button wire:click="confirmDelete({{ $cat->id }})"
                                                class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm hover:bg-red-200 transition">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="p-6 text-center text-gray-500">No categories found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $categories->links() }}
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
                            text: "This category will be deleted permanently!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#e3342f',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Delete'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Livewire.dispatch('deleteConfirmed', {
                                    id: data.categoryId
                                });
                            }
                        });
                    });

                    Livewire.on('open-modal', data => {
                        Swal.fire({
                            title: `Category Info (New/Edit)`,
                            html: `
                    <input id="swal-code" class="swal2-input" placeholder="Code" value="${data[0]?.category ? data[0]?.category.code : ''}">
                    <input id="swal-name" class="swal2-input" placeholder="Name" value="${data[0]?.category ? data[0]?.category.name : ''}">
                    <label class="flex items-center justify-center mt-2">
                        <input type="checkbox" id="swal-active" ${data[0]?.category?.is_active ? 'checked' : ''}> Active
                    </label>
                `,
                            focusConfirm: true,
                            showCancelButton: true,
                            confirmButtonText: 'Save',
                            preConfirm: () => {
                                return {
                                    id: data[0]?.category ? data[0]?.category.id : null,
                                    code: document.getElementById('swal-code').value,
                                    name: document.getElementById('swal-name').value,
                                    is_active: document.getElementById('swal-active').checked ? 1 : 0
                                }
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Livewire.dispatch('save', {
                                    data: result.value
                                });
                            }
                        });
                    });
                });
            </script>
        </main>
    </div>
</div>