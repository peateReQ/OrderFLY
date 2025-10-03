<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel administratora') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8" x-data="{ tab: 'general' }">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        <nav class="flex border-b border-gray-200 mb-8">
            <button type="button" @click="tab = 'general'" :class="tab === 'general' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-600'" class="px-4 py-2 -mb-px border-b-2 font-semibold focus:outline-none">Ogólne</button>
            <button type="button" @click="tab = 'users'" :class="tab === 'users' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-600'" class="px-4 py-2 border-b-2 font-semibold focus:outline-none">Użytkownicy</button>
            <button type="button" @click="tab = 'system'" :class="tab === 'system' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-600'" class="px-4 py-2 border-b-2 font-semibold focus:outline-none">System</button>
        </nav>

        <div x-show="tab === 'general'">
            <!-- ...Ogólne... -->
            @include('profile.admin-panel-general')
        </div>
        <div x-show="tab === 'users'">
            <!-- ...Użytkownicy... -->
            @include('profile.admin-panel-users')
        </div>
        <div x-show="tab === 'system'">
            <!-- ...System... -->
            @include('profile.admin-panel-system')
        </div>
    </div>
</x-app-layout>
