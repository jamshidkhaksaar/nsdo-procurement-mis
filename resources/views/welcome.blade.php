<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ \App\Models\Setting::get('company_name', 'Procurement MIS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center p-4" style="background: url('/images/background.png') no-repeat center center fixed; background-size: cover;">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black/40 backdrop-blur-[2px]"></div>
    
    <!-- Card -->
    <div class="relative z-10 w-full max-w-md">
        <div class="glass-card rounded-2xl shadow-2xl overflow-hidden border border-white/20">
            <!-- Top accent bar -->
            <div class="h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
            
            <div class="p-10 text-center">
                <!-- Logo -->
                <div class="mb-8 flex justify-center">
                    @php
                        $logo = \App\Models\Setting::get('company_logo');
                        $companyName = \App\Models\Setting::get('company_name', 'Procurement MIS');
                    @endphp
                    
                    @if($logo)
                        <img src="{{ Storage::url($logo) }}" alt="{{ $companyName }}" class="h-28 w-auto object-contain drop-shadow-lg">
                    @else
                        <h1 class="text-4xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">{{ $companyName }}</h1>
                    @endif
                </div>

                <!-- Welcome Text -->
                <h2 class="text-3xl font-bold text-gray-800 mb-3">Welcome</h2>
                <p class="text-gray-500 mb-10 text-base leading-relaxed">Access the Management Information System<br>to manage your procurement operations.</p>

                <!-- CTA Button -->
                <a href="{{ route('dashboard') }}" class="btn-gradient inline-flex items-center justify-center text-white font-semibold py-4 px-10 rounded-xl text-lg shadow-lg">
                    <span>Enter Dashboard</span>
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
            
            <!-- Footer -->
            <div class="px-10 py-5 bg-gray-50/80 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-400">&copy; {{ date('Y') }} {{ $companyName }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
