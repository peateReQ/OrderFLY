

{{-- API --}}
<div class="bg-white shadow-xl sm:rounded-lg p-6 mb-8">
<div class="p-6 bg-white rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-2 text-gray-800 flex items-center">
        <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m4 0h-1v4h-1m-4 0h-1v-4h-1" /></svg>
        API
    </h2>
    <p class="mb-6 text-gray-600">Sekcja API jest w trakcie rozwoju. Wkrótce pojawią się tutaj funkcje zarządzania dostępem do API, generowania kluczy oraz dokumentacja endpointów.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Twój klucz API</label>
            <input type="text" class="w-full border-gray-300 rounded bg-gray-100 text-gray-400" value="************" disabled>
            <button class="mt-2 px-4 py-2 bg-blue-300 text-white rounded cursor-not-allowed opacity-60" disabled>Generuj nowy klucz</button>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Dostępne endpointy</label>
            <ul class="list-disc pl-5 text-gray-400">
                <li>/api/users <span class="italic">(wkrótce)</span></li>
                <li>/api/tokens <span class="italic">(wkrótce)</span></li>
                <li>/api/logs <span class="italic">(wkrótce)</span></li>
            </ul>
        </div>
    </div>

    <div class="mt-8 p-4 bg-blue-50 border-l-4 border-blue-400 text-blue-700">
        <strong>Informacja:</strong> Funkcje API będą dostępne po wdrożeniu kolejnych aktualizacji. Jeśli masz pytania lub potrzebujesz dostępu do API, skontaktuj się z administratorem systemu.
    </div>
</div>
</div>
<div class="flex flex-wrap gap-2 mt-2">
    <form action="{{ route('admin.panel.clearCache') }}" method="POST">
        @csrf
        <button type="submit" class="px-3 py-1 rounded border border-gray-300 bg-white text-gray-700 text-sm hover:bg-gray-100 transition" title="Wyczyść cache">
            Wyczyść cache
        </button>
    </form>
    <a href="{{ route('admin.panel.systemLogs') }}" class="px-3 py-1 rounded border border-gray-300 bg-white text-gray-700 text-sm hover:bg-gray-100 transition" title="Zobacz logi systemowe">
        Logi systemowe
    </a>
    <a href="{{ route('admin.panel.auditLogs') }}" class="px-3 py-1 rounded border border-indigo-500 bg-indigo-50 text-indigo-700 text-sm font-semibold hover:bg-indigo-100 transition" title="Zobacz logi audytowe">
        Logi audytowe
    </a>
</div>
            <label class="block text-sm font-medium text-gray-700">Ostatnia aktywność</label>
            <input type="text" class="border border-gray-300 rounded px-3 py-2 w-full bg-gray-100 text-gray-400" value="Brak danych" disabled />
        </div>
        <button type="button" class="px-4 py-2 rounded bg-gray-300 text-gray-500 cursor-not-allowed" disabled>Generuj nowy klucz</button>
    </form>
