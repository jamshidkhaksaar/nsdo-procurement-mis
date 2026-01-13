<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | {{ \App\Models\Setting::get('company_name', 'Procurement MIS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        
        .card-inner {
            background: rgba(255, 255, 255, 0.95);
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
        
        .input-field {
            transition: all 0.2s ease;
        }
        .input-field:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
        }
        
        /* Animated text styles */
        .animated-title {
            overflow: hidden;
        }
        .animated-title span {
            display: inline-block;
            opacity: 0;
            transform: translateY(50px);
            animation: slideUp 0.8s ease forwards;
        }
        .animated-title span:nth-child(1) { animation-delay: 0.1s; }
        .animated-title span:nth-child(2) { animation-delay: 0.2s; }
        .animated-title span:nth-child(3) { animation-delay: 0.3s; }
        
        .animated-subtitle {
            opacity: 0;
            transform: translateX(-30px);
            animation: slideIn 1s ease 0.6s forwards;
        }
        
        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .glow-text {
            text-shadow: 0 0 40px rgba(255, 255, 255, 0.3), 0 0 80px rgba(102, 126, 234, 0.2);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-between px-8 lg:px-20" style="background: url('/images/background.png') no-repeat center center fixed; background-size: cover;">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black/30"></div>
    
    <!-- Left Side - Animated Text -->
    <div class="relative z-10 hidden lg:block max-w-xl">
        <h1 class="animated-title text-5xl xl:text-6xl font-extrabold text-white glow-text leading-tight mb-6">
            <span>NSDO</span><br>
            <span>Procurement</span><br>
            <span>MIS</span>
        </h1>
        <p class="animated-subtitle text-xl text-white/80 font-light leading-relaxed">
            Streamlined procurement and asset management<br>for efficient organizational operations.
        </p>
    </div>
    
    <!-- Right Side - Card -->
    <div class="relative z-10 w-full max-w-md ml-auto">
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="card-inner rounded-2xl m-[1px]">
                <!-- Top accent bar -->
                <div class="h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
                
                <div class="p-10">
                    <!-- Logo -->
                    <div class="flex justify-center mb-8">
                        @php
                            $logo = \App\Models\Setting::get('company_logo');
                            $companyName = \App\Models\Setting::get('company_name', 'Procurement MIS');
                        @endphp
                        
                        @if($logo)
                            <img src="{{ Storage::url($logo) }}" alt="{{ $companyName }}" class="h-24 w-auto drop-shadow-lg">
                        @else
                            <span class="text-3xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">{{ $companyName }}</span>
                        @endif
                    </div>

                    <!-- Header -->
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Welcome Back</h2>
                        <p class="text-gray-500">Sign in to access your account</p>
                    </div>

                    <!-- Error Message -->
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-700">{{ $errors->first() }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                                class="input-field block w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:outline-none"
                                placeholder="you@example.com">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <input type="password" name="password" id="password" required
                                class="input-field block w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:outline-none"
                                placeholder="Enter your password">
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center cursor-pointer">
                                <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>
                        </div>

                        <button type="submit" class="btn-gradient w-full flex items-center justify-center py-4 px-4 rounded-xl text-white font-semibold text-base shadow-lg mt-6">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Sign In
                        </button>
                    </form>
                </div>
                
                <!-- Footer -->
                <div class="px-10 py-5 bg-gray-50 border-t border-gray-100 text-center">
                    <p class="text-sm text-gray-400">&copy; {{ date('Y') }} {{ $companyName }}. Authorized Personnel Only.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
