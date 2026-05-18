@extends('layouts.app')

@section('title', 'Discover Cafes')
@section('meta_description', 'Explore and discover the best cafes near you. Filter by rating, popularity, or newest additions.')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    {{-- Header --}}
    <div class="mb-8">
        <p class="text-hearth-500 text-sm font-semibold uppercase tracking-wider mb-2">{{ __('Explore') }}</p>
        <h1 class="font-serif text-3xl md:text-4xl font-bold text-hearth-800">{{ __('Discover Cafes') }}</h1>
    </div>

    {{-- Search & Filter --}}
    <div class="flex flex-col md:flex-row gap-4 mb-8">
        <form action="{{ route('discover') }}" method="GET" class="flex-1 flex gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-hearth-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search cafes by name, location...') }}"
                       class="input-field pl-12">
            </div>
            <select name="sort" onchange="this.form.submit()"
                    class="input-field w-auto min-w-[160px]">
                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>{{ __('Top Rated') }}</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>{{ __('Most Popular') }}</option>
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>{{ __('Newest First') }}</option>
            </select>
            <button type="submit" class="btn-primary btn-sm">{{ __('Search') }}</button>
        </form>
    </div>

    {{-- Results --}}
    @if($cafes->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($cafes as $cafe)
                @include('components.cafe-card', ['cafe' => $cafe])
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $cafes->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-20">
            <svg class="w-16 h-16 text-hearth-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <h3 class="font-serif text-xl font-semibold text-hearth-800 mb-2">{{ __('No cafes found') }}</h3>
            <p class="text-hearth-400">{{ __('Try adjusting your search or filters.') }}</p>
        </div>
    @endif
</section>
@endsection
