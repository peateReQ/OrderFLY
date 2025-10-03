<!-- Sekcja: Informacje techniczne i akcje systemowe -->
<div class="mb-6">
    <h3 class="text-lg font-semibold mb-2">Informacje techniczne</h3>
    <p class="text-sm text-gray-500 mt-1 mb-6">Ta sekcja zawiera szczegółowe dane techniczne dotyczące środowiska, konfiguracji oraz statusu Twojego systemu CRM. Pozwala na szybkie sprawdzenie parametrów serwera, bazy danych, ustawień PHP oraz innych kluczowych informacji.</p>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
        <ul class="list-disc pl-5">
            <li><strong>Wersja PHP:</strong> {{ phpversion() }}</li>
            <li><strong>Wersja Laravel:</strong> {{ app()->version() }}</li>
            <li><strong>Wersja MySQL:</strong> {{ DB::connection()->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION) ?? 'Brak' }}</li>
            <li><strong>Typ bazy danych:</strong> {{ DB::getDriverName() }}</li>
            <li><strong>Serwer:</strong> {{ $_SERVER['SERVER_SOFTWARE'] ?? 'Brak' }}</li>
            <li><strong>System operacyjny:</strong> {{ php_uname('s') }} {{ php_uname('r') }}</li>
            <li><strong>IP serwera:</strong> {{ $_SERVER['SERVER_ADDR'] ?? request()->server('SERVER_ADDR') ?? 'Brak' }}</li>
            <li><strong>APP_ENV:</strong> {{ config('app.env') }}</li>
            <li><strong>APP_URL:</strong> {{ config('app.url') }}</li>
            <li><strong>Locale:</strong> {{ config('app.locale') }}</li>
            <li><strong>Timezone:</strong> {{ config('app.timezone') }}</li>
            <li><strong>Status debugowania:</strong> {{ config('app.debug') ? 'Włączony' : 'Wyłączony' }}</li>
            <li><strong>Czas serwera:</strong> {{ now()->format('Y-m-d H:i:s') }}</li>
        </ul>
        <ul class="list-disc pl-5">
            <li><strong>Driver sesji:</strong> {{ config('session.driver') }}</li>
            <li><strong>Storage symlink:</strong> <span class="{{ file_exists(public_path('storage')) ? 'text-green-600' : 'text-red-600' }}">{{ file_exists(public_path('storage')) ? 'OK' : 'Brak' }}</span></li>
            <li><strong>Cache driver:</strong> {{ config('cache.default') }}</li>
            <li><strong>Log channel:</strong> {{ config('logging.default') }}</li>
            <li><strong>Max upload size:</strong> {{ ini_get('upload_max_filesize') }}</li>
            <li><strong>Max execution time:</strong> {{ ini_get('max_execution_time') }}s</li>
            <li><strong>Memory limit:</strong> {{ ini_get('memory_limit') }}</li>
            <li><strong>Pamięć używana przez PHP:</strong> {{ number_format(memory_get_usage(true)/1048576,2) }} MB</li>
            <li><strong>Ilość użytkowników:</strong> {{ \App\Models\User::count() }}</li>
            <li><strong>Ilość ról:</strong> {{ \Spatie\Permission\Models\Role::count() }}</li>
            <li><strong>Ilość plików w storage/app/public:</strong> {{ count(\File::files(storage_path('app/public'))) }}</li>
            <li><strong>Ścieżka public:</strong> {{ public_path() }}</li>
            <li><strong>Ścieżka storage:</strong> {{ storage_path() }}</li>
        </ul>
    </div>
</div>
<div class="mb-6">
