<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Set New Password - CoffeSpot</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-hearth-50">
    <div class="min-h-screen flex">
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="mb-8">
                    <h1 class="font-serif text-3xl font-bold text-hearth-800 mb-2">Create New Password</h1>
                    <p class="text-hearth-400">Masukkan kata sandi baru untuk akun Anda.</p>
                </div>

                @if($errors->any())
                    <div class="mb-4 text-sm text-red-600">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('password.otp.update') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="password" class="block text-xs font-semibold text-hearth-400 uppercase tracking-wider mb-2">Password</label>
                        <input id="password" type="password" name="password" required class="input-field" placeholder="••••••••">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-hearth-400 uppercase tracking-wider mb-2">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="input-field" placeholder="••••••••">
                    </div>

                    <button type="submit" class="btn-primary w-full text-center">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
