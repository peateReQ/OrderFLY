<!-- Modal dodawania użytkownika -->
<div id="add-user-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display:none;">
    <div class="bg-white rounded-lg shadow-lg px-4 py-6 w-full max-w-md" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
        <h3 class="text-lg font-semibold mb-4">Dodaj użytkownika</h3>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nazwa</label>
                <input type="text" name="name" class="border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" required />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" class="border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" required />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Hasło</label>
                <input type="password" name="password" class="border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" required minlength="6" />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select name="roles[]" multiple class="border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Aktywny</label>
                <input type="checkbox" name="active" value="1" checked />
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300 transition" onclick="document.getElementById('add-user-modal').style.display='none'">Anuluj</button>
                <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition">Dodaj</button>
            </div>
        </form>
    </div>
</div>
<div class="flex items-center justify-between mb-2">
    <h3 class="text-lg font-semibold">Użytkownicy systemu</h3>
    <button type="button" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition flex items-center gap-2" onclick="document.getElementById('add-user-modal').style.display='block'">
        <i class="fas fa-plus text-sm"></i>
        <span class="text-sm">Dodaj użytkownika</span>
    </button>
</div>
<p class="text-sm text-gray-500 mt-1 mb-6">Ta sekcja pozwala zarządzać użytkownikami systemu CRM. Możesz dodawać, edytować, usuwać użytkowników, resetować hasła oraz przypisywać role. Wszelkie zmiany są rejestrowane w logach audytowych.</p>
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imię</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktywny</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ostatnie logowanie</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Akcje</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @foreach ($user->roles as $role)
                            @php
                                $roleStyles = [
                                    'Administrator' => 'bg-red-100 text-red-800 border border-red-500',
                                    'Manager Sprzedaży' => 'bg-blue-200 text-blue-900 border border-blue-500',
                                    'Handlowiec' => 'bg-green-100 text-green-800 border border-green-500',
                                    'Obsługa Klienta' => 'bg-yellow-100 text-yellow-800 border border-yellow-500',
                                    'Magazynier' => 'bg-purple-200 text-purple-900 border border-purple-500',
                                    'Pracownik Produkcji' => 'bg-pink-200 text-pink-900 border border-pink-500',
                                    'Księgowość' => 'bg-gray-100 text-gray-800 border border-gray-500',
                                ];
                                $roleKey = trim($role->name);
                                $roleStyle = $roleStyles[$roleKey] ?? 'bg-indigo-100 text-indigo-800 border border-indigo-500';
                            @endphp
                            <span class="inline-block {{ $roleStyle }} text-xs px-2 py-1 rounded mr-1">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($user->active)
                            <span class="text-green-600 font-semibold">Tak</span>
                        @else
                            <span class="text-red-600 font-semibold">Nie</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->last_login_at)
                            <span class="text-gray-700">{{ $user->last_login_at->format('Y-m-d H:i') }}</span>
                        @else
                            <span class="text-gray-400">Brak danych</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <!-- Edycja użytkownika w modalu -->
                        <button type="button" class="btn btn-success btn-sm" onclick="document.getElementById('edit-modal-{{ $user->id }}').style.display='block'" title="Edytuj">
                            <i class="fas fa-edit" style="color:#22c55e;"></i>
                        </button>
                        <!-- Modal edycji -->
                        <div id="edit-modal-{{ $user->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display:none;">
                            <div class="bg-white rounded-lg shadow-lg px-4 py-6 w-full max-w-md" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
                                <h3 class="text-lg font-semibold mb-4">Edytuj użytkownika</h3>
                                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Imię</label>
                                        <input type="text" name="name" value="{{ $user->name }}" class="border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" />
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" name="email" value="{{ $user->email }}" class="border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" />
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Role</label>
                                        <select name="roles[]" multiple class="border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}" @if($user->roles->contains($role)) selected @endif>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Aktywny</label>
                                        <input type="checkbox" name="active" value="1" @if($user->active) checked @endif />
                                    </div>
                                    <div class="flex justify-end gap-2 mt-4">
                                        <button type="button" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300 transition" onclick="document.getElementById('edit-modal-{{ $user->id }}').style.display='none'">Anuluj</button>
                                        <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition">Zapisz</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <button type="button" class="btn btn-warning btn-sm ml-1" title="Resetuj hasło" onclick="document.getElementById('reset-modal-{{ $user->id }}').style.display='block'">
                            <i class="fas fa-key" style="color:#f59e42;"></i>
                        </button>
                        <!-- Modal resetowania hasła -->
                        <div id="reset-modal-{{ $user->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display:none;">
                            <div class="bg-white rounded-lg shadow-lg px-4 py-6 w-full max-w-md" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
                                <h3 class="text-lg font-semibold mb-4">Resetuj hasło użytkownika</h3>
                                <form action="{{ route('admin.users.resetPassword', $user->id) }}" method="POST">
                                    @csrf
                                    @if ($errors->any())
                                        <div class="mb-4">
                                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
                                                <ul class="list-disc pl-5">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700">Nowe hasło</label>
                                        <input type="password" name="password" class="border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" required minlength="6" />
                                    </div>
                                    <div class="flex justify-end gap-2 mt-4">
                                        <button type="button" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300 transition" onclick="document.getElementById('reset-modal-{{ $user->id }}').style.display='none'">Anuluj</button>
                                        <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition">Zapisz</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Modal usuwania użytkownika -->
                        <div id="delete-modal-{{ $user->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display:none;">
                            <div class="bg-white rounded-lg shadow-lg px-4 py-6 w-full max-w-md" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
                                <h3 class="text-lg font-semibold mb-4 text-red-600">Usuń użytkownika</h3>
                                <p class="mb-4 text-gray-700 break-words max-w-full">Czy na pewno chcesz usunąć użytkownika <span class="font-bold">{{ $user->name }}</span>?<br>Tej operacji nie można cofnąć.</p>
                                <form id="delete-user-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="flex justify-end gap-2 mt-4">
                                        <button type="button" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300 transition" onclick="document.getElementById('delete-modal-{{ $user->id }}').style.display='none'">Anuluj</button>
                                        <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700 transition">Usuń</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm ml-1" title="Usuń" onclick="document.getElementById('delete-modal-{{ $user->id }}').style.display='block'">
                            <i class="fas fa-trash" style="color:#ef4444;"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Brak użytkowników</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">
    {{ $users->links() }}
</div>
