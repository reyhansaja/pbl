@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <div class="mb-8">
        <p class="text-hearth-500 text-sm font-semibold uppercase tracking-wider mb-2">{{ __('Administration') }}</p>
        <h1 class="font-serif text-3xl font-bold text-hearth-800">{{ __('Dashboard') }}</h1>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <div class="card p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-hearth-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-hearth-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-hearth-800">{{ $stats['total_cafes'] }}</div>
                    <p class="text-xs text-hearth-400">{{ __('Total Cafes') }}</p>
                </div>
            </div>
        </div>
        <div class="card p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-hearth-800">{{ $stats['total_users'] }}</div>
                    <p class="text-xs text-hearth-400">{{ __('Users') }}</p>
                </div>
            </div>
        </div>
        <div class="card p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-hearth-800">{{ $stats['total_owners'] }}</div>
                    <p class="text-xs text-hearth-400">{{ __('Owners') }}</p>
                </div>
            </div>
        </div>
        <div class="card p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-hearth-800">{{ $stats['total_reviews'] }}</div>
                    <p class="text-xs text-hearth-400">{{ __('Reviews') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Recent Cafes --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-serif text-xl font-semibold text-hearth-800">{{ __('Recent Cafes') }}</h2>
                <a href="{{ route('admin.cafes') }}" class="text-sm text-hearth-500 hover:text-hearth-800 font-medium">{{ __('View All →') }}</a>
            </div>
            <div class="space-y-3">
                @foreach($recentCafes as $cafe)
                    <div class="card p-4 flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="font-semibold text-hearth-800">{{ $cafe->name }}</h3>
                                @if(!$cafe->is_approved)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-amber-100 text-amber-800">
                                        {{ __('Pending') }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-hearth-400">by {{ $cafe->owner->name }} · {{ number_format($cafe->reviews_avg_rating ?? 0, 1) }}★ · {{ $cafe->reviews_count }} {{ __('reviews') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            @if(!$cafe->is_approved)
                                <form method="POST" action="{{ route('admin.cafes.approve', $cafe) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs text-emerald-600 hover:text-emerald-800 font-semibold">{{ __('Approve') }}</button>
                                </form>
                            @endif
                            <a href="{{ route('cafe.show', $cafe->slug) }}" class="text-sm text-hearth-500 hover:text-hearth-800">{{ __('View') }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Recent Users --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-serif text-xl font-semibold text-hearth-800">{{ __('Recent Users') }}</h2>
                <a href="{{ route('admin.users') }}" class="text-sm text-hearth-500 hover:text-hearth-800 font-medium">{{ __('View All →') }}</a>
            </div>
            <div class="space-y-3">
                @foreach($recentUsers as $user)
                    <div class="card p-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-hearth-200 rounded-full flex items-center justify-center">
                                <span class="text-hearth-600 text-xs font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-hearth-800 text-sm">{{ $user->name }}</h3>
                                <p class="text-xs text-hearth-400">{{ $user->email }}</p>
                            </div>
                        </div>
                        <span class="badge {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : ($user->role === 'owner' ? 'bg-blue-100 text-blue-800' : 'bg-hearth-100 text-hearth-600') }}">
                            {{ __(ucfirst($user->role)) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
