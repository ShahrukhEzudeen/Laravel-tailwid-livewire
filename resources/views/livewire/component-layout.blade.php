<div>
    <nav class="fixed z-10 flex h-16 w-full items-center border-b border-gray-200 bg-white px-4 dark:border-gray-700 dark:bg-gray-800">
        <div class="flex w-full items-center justify-between">
            <div class="flex items-center justify-start">
                <button
                    id="togglSidebarButton"
                    aria-expanded="true"
                    aria-controls="sidebar"
                    class="me-2 hidden cursor-pointer rounded-sm p-1.5 text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white sm:-ms-1 lg:inline">
                    <svg class="h-7 w-7" data-sidebar-toggle-collapse-icon aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10" />
                    </svg>
                    <svg class="hidden h-7 w-7" data-sidebar-toggle-expand-icon aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
                    </svg>
                </button>
                <button
                    data-drawer-target="sidebar"
                    data-drawer-toggle="sidebar"
                    aria-expanded="false"
                    aria-controls="sidebar"
                    class="me-2 inline cursor-pointer rounded-sm p-1.5 text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white sm:-ms-1 lg:hidden">
                    <svg class="h-7 w-7" data-sidebar-toggle-collapse-icon aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h10" />
                    </svg>
                </button>
                <a href="#" class="mr-4 flex">
                    <span class="self-center whitespace-nowrap text-2xl font-semibold dark:text-white">Kedai Pak Abu</span>
                </a>
            </div>

        </div>
    </nav>
    <div class="flex overflow-hidden bg-gray-50 pt-[62px] dark:bg-gray-900">
        @livewire('sidebar')
    </div>
</div>