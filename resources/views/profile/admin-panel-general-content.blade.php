<!-- Formularz zmiany nazwy systemu -->
<form action="{{ route('admin.settings.updateName') }}" method="POST" class="mb-4">
    @csrf
    <label class="block text-sm font-medium text-gray-700 mb-2">Nazwa systemu</label>
    <div class="flex gap-2 items-center">
        <input type="text" name="system_name" value="{{ config('app.name') }}" class="border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" required />
        <button type="button" class="px-2 py-1 text-sm rounded bg-blue-600 text-white hover:bg-blue-700 transition" onclick="document.getElementById('refresh-modal').style.display='block'">Zapisz</button>
    </div>
</form>
<!-- Formularz zmiany logo systemu -->
<form action="{{ route('admin.settings.updateLogo') }}" method="POST" enctype="multipart/form-data" class="mb-4">
    @csrf
    <label class="block text-sm font-medium text-gray-700 mb-2">Logo systemu</label>
    <div class="flex gap-4 items-center">
        <div>
            @if($appLogo)
                <img src="{{ asset($appLogo) }}" alt="Logo" style="max-height:48px; max-width:160px; width:auto; height:auto; margin-bottom:0.5rem; border-radius:8px; display:block;" />
            @else
                <span class="text-gray-400 text-xs">Brak logo</span>
            @endif
        </div>
        <input type="file" name="logo" accept="image/*" class="border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400" required />
        <button type="submit" class="px-2 py-1 text-sm rounded bg-blue-600 text-white hover:bg-blue-700 transition whitespace-nowrap">Zmień logo</button>
    </div>
    <p class="text-xs text-gray-500 mt-2">Obsługiwane formaty: PNG, JPG, SVG. Maksymalny rozmiar: 1MB.</p>
</form>
<!-- Modal informacyjny po zmianie nazwy -->
<div id="refresh-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display:none;">
    <div class="bg-white rounded-lg shadow-lg px-4 py-6 w-full max-w-md" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
        <h3 class="text-lg font-semibold mb-4">Zmiana nazwy systemu</h3>
        <p class="mb-4 text-gray-700">Zmiana nazwy systemu powoduje chwilowe rozłączenie z serwerem.<br>Po kliknięciu "Potwierdź" odśwież stronę, aby kontynuować pracę.</p>
        <form action="{{ route('admin.settings.updateName') }}" method="POST">
            @csrf
            <input type="hidden" name="system_name" value="" id="modal-system-name" />
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300 transition" onclick="document.getElementById('refresh-modal').style.display='none'">Anuluj</button>
                <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition" onclick="document.getElementById('refresh-modal').style.display='none'">Potwierdź</button>
            </div>
        </form>
    </div>
</div>
<script>
    // Przekazanie wartości z inputa do modala
    document.addEventListener('DOMContentLoaded', function() {
        var mainInput = document.querySelector('input[name=system_name]');
        var modalInput = document.getElementById('modal-system-name');
        var saveBtn = document.querySelector('button[onclick*="refresh-modal"]');
        if(mainInput && modalInput && saveBtn) {
            saveBtn.addEventListener('click', function() {
                modalInput.value = mainInput.value;
            });
        }
    });
</script>
