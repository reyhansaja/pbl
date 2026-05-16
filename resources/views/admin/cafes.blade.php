@extends('layouts.app')

@section('title', 'Manage Cafes')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-hearth-500 hover:text-hearth-800 text-sm font-medium inline-flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Dashboard
            </a>
            <h1 class="font-serif text-3xl font-bold text-hearth-800">Manage Cafes</h1>
        </div>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-hearth-50 border-b border-hearth-100">
                    <tr>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-hearth-400 uppercase tracking-wider">Cafe</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-hearth-400 uppercase tracking-wider">Owner</th>
                        <th class="text-center py-3 px-4 text-xs font-semibold text-hearth-400 uppercase tracking-wider">Rating</th>
                        <th class="text-center py-3 px-4 text-xs font-semibold text-hearth-400 uppercase tracking-wider">Reviews</th>
                        <th class="text-center py-3 px-4 text-xs font-semibold text-hearth-400 uppercase tracking-wider">Favorites</th>
                        <th class="text-right py-3 px-4 text-xs font-semibold text-hearth-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-hearth-100">
                    @foreach($cafes as $cafe)
                        <tr class="hover:bg-hearth-50/50 transition-colors">
                            <td class="py-3 px-4">
                                <div class="font-semibold text-hearth-800">{{ $cafe->name }}</div>
                                <div class="text-xs text-hearth-400">{{ Str::limit($cafe->address, 40) }}</div>
                            </td>
                            <td class="py-3 px-4 text-sm text-hearth-600">{{ $cafe->owner->name }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="text-sm font-semibold text-hearth-800">{{ number_format($cafe->reviews_avg_rating ?? 0, 1) }}</span>
                            </td>
                            <td class="py-3 px-4 text-center text-sm text-hearth-600">{{ $cafe->reviews_count }}</td>
                            <td class="py-3 px-4 text-center text-sm text-hearth-600">{{ $cafe->favorites_count }}</td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('cafe.show', $cafe->slug) }}" class="text-sm text-hearth-500 hover:text-hearth-800 font-medium">View</a>
                                    <form method="POST" action="{{ route('admin.cafes.delete', $cafe) }}" onsubmit="return confirm('Delete this cafe?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $cafes->links() }}
    </div>
</section>
@endsection
