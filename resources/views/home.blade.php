@extends('layouts.app')

@section('title', 'The Hearth')
@section('meta_description', 'Discover the finest cafes, handcrafted for the digital artisan. Your journey starts here.')

@section('content')
{{-- Hero Section --}}
<section class="relative overflow-hidden bg-hearth-800 text-white">
    <div class="absolute inset-0 opacity-30">
        <img src="https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=1600&q=80" alt="Cafe Background"
             class="w-full h-full object-cover">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-36">
        <div class="max-w-2xl">
            <p class="text-accent text-sm font-semibold uppercase tracking-widest mb-4 fade-in">{{ __('Welcome to The Hearth') }}</p>
            <h1 class="font-serif text-4xl md:text-6xl font-bold leading-tight mb-6 fade-in">
                {!! __('Discover Cafes, <br> <span class="text-accent">Handcrafted</span> for You') !!}
            </h1>
            <p class="text-hearth-200 text-lg leading-relaxed mb-8 max-w-lg fade-in">
                {{ __('Gather round the digital table for a more intentional discovery experience. Every corner has a story.') }}
            </p>
            <div class="flex flex-wrap gap-4 fade-in">
                <a href="{{ route('discover') }}" class="btn-primary bg-accent text-hearth-800 hover:bg-yellow-400 font-semibold px-8">
                    {{ __('Explore Cafes') }}
                </a>
                @guest
                    <a href="{{ route('register') }}" class="btn-secondary border-white text-white hover:bg-white hover:text-hearth-800">
                        {{ __('Join Community') }}
                    </a>
                @endguest
            </div>
        </div>
    </div>
</section>

{{-- Popular Cafes --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
    <div class="flex items-end justify-between mb-10">
        <div>
            <p class="text-hearth-500 text-sm font-semibold uppercase tracking-wider mb-2">{{ __('Curated Selection') }}</p>
            <h2 class="font-serif text-3xl md:text-4xl font-bold text-hearth-800">{{ __('Popular Cafes') }}</h2>
        </div>
        <a href="{{ route('discover') }}" class="hidden sm:inline-flex items-center text-hearth-500 hover:text-hearth-800 font-semibold text-sm transition-colors gap-1">
            {{ __('View All') }}
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($popularCafes as $cafe)
            @include('components.cafe-card', ['cafe' => $cafe])
        @endforeach
    </div>

    <div class="text-center mt-8 sm:hidden">
        <a href="{{ route('discover') }}" class="btn-secondary">{{ __('View All Cafes') }}</a>
    </div>
</section>

{{-- Latest Additions --}}
@if($latestCafes->count() > 0)
<section class="bg-hearth-100/50 py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-hearth-500 text-sm font-semibold uppercase tracking-wider mb-2">{{ __('Fresh Discoveries') }}</p>
            <h2 class="font-serif text-3xl md:text-4xl font-bold text-hearth-800">{{ __('Recently Added') }}</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($latestCafes as $cafe)
                @include('components.cafe-card', ['cafe' => $cafe])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA Section --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
    <div class="bg-hearth-800 rounded-3xl overflow-hidden relative">
        <div class="absolute inset-0 opacity-20">
            <img src="https://images.unsplash.com/photo-1442512595331-e89e73853f31?w=1200&q=80" alt="Coffee Beans" class="w-full h-full object-cover">
        </div>
        <div class="relative px-8 py-16 md:px-16 md:py-20 text-center">
            <h2 class="font-serif text-3xl md:text-4xl font-bold text-white mb-4">{{ __('Own a Cafe?') }}</h2>
            <p class="text-hearth-200 text-lg mb-8 max-w-lg mx-auto">
                {{ __('Join The Hearth community and showcase your cafe to thousands of coffee enthusiasts.') }}
            </p>
            <a href="{{ route('register') }}" class="btn-primary bg-accent text-hearth-800 hover:bg-yellow-400 font-semibold px-8">
                {{ __('Register Your Cafe') }}
            </a>
        </div>
    </div>
</section>
@endsection
