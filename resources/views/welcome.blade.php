<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ \App\Models\Setting::get('company_name', 'Procurement MIS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-8 text-center">
        <div class="mb-6 flex justify-center">
            @php
                $logo = \App\Models\Setting::get('company_logo');
                $companyName = \App\Models\Setting::get('company_name', 'Procurement MIS');
            @endphp
            
            @if($logo)
                <img src="{{ Storage::url($logo) }}" alt="{{ $companyName }}" class="h-24 w-auto object-contain">
            @else
                <h1 class="text-4xl font-bold text-indigo-600">{{ $companyName }}</h1>
            @endif
        </div>

        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Welcome</h2>
        <p class="text-gray-600 mb-8">Please access the Management Information System below.</p>

        <a href="{{ route('dashboard') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
            Enter Dashboard
        </a>
        
        <div class="mt-6 text-sm text-gray-400">
            &copy; {{ date('Y') }} {{ $companyName }}. All rights reserved.
        </div>
    </div>
</body>
</html>