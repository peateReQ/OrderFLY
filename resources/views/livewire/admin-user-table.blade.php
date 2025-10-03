<div>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <div class="flex-1">
            <input type="text" wire:model.debounce.500ms="search" placeholder="Szukaj użytkownika..." class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-indigo-200" />
        </div>
        <div class="flex gap-2">
            <select wire:model="role" class="px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200">
                <option value="">Wszystkie role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
            <select wire:model="status" class="px-3 py-2 border rounded-lg focus:ring focus:ring-indigo-200">
                <option value="">Wszystkie statusy</option>
                <option value="aktywny">Aktywny</option>
                <option value="nieaktywny">Nieaktywny</option>
            </select>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Użytkownik</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rola</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ostatnie logowanie</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Akcje</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($users as $user)
                    <tr class="hover:shadow-lg transition-shadow">
                        <td class="px-6 py-4 whitespace-nowrap flex items-center gap-3">
                            @if($user->profile_photo_url)
                                <img src="{{ $user->profile_photo_url }}" alt="avatar" class="w-10 h-10 rounded-full object-cover shadow" />
                            @else
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 font-bold shadow">{{ strtoupper(substr($user->name,0,2)) }}</span>
                            @endif
                            <span class="font-semibold text-gray-800">{{ $user->name }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ implode(', ', $user->getRoleNames()->toArray()) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-medium {{ $user->active ? 'text-green-600' : 'text-gray-400' }}">{{ $user->active ? 'Aktywny' : 'Nieaktywny' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->last_login_at ? $user->last_login_at->format('d.m.Y H:i') : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right flex gap-2 justify-end">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-flex items-center px-3 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg shadow transition">Edytuj</a>
                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" style="display:inline;" onsubmit="return confirm('Czy na pewno chcesz usunąć użytkownika?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg shadow transition">Usuń</button>
                            </form>
                            <a href="{{ route('admin.users.resetPassword', $user->id) }}" class="inline-flex items-center px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg shadow transition">Resetuj hasło</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Brak użytkowników</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
