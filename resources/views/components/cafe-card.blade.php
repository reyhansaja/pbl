{{-- Cafe Card Component --}}
@props(['cafe'])

<div class="card group">
    <a href="{{ route('cafe.show', $cafe->slug) }}" class="block">
        {{-- Image --}}
        <div class="relative aspect-[4/3] overflow-hidden">
            @if($cafe->photos->where('is_primary', true)->first())
                <img src="{{ asset('storage/' . $cafe->photos->where('is_primary', true)->first()->photo_path) }}"
                     alt="{{ $cafe->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            @else
                <div class="w-full h-full bg-gradient-to-br from-hearth-200 to-hearth-300 flex items-center justify-center">
                    <svg class="w-12 h-12 text-hearth-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            @endif

            {{-- Status Badge --}}
            @if($cafe->isOpenNow())
                <span class="absolute top-3 left-3 badge-open">● Open Now</span>
            @else
                <span class="absolute top-3 left-3 badge-closed">● Closed</span>
            @endif
        </div>

        {{-- Content --}}
        <div class="p-4">
            <h3 class="font-serif text-lg font-semibold text-hearth-800 mb-1 group-hover:text-hearth-500 transition-colors">
                {{ $cafe->name }}
            </h3>

            @if($cafe->address)
                <p class="text-sm text-hearth-400 mb-3 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="truncate">{{ $cafe->address }}</span>
                </p>
            @endif

            {{-- Rating --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-1">
                    @php $avgRating = round($cafe->reviews_avg_rating ?? 0, 1); @endphp
                    <div class="flex items-center gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'text-star' : 'text-hearth-200' }}"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm font-semibold text-hearth-800 ml-1">{{ $avgRating ?: '-' }}</span>
                </div>
                <span class="text-xs text-hearth-400">{{ $cafe->reviews_count ?? 0 }} reviews</span>
            </div>
        </div>
    </a>
</div>
