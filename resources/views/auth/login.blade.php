<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - CoffeSpot</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-hearth-50">
    <div class="min-h-screen flex">
        {{-- Left Side - Image --}}
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-hearth-800/90 to-hearth-600/80 z-10"></div>
            <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=1200&q=80" alt="Cafe Interior"
                 class="absolute inset-0 w-full h-full object-cover">
            <div class="relative z-20 flex flex-col justify-between p-12 text-white">
                <div>
                    <a href="{{ route('home') }}" class="font-serif text-3xl font-semibold italic">CoffeSpot</a>
                </div>
                <div class="max-w-md">
                    <h2 class="font-serif text-4xl font-bold leading-tight mb-4">{{ __('Gather round the digital table for a more intentional discovery experience.') }}</h2>
                    <p class="text-hearth-200 mb-6">{{ __('New to CoffeSpot?') }} <a href="{{ route('register') }}" class="text-accent font-semibold underline underline-offset-4 hover:text-white transition-colors">{{ __('Join Community') }}</a></p>
                </div>
                <p class="text-hearth-300 text-sm">&copy; {{ date('Y') }} CoffeSpot. {{ __('Hand-crafted for the digital artisan.') }}</p>
            </div>
        </div>

        {{-- Right Side - Form --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                {{-- Mobile Logo --}}
                <div class="lg:hidden text-center mb-8">
                    <a href="{{ route('home') }}" class="font-serif text-3xl font-semibold text-hearth-800 italic">CoffeSpot</a>
                </div>

                <div class="mb-8">
                    <h1 class="font-serif text-3xl font-bold text-hearth-800 mb-2">{{ __('Welcome Back') }}</h1>
                    <p class="text-hearth-400">{{ __('Continue your journey with the artisans.') }}</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-semibold text-hearth-400 uppercase tracking-wider mb-2">{{ __('Email Address') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                               class="input-field" placeholder="artisan@thehearth.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-xs font-semibold text-hearth-400 uppercase tracking-wider">{{ __('Password') }}</label>
                            @if (Route::has('password.otp.request'))
                                <a href="{{ route('password.otp.request') }}" class="text-xs font-semibold text-hearth-500 hover:text-hearth-800 transition-colors">{{ __('Forgot?') }}</a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               class="input-field" placeholder="••••••••">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember"
                               class="w-4 h-4 bg-hearth-50 border-hearth-200 rounded text-hearth-600 focus:ring-hearth-500">
                        <label for="remember_me" class="ml-2 text-sm text-hearth-400">{{ __('Remember me') }}</label>
                    </div>

                    <button type="submit" class="btn-primary w-full text-center">
                        {{ __('Sign In') }}
                    </button>
                </form>

                <p class="text-center text-sm text-hearth-400 mt-6">
                    {{ __('New to CoffeSpot?') }} <a href="{{ route('register') }}" class="font-semibold text-hearth-600 hover:text-hearth-800 transition-colors">{{ __('Join Community') }}</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
