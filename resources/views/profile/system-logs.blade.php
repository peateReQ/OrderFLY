

@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Logi systemowe</h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-xl rounded-lg">
    <div class="bg-gray-100 p-4 rounded overflow-auto" style="max-height: 600px; font-family: monospace; font-size: 13px;">
        @if($logLines)
            @foreach($logLines as $line)
                @php
                    $trimmed = trim($line);
                    $level = 'default';
                    if(strpos($trimmed, 'local.ERROR') !== false) $level = 'error';
                    elseif(strpos($trimmed, 'local.WARNING') !== false) $level = 'warning';
                    elseif(strpos($trimmed, 'local.INFO') !== false) $level = 'info';
                @endphp
                <div class="mb-1 @if($level=='error') text-red-600 font-bold @elseif($level=='warning') text-yellow-700 font-semibold @elseif($level=='info') text-blue-700 @else text-gray-700 @endif">
                    {!! nl2br(e($trimmed)) !!}
                </div>
            @endforeach
        @else
            <div class="text-gray-500">Brak logów do wyświetlenia.</div>
        @endif
    </div>
    <a href="{{ route('admin.panel') }}" class="mt-6 inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Powrót do panelu admina</a>
</div>
@endsection
