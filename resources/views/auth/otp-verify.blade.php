<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Verify OTP') }} - CoffeSpot</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-hearth-50">
    <div class="min-h-screen flex">
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="mb-8">
                    <h1 class="font-serif text-3xl font-bold text-hearth-800 mb-2">{{ __('Enter OTP') }}</h1>
                    <p class="text-hearth-400">Masukkan kode OTP yang dikirim ke email Anda.</p>
                </div>

                @if($errors->any())
                    <div class="mb-4 text-sm text-red-600">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('password.otp.check') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="block text-xs font-semibold text-hearth-400 uppercase tracking-wider mb-2">{{ __('Email Address') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email', session('password_reset_email')) }}" required autofocus autocomplete="email"
                               class="input-field">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="otp" class="block text-xs font-semibold text-hearth-400 uppercase tracking-wider mb-2">{{ __('OTP') }}</label>
                        <input id="otp" type="text" name="otp" value="" required class="input-field" placeholder="123456">
                        @error('otp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn-primary w-full text-center">{{ __('Verify OTP') }}</button>
                </form>

                <p class="text-center text-sm text-hearth-400 mt-6">
                    <a href="{{ route('password.otp.request') }}" class="font-semibold text-hearth-600 hover:text-hearth-800">{{ __('Resend OTP') }}</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
