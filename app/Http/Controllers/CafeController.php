<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CafeController extends Controller
{
    public function index(Request $request)
    {
        $query = Cafe::where('is_approved', true)
            ->with(['photos', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->withCount(['reviews', 'favorites']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('about', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'rating':
                    $query->orderByDesc('reviews_avg_rating');
                    break;
                case 'popular':
                    $query->orderByDesc('favorites_count');
                    break;
                case 'latest':
                    $query->latest();
                    break;
                case 'nearby':
                    if ($request->filled('latitude') && $request->filled('longitude')) {
                        $lat = (float) $request->latitude;
                        $lng = (float) $request->longitude;

                        $query->selectRaw("(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance", [$lat, $lng, $lat])
                              ->having('distance', '<=', 30)
                              ->orderBy('distance');
                    } else {
                        $query->orderByDesc('reviews_avg_rating');
                    }
                    break;
                default:
                    $query->orderByDesc('reviews_avg_rating');
            }
        } else {
            $query->orderByDesc('reviews_avg_rating');
        }

        $cafes = $query->paginate(12);

        return view('discover', compact('cafes'));
    }

    public function show($slug)
    {
        $cafe = Cafe::where('slug', $slug)
            ->with([
                'photos',
                'schedules',
                'owner',
                'reviews' => function ($query) {
                    $query->with(['user', 'reply.user'])->latest();
                },
            ])
            ->withAvg('reviews', 'rating')
            ->withCount(['reviews', 'favorites'])
            ->firstOrFail();

        if (!$cafe->is_approved) {
            if (!auth()->check() || (!auth()->user()->isAdmin() && auth()->id() !== $cafe->user_id)) {
                abort(404);
            }
        }

        $isFavorited = false;
        $userReview = null;

        if (auth()->check()) {
            $isFavorited = $cafe->favorites()->where('user_id', auth()->id())->exists();
            $userReview = $cafe->reviews()->where('user_id', auth()->id())->first();
        }

        return view('cafe.show', compact('cafe', 'isFavorited', 'userReview'));
    }


}
