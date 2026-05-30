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
        <form id="discover-filter-form" action="{{ route('discover') }}" method="GET" class="flex-1 flex gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-hearth-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search cafes by name, location...') }}"
                       class="input-field pl-12">
            </div>

            {{-- Hidden location coordinates fields --}}
            <input type="hidden" name="latitude" id="lat-input" value="{{ request('latitude') }}">
            <input type="hidden" name="longitude" id="lng-input" value="{{ request('longitude') }}">

            <select name="sort" id="sort-select"
                    class="input-field w-auto min-w-[160px]">
                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>{{ __('Top Rated') }}</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>{{ __('Most Popular') }}</option>
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>{{ __('Newest First') }}</option>
                <option value="nearby" {{ request('sort') == 'nearby' ? 'selected' : '' }}>{{ __('Nearest') }}</option>
            </select>
            <button type="submit" id="btn-submit-search" class="btn-primary btn-sm">{{ __('Search') }}</button>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sortSelect = document.getElementById('sort-select');
        const filterForm = document.getElementById('discover-filter-form');
        const latInput = document.getElementById('lat-input');
        const lngInput = document.getElementById('lng-input');
        const submitBtn = document.getElementById('btn-submit-search');

        let previousValue = sortSelect.value;

        const handleSortChange = () => {
            if (sortSelect.value === 'nearby') {
                // If we already have coordinate values cached in the fields, just submit directly
                if (latInput.value && lngInput.value) {
                    filterForm.submit();
                    return;
                }

                // Show Locator Loading State
                sortSelect.disabled = true;
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>${"{{ __('Locating...') }}"}</span>
                    `;
                }

                // Geolocation Request GPS
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            latInput.value = position.coords.latitude;
                            lngInput.value = position.coords.longitude;
                            
                            // Re-enable and submit
                            sortSelect.disabled = false;
                            filterForm.submit();
                        },
                        (error) => {
                            console.warn("Geolocation error:", error);
                            alert("{{ __('Please allow location access to sort by nearest cafes.') }}");
                            
                            // Revert Sort Selection
                            sortSelect.value = previousValue;
                            sortSelect.disabled = false;
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.innerText = "{{ __('Search') }}";
                            }
                        },
                        { enableHighAccuracy: true, timeout: 6000 }
                    );
                } else {
                    alert("{{ __('Your browser does not support geolocation.') }}");
                    sortSelect.value = previousValue;
                    sortSelect.disabled = false;
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerText = "{{ __('Search') }}";
                    }
                }
            } else {
                // If switching to something else, clear coordinates and submit
                latInput.value = '';
                lngInput.value = '';
                filterForm.submit();
            }
        };

        // Submit listener to catch forms submitted with 'nearby' but no coordinates
        filterForm.addEventListener('submit', function (e) {
            if (sortSelect.value === 'nearby' && (!latInput.value || !lngInput.value)) {
                e.preventDefault();
                handleSortChange();
            }
        });

        // Trigger on sort select change
        sortSelect.addEventListener('change', function () {
            handleSortChange();
            previousValue = sortSelect.value;
        });
    });
</script>
@endpush
