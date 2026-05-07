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
                <p class="text-hearth-400 text-lg">No photos available</p>
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
                        <span class="badge-open">● Open</span>
                    @else
                        <span class="badge-closed">● Closed</span>
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
                    <p class="text-xs text-hearth-400">{{ $cafe->reviews_count }} reviews</p>
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
            {{-- About --}}
            <div class="lg:col-span-2">
                <h2 class="font-serif text-2xl font-bold text-hearth-800 mb-4">About the Space</h2>
                <p class="text-hearth-600 leading-relaxed whitespace-pre-line">{{ $cafe->about }}</p>
            </div>

            {{-- Schedule --}}
            <div>
                <div class="card p-6">
                    <h3 class="font-semibold text-hearth-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-hearth-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Opening Hours
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

    {{-- Maps --}}
    @if($cafe->maps_embed)
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
        <h2 class="font-serif text-2xl font-bold text-hearth-800 mb-4">Location</h2>
        <div class="rounded-2xl overflow-hidden border border-hearth-200" style="height: 350px;">
            {!! $cafe->maps_embed !!}
        </div>
    </section>
    @endif

    {{-- Reviews Section --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 border-t border-hearth-100">
        <h2 class="font-serif text-2xl font-bold text-hearth-800 mb-8">The Guest Journal</h2>

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

                            {{-- Delete button (own review) --}}
                            @auth
                                @if($review->user_id === auth()->id())
                                    <form method="POST" action="{{ route('reviews.destroy', $review) }}" class="mt-3" onsubmit="return confirm('Delete this review?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-medium">Delete review</button>
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
                                        <span class="text-xs bg-hearth-200 text-hearth-600 px-2 py-0.5 rounded-full">Owner</span>
                                    </div>
                                    <p class="text-sm text-hearth-600">{{ $review->reply->reply }}</p>
                                </div>
                            @endif

                            {{-- Reply form (cafe owner only) --}}
                            @auth
                                @if(auth()->user()->isOwner() && $cafe->user_id === auth()->id() && !$review->reply)
                                    <div x-data="{ showReply: false }" class="mt-4">
                                        <button @click="showReply = !showReply" class="text-sm text-hearth-500 hover:text-hearth-800 font-medium">
                                            Reply to this review
                                        </button>
                                        <form x-show="showReply" x-transition method="POST" action="{{ route('owner.reviews.reply', $review) }}" class="mt-3">
                                            @csrf
                                            <textarea name="reply" rows="3" class="input-field text-sm" placeholder="Write your reply..." required></textarea>
                                            <div class="flex justify-end gap-2 mt-2">
                                                <button type="button" @click="showReply = false" class="btn-sm text-sm text-hearth-400 hover:text-hearth-600">Cancel</button>
                                                <button type="submit" class="btn-primary btn-sm text-sm">Post Reply</button>
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
                    <p class="text-hearth-400">No reviews yet. Be the first to share your experience!</p>
                </div>
            @endforelse
        </div>

        {{-- Write Review Form --}}
        @auth
            @if(auth()->user()->isUser() && !$userReview)
                <div class="card p-6">
                    <h3 class="font-serif text-xl font-semibold text-hearth-800 mb-4">Share Your Discovery</h3>
                    <form method="POST" action="{{ route('reviews.store') }}">
                        @csrf
                        <input type="hidden" name="cafe_id" value="{{ $cafe->id }}">

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-hearth-600 mb-2">Your Rating</label>
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
                            <textarea name="comment" rows="4" class="input-field" placeholder="Tell us about your experience..." required>{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="btn-primary">
                                Post Journal Entry →
                            </button>
                        </div>
                    </form>
                </div>
            @elseif(auth()->user()->isUser() && $userReview)
                <div class="card p-6 text-center">
                    <p class="text-hearth-400">You've already reviewed this cafe. Thank you for your feedback! ☕</p>
                </div>
            @endif
        @else
            <div class="card p-6 text-center">
                <p class="text-hearth-400 mb-4">Sign in to share your experience.</p>
                <a href="{{ route('login') }}" class="btn-primary btn-sm">Sign In</a>
            </div>
        @endauth
    </section>
</div>
@endsection
