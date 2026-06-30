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
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Check if user already reviewed this cafe
        $existing = Review::where('user_id', auth()->id())
            ->where('cafe_id', $request->cafe_id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already reviewed this cafe.');
        }

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('review-photos', 'public');
            }
        }

        Review::create([
            'user_id' => auth()->id(),
            'cafe_id' => $request->cafe_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'images' => $imagePaths,
        ]);

        return back()->with('success', 'Review posted successfully!');
    }

    public function report(Review $review)
    {
        if ($review->user_id === auth()->id()) {
            abort(403, 'You cannot report your own review.');
        }

        $review->increment('report_count', 1, [
            'is_reported' => true,
            'reported_at' => now(),
        ]);

        return back()->with('success', 'Review reported successfully.');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($review->images && is_array($review->images)) {
            foreach ($review->images as $path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
            }
        }

        $review->delete();

        return back()->with('success', 'Review deleted.');
    }
}
