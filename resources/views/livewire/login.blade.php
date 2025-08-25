
    <div class="min-h-screen flex items-center justify-center bg-gray-100">

        <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
            <form wire:submit.prevent="login">
                <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" wire:model="email" class="w-full mt-1 p-2 border rounded" />
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Password</label>
                    <input type="password" wire:model="password" class="w-full mt-1 p-2 border rounded" />
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" wire:model="remember" class="form-checkbox" />
                        <span class="ml-2">Remember me</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Login
                </button>
            </form>
        </div>
    </div>
