<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'cafe_id' => 'required|exists:cafes,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Check if user already reviewed this cafe
        $existing = Review::where('user_id', auth()->id())
            ->where('cafe_id', $request->cafe_id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already reviewed this cafe.');
        }

        Review::create([
            'user_id' => auth()->id(),
            'cafe_id' => $request->cafe_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review posted successfully!');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Review deleted.');
    }
}
