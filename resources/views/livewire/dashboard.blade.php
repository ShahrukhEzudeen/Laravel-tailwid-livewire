<div>
    @livewire('component-layout')
    <div id="main-content" class="relative h-full w-full overflow-x-scroll bg-gray-50 dark:bg-gray-900 lg:ms-64">
        <main>
            <div class="min-h-screen flex bg-gray-100">
                <!-- Content -->
                <main class="flex-1 p-6 overflow-y-auto">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Users Card -->
                        <div
                            class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg transition">
                            <h2 class="mb-2 text-lg font-semibold tracking-tight text-gray-900">
                                Users
                            </h2>
                            <p class="font-normal text-gray-500">
                                120 Active
                            </p>
                        </div>

                        <!-- Sales Card -->
                        <div
                            class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg transition">
                            <h2 class="mb-2 text-lg font-semibold tracking-tight text-gray-900">
                                Sales
                            </h2>
                            <p class="font-normal text-gray-500">
                                $12,500
                            </p>
                        </div>

                        <!-- Reports Card -->
                        <div
                            class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg transition">
                            <h2 class="mb-2 text-lg font-semibold tracking-tight text-gray-900">
                                Reports
                            </h2>
                            <p class="font-normal text-gray-500">
                                5 Pending
                            </p>
                        </div>
                    </div>
                </main>
            </div>
        </main>
    </div>
</div>