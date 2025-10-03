{{-- System --}}
<div class="bg-white shadow-xl sm:rounded-lg p-6 mb-8">
    @include('profile.admin-panel-system-content')
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
