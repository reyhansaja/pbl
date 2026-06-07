@extends('layouts.app')

@section('title', __('Profile'))

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <div class="mb-8">
        <p class="text-hearth-500 text-sm font-semibold uppercase tracking-wider mb-2">{{ __('Settings') }}</p>
        <h1 class="font-serif text-3xl font-bold text-hearth-800">{{ __('Profile') }}</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Side Navigation --}}
        <div>
            <div class="card p-6 sticky top-24">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 rounded-full overflow-hidden flex items-center justify-center bg-hearth-100 border-2 border-hearth-200">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-hearth-600 text-2xl font-bold font-serif">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div>
                        <h2 class="font-semibold text-hearth-800 text-lg leading-tight">{{ $user->name }}</h2>
                        <p class="text-xs text-hearth-400 mt-1 capitalize">{{ $user->role }} Account</p>
                    </div>
                </div>
                
                <div class="space-y-1">
                    <a href="#profile-info" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium bg-hearth-50 text-hearth-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        {{ __('Profile Information') }}
                    </a>
                    <a href="#update-password" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-hearth-500 hover:bg-hearth-50/50 hover:text-hearth-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        {{ __('Update Password') }}
                    </a>
                    <a href="#delete-account" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-red-500 hover:bg-red-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        {{ __('Delete Account') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- Forms Column --}}
        <div class="lg:col-span-2 space-y-8">
            <div id="profile-info" class="card p-6 sm:p-8 scroll-mt-24">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div id="update-password" class="card p-6 sm:p-8 scroll-mt-24">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div id="delete-account" class="card p-6 sm:p-8 scroll-mt-24 border border-red-100">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
