<div class="min-h-screen bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                <!-- Logo / Brand -->
                <div class="flex-shrink-0 text-xl font-bold text-blue-600">
                    MyShop
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-6 text-gray-700 font-medium">
                    <a href="{{ route('store') }}" class="hover:text-blue-600 {{ request()->routeIs('store') ? 'text-blue-600' : '' }}">Home</a>
                    <a href="{{ route('orderdetails') }}" class="hover:text-blue-600">Orders</a>
                    <a href="{{ route('pay') }}" class="hover:text-blue-600 {{ request()->routeIs('pay') ? 'text-blue-600' : '' }}">Cart ({{ count($cart) }})</a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobile-menu-btn" class="text-gray-600 hover:text-blue-600 focus:outline-none">
                        ☰
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200">
            <a href="{{ route('store') }}" class="block px-4 py-2 hover:bg-gray-100">Home</a>
            <a href="{{ route('orderdetails') }}" class="block px-4 py-2 hover:bg-gray-100">Orders</a>
            <a href="{{ route('pay') }}" class="block px-4 py-2 hover:bg-gray-100">Cart ({{ count($cart) }})</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="p-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <!-- Sidebar Filters -->
            <aside class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Filters</h2>

                <!-- Category Filter -->
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-600 mb-2">Category</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li>
                            <input type="radio" value="Laptop" id="cat1" wire:model="filteritem" class="mr-2">
                            <label for="cat1">Laptops</label>
                        </li>
                        <li>
                            <input type="radio" value="Headphone" id="cat2" wire:model="filteritem" class="mr-2">
                            <label for="cat2">Headphones</label>
                        </li>
                        <li>
                            <input type="radio" value="Phone" id="cat3" wire:model="filteritem" class="mr-2">
                            <label for="cat3">Phones</label>
                        </li>
                    </ul>
                </div>

                <!-- Price Range -->
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-600 mb-2">Price Range</h3>
                    <input type="range" min="0" max="11000" step="50" wire:model="maxPrice" class="w-full">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>RM0</span>
                        <span>RM{{ $maxPrice }}</span>
                    </div>
                </div>

                <!-- Apply Filters Button (Optional) -->
                <button
                    wire:click="filter"
                    class="w-full py-2 px-4 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200">
                    Apply Filters
                </button>
            </aside>

            <!-- Product Grid -->
            <div class="lg:col-span-3">
                <h1 class="text-3xl font-bold mb-6 text-gray-800 tracking-tight">
                    Featured Products
                </h1>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                    @foreach($products as $product)
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden">

                        <!-- Product Image from Unsplash -->
                        <div class="h-48 bg-gray-100">
                            <img src="{{ $product['image_url'] }}"
                                alt="{{ $product['name'] }}"
                                class="w-full h-full object-cover">
                        </div>

                        <!-- Product Details -->
                        <div class="p-5">
                            <h2 class="text-lg font-semibold text-gray-800 mb-2">
                                {{ $product['name'] }}
                            </h2>
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">
                                {{ $product['description'] }}
                            </h4>
                            <p class="text-lg text-blue-600 font-medium mb-4">
                                ${{ number_format($product['price'], 2) }}
                            </p>

                            <!-- Add to Cart Button -->
                            <button
                                wire:click="addToCart({{ $product['id'] }})"
                                class="w-full py-2.5 px-4 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('mobile-menu-btn').addEventListener('click', () => {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>