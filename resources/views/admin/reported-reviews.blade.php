@extends('layouts.app')

@section('title', 'Reported Reviews')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-hearth-500 text-sm font-semibold uppercase tracking-wider mb-2">{{ __('Administration') }}</p>
            <h1 class="font-serif text-3xl font-bold text-hearth-800">{{ __('Reported Reviews') }}</h1>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-sm bg-hearth-100 text-hearth-800 hover:bg-hearth-200">{{ __('Back to dashboard') }}</a>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm text-hearth-600">
                <thead class="bg-hearth-50 text-hearth-500 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">{{ __('Review') }}</th>
                        <th class="px-4 py-3">{{ __('Cafe') }}</th>
                        <th class="px-4 py-3">{{ __('User') }}</th>
                        <th class="px-4 py-3">{{ __('Reports') }}</th>
                        <th class="px-4 py-3">{{ __('Last Reported') }}</th>
                        <th class="px-4 py-3 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-hearth-100">
                    @forelse($reviews as $review)
                        <tr>
                            <td class="px-4 py-4 w-2/5">
                                <p class="font-medium text-hearth-800">{{ \Illuminate\Support\Str::limit($review->comment, 90) }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <a href="{{ route('cafe.show', $review->cafe->slug) }}" class="text-hearth-600 hover:text-hearth-800">{{ $review->cafe->name }}</a>
                            </td>
                            <td class="px-4 py-4">{{ $review->user->name }}</td>
                            <td class="px-4 py-4">{{ $review->report_count }}</td>
                            <td class="px-4 py-4">{{ $review->reported_at ? $review->reported_at->diffForHumans() : '-' }}</td>
                            <td class="px-4 py-4 text-right">
                                <form method="POST" action="{{ route('reviews.destroy', $review) }}" onsubmit="return confirm('{{ __('Delete this reported review?') }}')" class="inline-flex">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-semibold">{{ __('Delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-hearth-400">{{ __('No reported reviews found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-4 bg-hearth-50">
            {{ $reviews->links() }}
        </div>
    </div>
</section>
@endsection
