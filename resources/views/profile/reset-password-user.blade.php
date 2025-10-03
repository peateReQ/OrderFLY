<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Resetowanie hasła użytkownika
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-lg p-6">
            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800 shadow">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('admin.users.resetPassword', $user->id) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Nowe hasło</label>
                    <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200" required />
                </div>
                <div class="flex justify-end gap-2">
                    <x-button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white">Resetuj hasło</x-button>
                    <a href="{{ route('admin.panel') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg shadow transition">Anuluj</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
