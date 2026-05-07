@extends('layouts.app')

@section('title', 'My Favorites')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <div class="mb-8">
        <p class="text-hearth-500 text-sm font-semibold uppercase tracking-wider mb-2">Your Collection</p>
        <h1 class="font-serif text-3xl md:text-4xl font-bold text-hearth-800">Favorite Cafes</h1>
    </div>

    @if($favorites->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($favorites as $cafe)
                @include('components.cafe-card', ['cafe' => $cafe])
            @endforeach
        </div>

        <div class="mt-10">
            {{ $favorites->links() }}
        </div>
    @else
        <div class="text-center py-20">
            <svg class="w-16 h-16 text-hearth-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            <h3 class="font-serif text-xl font-semibold text-hearth-800 mb-2">No favorites yet</h3>
            <p class="text-hearth-400 mb-6">Start exploring and save cafes you love.</p>
            <a href="{{ route('discover') }}" class="btn-primary">Discover Cafes</a>
        </div>
    @endif
</section>
@endsection
