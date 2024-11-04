<div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>

    <x-nav-link :href="route('consultants.index')" :active="request()->routeIs('consultants.index')">
        {{ __('Administration') }}
    </x-nav-link>

    <x-nav-link :href="route('adminlte.darkmode.toggle')" :active="request()->routeIs('adminlte.darkmode.toggle')">
        {{ __('Toggle') }}
    </x-nav-link>
</div>
