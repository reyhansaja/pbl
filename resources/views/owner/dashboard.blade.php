@extends('layouts.app')

@section('title', __('Owner Dashboard'))

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <p class="text-hearth-500 text-sm font-semibold uppercase tracking-wider mb-2">{{ __('Owner Dashboard') }}</p>
            <h1 class="font-serif text-3xl font-bold text-hearth-800">{{ $cafe->name }}</h1>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('cafe.show', $cafe->slug) }}" class="btn-secondary btn-sm">{{ __('View Public Page') }}</a>
            <a href="{{ route('owner.cafe.edit') }}" class="btn-primary btn-sm">{{ __('Edit Cafe') }}</a>
        </div>
    </div>

    @if(!$cafe->is_approved)
        <div class="bg-amber-50 border-l-4 border-amber-500 p-4 mb-8 rounded-r-xl shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-amber-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-semibold text-amber-800">
                        {{ __('Pending Approval') }}
                    </h3>
                    <p class="text-xs text-amber-700 mt-1">
                        {{ __('Your cafe registry is currently pending review by our administrator. It will become visible on the public listings once approved.') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <div class="card p-5 text-center">
            <div class="text-3xl font-bold text-hearth-800">{{ number_format($cafe->reviews_avg_rating ?? 0, 1) }}</div>
            <p class="text-sm text-hearth-400 mt-1">{{ __('Avg Rating') }}</p>
        </div>
        <div class="card p-5 text-center">
            <div class="text-3xl font-bold text-hearth-800">{{ $cafe->reviews_count }}</div>
            <p class="text-sm text-hearth-400 mt-1">{{ __('Reviews') }}</p>
        </div>
        <div class="card p-5 text-center">
            <div class="text-3xl font-bold text-hearth-800">{{ $cafe->favorites_count }}</div>
            <p class="text-sm text-hearth-400 mt-1">{{ __('Favorites') }}</p>
        </div>
        <div class="card p-5 text-center">
            <div class="text-3xl font-bold {{ $cafe->isOpenNow() ? 'text-emerald-600' : 'text-red-500' }}">
                {{ $cafe->isOpenNow() ? __('Open') : __('Closed') }}
            </div>
            <p class="text-sm text-hearth-400 mt-1">{{ __('Status') }}</p>
        </div>
    </div>

    {{-- Recent Reviews --}}
    <div>
        <h2 class="font-serif text-2xl font-bold text-hearth-800 mb-6">{{ __('Recent Reviews') }}</h2>

        @if($recentReviews->count() > 0)
            <div class="space-y-4">
                @foreach($recentReviews as $review)
                    <div class="card p-5">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-hearth-200 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-hearth-600 text-sm font-bold">{{ strtoupper(substr($review->user->name, 0, 1)) }}</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="font-semibold text-hearth-800">{{ $review->user->name }}</h4>
                                    <div class="flex items-center gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-star' : 'text-hearth-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-sm text-hearth-600 mb-3">{{ $review->comment }}</p>

                                @if($review->images && count($review->images) > 0)
                                    <div class="flex flex-wrap gap-2 mb-3">
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

                                @if($review->reply)
                                    <div class="bg-hearth-50 rounded-lg p-3 border-l-4 border-hearth-500">
                                        <p class="text-sm text-hearth-600"><span class="font-semibold">{{ __('Your reply:') }}</span> {{ $review->reply->reply }}</p>
                                    </div>
                                @else
                                    <div x-data="{ showReply: false }">
                                        <button @click="showReply = !showReply" class="text-sm text-hearth-500 hover:text-hearth-800 font-medium">{{ __('Reply') }}</button>
                                        <form x-show="showReply" x-transition method="POST" action="{{ route('owner.reviews.reply', $review) }}" class="mt-2">
                                            @csrf
                                            <textarea name="reply" rows="2" class="input-field text-sm" placeholder="{{ __('Write your reply...') }}" required></textarea>
                                            <div class="flex justify-end gap-2 mt-2">
                                                <button type="button" @click="showReply = false" class="text-sm text-hearth-400">{{ __('Cancel') }}</button>
                                                <button type="submit" class="btn-primary btn-sm text-sm">{{ __('Reply') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card p-8 text-center">
                <p class="text-hearth-400">{{ __('No reviews yet. Share your cafe link to get started!') }}</p>
            </div>
        @endif
    </div>
</section>
@endsection
