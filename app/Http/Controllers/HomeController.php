<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $popularCafes = Cafe::with(['photos', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->orderByDesc('reviews_avg_rating')
            ->take(8)
            ->get();

        $latestCafes = Cafe::with(['photos', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest()
            ->take(4)
            ->get();

        return view('home', compact('popularCafes', 'latestCafes'));
    }
}
