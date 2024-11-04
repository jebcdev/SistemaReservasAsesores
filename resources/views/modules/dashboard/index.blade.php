<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 dark:text-gray-100">

                    {{-- Main Content --}}
                    <div>

                        {{-- Main Menu --}}
                        @auth
                            @if(Auth::user()->role_id == 1)
                                @includeIf('modules.dashboard.partials.admin-main-menu')
                            @elseif(Auth::user()->role_id == 2)
                                @includeIf('modules.dashboard.partials.consultants-main-menu')
                            @elseif(Auth::user()->role_id == 3)
                                @includeIf('modules.dashboard.partials.clients-main-menu')
                            @endif
                        @endauth
                        {{-- Main Menu --}}

                    </div>
                    {{-- Main Content --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
