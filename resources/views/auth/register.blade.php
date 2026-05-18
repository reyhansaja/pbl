<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - The Hearth</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-hearth-50" x-data="{ role: 'user' }">
    <div class="min-h-screen flex">
        {{-- Left Side - Image --}}
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-hearth-800/80 to-hearth-600/70 z-10"></div>
            <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1200&q=80" alt="Coffee Cup"
                 class="absolute inset-0 w-full h-full object-cover">
            <div class="relative z-20 flex flex-col justify-between p-12 text-white">
                <div class="flex items-center justify-between">
                    <a href="{{ route('home') }}" class="font-serif text-3xl font-semibold italic">The Hearth</a>
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-hearth-200 hover:text-white border border-hearth-400 px-4 py-2 rounded-lg transition-colors">{{ __('Sign In') }}</a>
                </div>
                <div class="max-w-md">
                    <p class="text-accent text-sm font-semibold uppercase tracking-wider mb-3">{{ __('Welcome Artisan') }}</p>
                    <h2 class="font-serif text-4xl font-bold leading-tight mb-4">"Pull up a chair. Stay as long as you like."</h2>
                    <p class="text-hearth-200 leading-relaxed">{{ __('Join our digital corner of the world where discovery is personal and every corner has a story.') }}</p>
                </div>
                <p class="text-hearth-300 text-sm">&copy; {{ date('Y') }} The Hearth. {{ __('Hand-crafted for the digital artisan.') }}</p>
            </div>
        </div>

        {{-- Right Side - Form --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                {{-- Mobile Header --}}
                <div class="lg:hidden flex items-center justify-between mb-8">
                    <a href="{{ route('home') }}" class="font-serif text-2xl font-semibold text-hearth-800 italic">The Hearth</a>
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-hearth-600 hover:text-hearth-800">{{ __('Sign In') }}</a>
                </div>

                <div class="mb-8">
                    <p class="text-xs font-semibold text-hearth-500 uppercase tracking-wider mb-2">{{ __('Welcome Artisan') }}</p>
                    <h1 class="font-serif text-3xl font-bold text-hearth-800">{{ __('Create Your Account') }}</h1>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-xs font-semibold text-hearth-400 uppercase tracking-wider mb-2">{{ __('Full Name') }}</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                               class="input-field" placeholder="Willy Carter">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-semibold text-hearth-400 uppercase tracking-wider mb-2">{{ __('Email Address') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                               class="input-field" placeholder="willy@thehearth.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Role Toggle --}}
                    <div>
                        <label class="block text-xs font-semibold text-hearth-400 uppercase tracking-wider mb-3">{{ __('Who are you?') }}</label>
                        <div class="flex gap-2">
                            <button type="button" @click="role = 'user'"
                                    :class="role === 'user' ? 'bg-hearth-500 text-white border-hearth-500' : 'bg-white text-hearth-600 border-hearth-200 hover:border-hearth-400'"
                                    class="flex-1 py-2.5 px-4 rounded-lg border-2 text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                {{ __('Guest') }}
                            </button>
                            <button type="button" @click="role = 'owner'"
                                    :class="role === 'owner' ? 'bg-hearth-500 text-white border-hearth-500' : 'bg-white text-hearth-600 border-hearth-200 hover:border-hearth-400'"
                                    class="flex-1 py-2.5 px-4 rounded-lg border-2 text-sm font-semibold transition-all duration-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                {{ __('Cafe Owner') }}
                            </button>
                        </div>
                        <input type="hidden" name="role" :value="role">
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-semibold text-hearth-400 uppercase tracking-wider mb-2">{{ __('Secure Password') }}</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                               class="input-field" placeholder="••••••••">
                        <p class="mt-1 text-xs text-hearth-300">{{ __('Minimum 8 characters with the special strings.') }}</p>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-hearth-400 uppercase tracking-wider mb-2">{{ __('Confirm Password') }}</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                               class="input-field" placeholder="••••••••">
                    </div>

                    <button type="submit" class="btn-primary w-full text-center">
                        {{ __('Join The Hearth') }} →
                    </button>
                </form>

                <p class="text-center text-sm text-hearth-400 mt-6">
                    {{ __('Already have an account?') }} <a href="{{ route('login') }}" class="font-semibold text-hearth-600 hover:text-hearth-800 transition-colors">{{ __('Sign In') }}</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
