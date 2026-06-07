@extends('layouts.app')

@section('title', $cafe->name)
@section('meta_description', Str::limit($cafe->about, 160))

@section('content')
<div x-data="{ activePhoto: 0 }">
    {{-- Photo Gallery --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        @if($cafe->photos->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 rounded-2xl overflow-hidden" style="max-height: 480px;">
                {{-- Main Photo --}}
                <div class="md:col-span-2 relative overflow-hidden" style="min-height: 320px;">
                    @foreach($cafe->photos as $index => $photo)
                        <img x-show="activePhoto === {{ $index }}"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             src="{{ asset('storage/' . $photo->photo_path) }}"
                             alt="{{ $cafe->name }}"
                             class="absolute inset-0 w-full h-full object-cover">
                    @endforeach
                </div>

                {{-- Thumbnails --}}
                <div class="hidden md:grid grid-rows-2 gap-3">
                    @foreach($cafe->photos->take(2) as $index => $photo)
                        <div class="gallery-thumb" :class="{ 'active': activePhoto === {{ $index }} }"
                             @click="activePhoto = {{ $index }}">
                            <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="{{ $cafe->name }}"
                                 class="w-full h-full object-cover" style="min-height: 150px;">
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Photo Navigation (if more than 1) --}}
            @if($cafe->photos->count() > 1)
                <div class="flex items-center justify-center gap-3 mt-4">
                    @foreach($cafe->photos as $index => $photo)
                        <button @click="activePhoto = {{ $index }}"
                                :class="activePhoto === {{ $index }} ? 'bg-hearth-800 w-8' : 'bg-hearth-300 w-2'"
                                class="h-2 rounded-full transition-all duration-300"></button>
                    @endforeach
                </div>
            @endif
        @else
            <div class="bg-gradient-to-br from-hearth-200 to-hearth-300 rounded-2xl flex items-center justify-center" style="height: 400px;">
                <p class="text-hearth-400 text-lg">{{ __('No photos available') }}</p>
            </div>
        @endif
    </section>

    {{-- Cafe Info Header --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="font-serif text-3xl md:text-4xl font-bold text-hearth-800">{{ $cafe->name }}</h1>
                    @if($cafe->isOpenNow())
                        <span class="badge-open">● {{ __('Open') }}</span>
                    @else
                        <span class="badge-closed">● {{ __('Closed') }}</span>
                    @endif
                </div>
                @if($cafe->address)
                    <p class="text-hearth-400 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $cafe->address }}
                    </p>
                @endif
            </div>

            <div class="flex items-center gap-4">
                {{-- Rating Summary --}}
                <div class="text-center">
                    @php $avgRating = round($cafe->reviews_avg_rating ?? 0, 1); @endphp
                    <div class="text-3xl font-bold text-hearth-800">{{ $avgRating ?: '-' }}</div>
                    <div class="flex items-center gap-0.5 my-1">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'text-star' : 'text-hearth-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-xs text-hearth-400">{{ $cafe->reviews_count }} {{ __('reviews') }}</p>
                </div>

                {{-- Favorite Button --}}
                @auth
                    <form method="POST" action="{{ route('favorites.toggle') }}" class="inline">
                        @csrf
                        <input type="hidden" name="cafe_id" value="{{ $cafe->id }}">
                        <button type="submit"
                                class="p-3 rounded-xl border-2 transition-all duration-200 {{ $isFavorited ? 'bg-red-50 border-red-200 text-red-500' : 'border-hearth-200 text-hearth-400 hover:border-hearth-400 hover:text-hearth-600' }}">
                            <svg class="w-6 h-6" fill="{{ $isFavorited ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </section>

    {{-- About & Schedule --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- About & Maps --}}
            <div class="lg:col-span-2">
                <div x-data="{ expanded: false }">
                    <h2 class="font-serif text-2xl font-bold text-hearth-800 mb-4">{{ __('About the Space') }}</h2>
                    @if(Str::words($cafe->about, 60, '') !== $cafe->about)
                        <p class="text-hearth-600 leading-relaxed whitespace-pre-line animate-fade-in" x-show="!expanded">
                            {{ Str::words($cafe->about, 60, '...') }}
                        </p>
                        <p class="text-hearth-600 leading-relaxed whitespace-pre-line animate-fade-in" x-show="expanded" style="display: none;">
                            {{ $cafe->about }}
                        </p>
                        <button @click="expanded = !expanded" class="text-sm font-semibold text-hearth-800 hover:text-hearth-500 mt-2 transition-colors focus:outline-none">
                            <span x-show="!expanded">{{ __('Read More') }} &darr;</span>
                            <span x-show="expanded" style="display: none;">{{ __('Read Less') }} &uarr;</span>
                        </button>
                    @else
                        <p class="text-hearth-600 leading-relaxed whitespace-pre-line">{{ $cafe->about }}</p>
                    @endif
                </div>

                {{-- Maps --}}
                @if(($cafe->latitude && $cafe->longitude) || $cafe->maps_embed)
                    <div class="mt-8">
                        <h3 class="font-serif text-xl font-bold text-hearth-800 mb-4">{{ __('Location') }}</h3>
                        @if($cafe->latitude && $cafe->longitude)
                            <div id="cafe-detail-map" class="rounded-2xl overflow-hidden border border-hearth-200 shadow-sm" style="height: 260px;"></div>
                        @else
                            <div class="rounded-2xl overflow-hidden border border-hearth-200" style="height: 260px;">
                                {!! $cafe->maps_embed !!}
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Schedule --}}
            <div>
                <div class="card p-6">
                    <h3 class="font-semibold text-hearth-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-hearth-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ __('Opening Hours') }}
                    </h3>
                    <div class="space-y-2">
                        @foreach($cafe->schedules->sortBy(function($s) {
                            return array_search($s->day, ['monday','tuesday','wednesday','thursday','friday','saturday','sunday']);
                        }) as $schedule)
                            <div class="flex items-center justify-between py-1.5 {{ strtolower(now()->format('l')) === $schedule->day ? 'bg-hearth-50 -mx-3 px-3 rounded-lg font-semibold' : '' }}">
                                <span class="text-sm capitalize {{ strtolower(now()->format('l')) === $schedule->day ? 'text-hearth-800' : 'text-hearth-400' }}">
                                    {{ ucfirst($schedule->day) }}
                                </span>
                                <span class="text-sm {{ $schedule->is_closed ? 'text-red-500' : (strtolower(now()->format('l')) === $schedule->day ? 'text-hearth-800' : 'text-hearth-600') }}">
                                    {{ $schedule->formatted_time }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Reviews Section --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 border-t border-hearth-100">
        <h2 class="font-serif text-2xl font-bold text-hearth-800 mb-8">{{ __('The Guest Journal') }}</h2>

        {{-- Existing Reviews --}}
        <div class="space-y-6 mb-10">
            @forelse($cafe->reviews as $review)
                <div class="card p-6" id="review-{{ $review->id }}">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-hearth-200 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-hearth-600 text-sm font-bold">{{ strtoupper(substr($review->user->name, 0, 1)) }}</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="font-semibold text-hearth-800">{{ $review->user->name }}</h4>
                                <span class="text-xs text-hearth-400">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex items-center gap-0.5 mb-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-star' : 'text-hearth-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-hearth-600 leading-relaxed">{{ $review->comment }}</p>

                            @if($review->images && count($review->images) > 0)
                                <div class="flex flex-wrap gap-2 mt-3">
                                    @foreach($review->images as $image)
                                        <div x-data="{ open: false }" class="relative flex-shrink-0">
                                            <div class="w-10 h-10 rounded-lg overflow-hidden border border-hearth-200 bg-hearth-50 hover:opacity-90 transition-opacity cursor-pointer shadow-sm">
                                                <img src="{{ asset('storage/' . $image) }}" 
                                                     alt="Review attachment" 
                                                     class="w-full h-full object-cover"
                                                     @click="open = true">
                                            </div>

                                            <div x-show="open" 
                                                 x-transition:enter="transition ease-out duration-300"
                                                 x-transition:enter-start="opacity-0"
                                                 x-transition:enter-end="opacity-100"
                                                 x-transition:leave="transition ease-in duration-200"
                                                 x-transition:leave-start="opacity-100"
                                                 x-transition:leave-end="opacity-0"
                                                 class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80"
                                                 @click.self="open = false"
                                                 @keydown.escape.window="open = false"
                                                 style="display: none;">
                                                <div class="relative max-w-4xl max-h-full">
                                                    <img src="{{ asset('storage/' . $image) }}" 
                                                         alt="Review attachment large" 
                                                         class="max-w-full max-h-[85vh] rounded-xl object-contain shadow-2xl">
                                                    <button type="button" @click="open = false" 
                                                            class="absolute top-4 right-4 text-white bg-black/40 hover:bg-black/60 p-2 rounded-full transition-colors">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Delete button (own review) --}}
                            @auth
                                @if($review->user_id === auth()->id() || auth()->user()->isAdmin())
                                    <form method="POST" action="{{ route('reviews.destroy', $review) }}" class="mt-3" onsubmit="return confirm('{{ __('Delete this review?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-medium">{{ __('Delete review') }}</button>
                                    </form>
                                @endif
                            @endauth

                            {{-- Reply --}}
                            @if($review->reply)
                                <div class="mt-4 bg-hearth-50 rounded-xl p-4 border-l-4 border-hearth-500">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 bg-hearth-500 rounded-full flex items-center justify-center">
                                            <span class="text-white text-xs font-bold">{{ strtoupper(substr($review->reply->user->name, 0, 1)) }}</span>
                                        </div>
                                        <span class="text-sm font-semibold text-hearth-800">{{ $review->reply->user->name }}</span>
                                        <span class="text-xs bg-hearth-200 text-hearth-600 px-2 py-0.5 rounded-full">{{ __('Owner') }}</span>
                                    </div>
                                    <p class="text-sm text-hearth-600">{{ $review->reply->reply }}</p>
                                </div>
                            @endif

                            {{-- Reply form (cafe owner only) --}}
                            @auth
                                @if(auth()->user()->isOwner() && $cafe->user_id === auth()->id() && !$review->reply)
                                    <div x-data="{ showReply: false }" class="mt-4">
                                        <button @click="showReply = !showReply" class="text-sm text-hearth-500 hover:text-hearth-800 font-medium">
                                            {{ __('Reply to this review') }}
                                        </button>
                                        <form x-show="showReply" x-transition method="POST" action="{{ route('owner.reviews.reply', $review) }}" class="mt-3">
                                            @csrf
                                            <textarea name="reply" rows="3" class="input-field text-sm" placeholder="{{ __('Write your reply...') }}" required></textarea>
                                            <div class="flex justify-end gap-2 mt-2">
                                                <button type="button" @click="showReply = false" class="btn-sm text-sm text-hearth-400 hover:text-hearth-600">{{ __('Cancel') }}</button>
                                                <button type="submit" class="btn-primary btn-sm text-sm">{{ __('Post Reply') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10">
                    <p class="text-hearth-400">{{ __('No reviews yet. Be the first to share your experience!') }}</p>
                </div>
            @endforelse
        </div>

        {{-- Write Review Form --}}
        @auth
            @if(auth()->user()->isUser() && !$userReview)
                <div class="card p-6">
                    <h3 class="font-serif text-xl font-semibold text-hearth-800 mb-4">{{ __('Share Your Discovery') }}</h3>
                    <form method="POST" action="{{ route('reviews.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="cafe_id" value="{{ $cafe->id }}">

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-hearth-600 mb-2">{{ __('Your Rating') }}</label>
                            <div class="star-rating" x-data="{ rating: 0 }">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" x-model="rating">
                                    <label for="star{{ $i }}" :class="rating >= {{ $i }} ? 'text-star' : 'text-hearth-200'" class="cursor-pointer text-2xl transition-colors">★</label>
                                @endfor
                            </div>
                            @error('rating')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <textarea name="comment" rows="4" class="input-field" placeholder="{{ __('Tell us about your experience...') }}" required>{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5" x-data="{ 
                            previews: [], 
                            handleFiles(event) {
                                this.previews = [];
                                const files = event.target.files;
                                if (files) {
                                    for (let i = 0; i < Math.min(files.length, 5); i++) {
                                        this.previews.push(URL.createObjectURL(files[i]));
                                    }
                                }
                            }
                        }">
                            <label class="block text-sm font-medium text-hearth-600 mb-2">{{ __('Attach Photos (Optional, max 5)') }}</label>
                            <div class="flex items-center gap-3">
                                <label class="flex items-center gap-2 px-4 py-2 bg-white border-2 border-dashed border-hearth-200 rounded-xl cursor-pointer hover:border-hearth-400 hover:text-hearth-800 transition-colors text-hearth-500 text-sm font-medium">
                                    <svg class="w-5 h-5 text-hearth-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>{{ __('Choose Photos') }}</span>
                                    <input type="file" name="images[]" accept="image/*" multiple class="hidden" @change="handleFiles($event)">
                                </label>
                                <span class="text-xs text-hearth-400" x-text="previews.length > 0 ? previews.length + ' {{ __('files selected') }}' : '{{ __('No files chosen') }}'"></span>
                            </div>

                            <div class="flex flex-wrap gap-2 mt-3" x-show="previews.length > 0" x-transition style="display: none;">
                                <template x-for="(src, index) in previews" :key="index">
                                    <div class="relative w-10 h-10 rounded-lg overflow-hidden border border-hearth-200 bg-hearth-50 shadow-sm flex-shrink-0">
                                        <img :src="src" class="w-full h-full object-cover">
                                    </div>
                                </template>
                            </div>

                            @error('images')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('images.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="btn-primary">
                                {{ __('Post Journal Entry') }} →
                            </button>
                        </div>
                    </form>
                </div>
            @elseif(auth()->user()->isUser() && $userReview)
                <div class="card p-6 text-center">
                    <p class="text-hearth-400">{{ __("You've already reviewed this cafe. Thank you for your feedback! ☕") }}</p>
                </div>
            @endif
        @else
            <div class="card p-6 text-center">
                <p class="text-hearth-400 mb-4">{{ __('Sign in to share your experience.') }}</p>
                <a href="{{ route('login') }}" class="btn-primary btn-sm">{{ __('Sign In') }}</a>
            </div>
        @endauth
    </section>
</div>
@endsection

@if($cafe->latitude && $cafe->longitude)
@push('scripts')
{{-- Include Leaflet CSS and JS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lat = {{ $cafe->latitude }};
        const lng = {{ $cafe->longitude }};
        const name = "{{ $cafe->name }}";
        const address = "{{ $cafe->address }}";

        // Initialize Map
        const map = L.map('cafe-detail-map', {
            zoomControl: false
        }).setView([lat, lng], 15);

        // Add standard OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Move zoom control to bottom right for premium appearance
        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);

        // Create Custom SVG Coffee Pin
        const customCoffeeIcon = L.divIcon({
            className: 'custom-div-icon',
            html: `
                <div class="relative flex items-center justify-center shadow-lg rounded-full overflow-hidden bg-white border border-hearth-200" style="width: 42px; height: 42px;">
                    <svg class="w-[60%] h-[60%]" viewBox="0 0 24 24" fill="none" stroke="#B85C38" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8h1a4 4 0 0 1 0 8h-1"/>
                        <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/>
                        <line x1="6" y1="2" x2="6" y2="4"/>
                        <line x1="10" y1="2" x2="10" y2="4"/>
                        <line x1="14" y1="2" x2="14" y2="4"/>
                    </svg>
                </div>
                <div class="absolute bottom-[-6px] left-[50%] translate-x-[-50%] w-3 h-3 bg-white rotate-45 border-r border-b border-hearth-200 shadow-md z-[-1]"></div>
            `,
            iconSize: [42, 42],
            iconAnchor: [21, 48],
            popupAnchor: [0, -42]
        });

        // Add marker
        const marker = L.marker([lat, lng], {
            icon: customCoffeeIcon
        }).addTo(map);

        // Bind beautiful popup
        marker.bindPopup(`
            <div class="p-2 font-sans text-center">
                <h4 class="font-serif font-bold text-hearth-800 text-sm mb-1">${name}</h4>
                <p class="text-xs text-hearth-500 mb-2">${address}</p>
                <a href="https://www.google.com/maps/search/?api=1&query=${lat},${lng}" target="_blank" class="inline-flex items-center gap-1 text-[10px] font-bold text-hearth-800 hover:text-hearth-500 transition-colors uppercase tracking-wider">
                    Open in Google Maps &rarr;
                </a>
            </div>
        `).openPopup();
    });
</script>

<style>
    /* Styling to blend Leaflet perfectly with Hearth styles */
    .leaflet-container {
        font-family: 'Inter', sans-serif !important;
        background: #FAF6F1 !important;
    }
    
    .leaflet-popup-content-wrapper {
        border-radius: 1rem !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02) !important;
        border: 1px solid #FAF6F1 !important;
        padding: 0.15rem !important;
        background: #FAF6F1 !important;
    }
    
    .leaflet-popup-tip {
        background: #FAF6F1 !important;
        box-shadow: none !important;
    }
    
    .leaflet-bar {
        border: none !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
        border-radius: 0.5rem !important;
        overflow: hidden;
    }
    
    .leaflet-bar a {
        background-color: #ffffff !important;
        color: #2C1810 !important;
        border-bottom: 1px solid #FAF6F1 !important;
    }
</style>
@endpush
@endif
