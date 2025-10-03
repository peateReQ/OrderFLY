<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edycja użytkownika
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl sm:rounded-lg p-6">
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-4 flex items-center gap-4">
                    @if($user->profile_photo_url)
                        <img src="{{ $user->profile_photo_url }}" alt="avatar" class="w-16 h-16 rounded-full object-cover shadow" />
                    @else
                        <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 text-indigo-600 font-bold shadow">{{ strtoupper(substr($user->name,0,2)) }}</span>
                    @endif
                    <div>
                        <div class="font-semibold text-lg text-gray-800">{{ $user->name }}</div>
                        <div class="text-gray-500 flex items-center"><svg class="w-4 h-4 mr-1 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12A4 4 0 118 12a4 4 0 018 0z" /></svg>{{ $user->email }}</div>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Role</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($roles as $role)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}" @if($user->hasRole($role->name)) checked @endif class="form-checkbox rounded text-indigo-600" />
                                <span class="ml-2 text-gray-700">{{ $role->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Status</label>
                    <select name="active" class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200">
                        <option value="1" @if($user->active) selected @endif>Aktywny</option>
                        <option value="0" @if(!$user->active) selected @endif>Nieaktywny</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <x-button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white">Zapisz zmiany</x-button>
                    <a href="{{ route('admin.panel') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg shadow transition">Anuluj</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
