@if(auth()->user() && auth()->user()->hasRole('Administrator'))
    <x-nav-link href="{{ route('admin.panel') }}" :active="request()->routeIs('admin.panel')">
        {{ __('Panel administratora') }}
    </x-nav-link>
@endif
