<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password - CoffeSpot</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-hearth-50">
    <div class="min-h-screen flex">
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="lg:hidden text-center mb-8">
                    <a href="{{ route('home') }}" class="font-serif text-3xl font-semibold text-hearth-800 italic">CoffeSpot</a>
                </div>

                <div class="mb-8">
                    <h1 class="font-serif text-3xl font-bold text-hearth-800 mb-2">Reset Password</h1>
                    <p class="text-hearth-400">Masukkan alamat email Anda, kami akan mengirim kode OTP.</p>
                </div>

                @if(session('status'))
                    <p class="mb-4 text-sm text-green-600">{{ session('status') }}</p>
                @endif

                <form method="POST" action="{{ route('password.otp.send') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="block text-xs font-semibold text-hearth-400 uppercase tracking-wider mb-2">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                               class="input-field" placeholder="artisan@thehearth.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn-primary w-full text-center">Send OTP</button>
                </form>

                <p class="text-center text-sm text-hearth-400 mt-6">
                    <a href="{{ route('login') }}" class="font-semibold text-hearth-600 hover:text-hearth-800">Back to Sign In</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
