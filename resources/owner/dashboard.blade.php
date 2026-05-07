@extends('layouts.app')

@section('title', 'Owner Dashboard')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <p class="text-hearth-500 text-sm font-semibold uppercase tracking-wider mb-2">Owner Dashboard</p>
            <h1 class="font-serif text-3xl font-bold text-hearth-800">{{ $cafe->name }}</h1>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('cafe.show', $cafe->slug) }}" class="btn-secondary btn-sm">View Public Page</a>
            <a href="{{ route('owner.cafe.edit') }}" class="btn-primary btn-sm">Edit Cafe</a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <div class="card p-5 text-center">
            <div class="text-3xl font-bold text-hearth-800">{{ number_format($cafe->reviews_avg_rating ?? 0, 1) }}</div>
            <p class="text-sm text-hearth-400 mt-1">Avg Rating</p>
        </div>
        <div class="card p-5 text-center">
            <div class="text-3xl font-bold text-hearth-800">{{ $cafe->reviews_count }}</div>
            <p class="text-sm text-hearth-400 mt-1">Reviews</p>
        </div>
        <div class="card p-5 text-center">
            <div class="text-3xl font-bold text-hearth-800">{{ $cafe->favorites_count }}</div>
            <p class="text-sm text-hearth-400 mt-1">Favorites</p>
        </div>
        <div class="card p-5 text-center">
            <div class="text-3xl font-bold {{ $cafe->isOpenNow() ? 'text-emerald-600' : 'text-red-500' }}">
                {{ $cafe->isOpenNow() ? 'Open' : 'Closed' }}
            </div>
            <p class="text-sm text-hearth-400 mt-1">Status</p>
        </div>
    </div>

    {{-- Recent Reviews --}}
    <div>
        <h2 class="font-serif text-2xl font-bold text-hearth-800 mb-6">Recent Reviews</h2>

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

                                @if($review->reply)
                                    <div class="bg-hearth-50 rounded-lg p-3 border-l-4 border-hearth-500">
                                        <p class="text-sm text-hearth-600"><span class="font-semibold">Your reply:</span> {{ $review->reply->reply }}</p>
                                    </div>
                                @else
                                    <div x-data="{ showReply: false }">
                                        <button @click="showReply = !showReply" class="text-sm text-hearth-500 hover:text-hearth-800 font-medium">Reply</button>
                                        <form x-show="showReply" x-transition method="POST" action="{{ route('owner.reviews.reply', $review) }}" class="mt-2">
                                            @csrf
                                            <textarea name="reply" rows="2" class="input-field text-sm" placeholder="Write your reply..." required></textarea>
                                            <div class="flex justify-end gap-2 mt-2">
                                                <button type="button" @click="showReply = false" class="text-sm text-hearth-400">Cancel</button>
                                                <button type="submit" class="btn-primary btn-sm text-sm">Reply</button>
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
                <p class="text-hearth-400">No reviews yet. Share your cafe link to get started!</p>
            </div>
        @endif
    </div>
</section>
@endsection
