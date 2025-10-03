@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Logi audytowe</h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-xl rounded-lg">
    <div class="bg-gray-100 p-4 rounded overflow-auto" style="max-height: 600px; font-family: monospace; font-size: 13px;">
        @php
            $logPath = storage_path('logs/audit.log');
            $lines = file_exists($logPath) ? array_slice(file($logPath), -200) : [];
        @endphp
        @if($lines)
            @foreach($lines as $line)
                <div class="mb-1 text-gray-700">{!! nl2br(e(trim($line))) !!}</div>
            @endforeach
        @else
            <div class="text-gray-500">Brak logów do wyświetlenia.</div>
        @endif
    </div>
    <a href="{{ route('admin.panel') }}" class="mt-6 inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Powrót do panelu admina</a>
</div>
@endsection
