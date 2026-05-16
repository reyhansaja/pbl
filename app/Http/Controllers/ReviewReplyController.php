<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewReply;
use Illuminate\Http\Request;

class ReviewReplyController extends Controller
{
    public function store(Request $request, Review $review)
    {
        $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        // Only the cafe owner can reply
        $cafe = $review->cafe;
        if ($cafe->user_id !== auth()->id()) {
            abort(403, 'Only the cafe owner can reply to reviews.');
        }

        // Check if already replied
        if ($review->reply) {
            return back()->with('error', 'You have already replied to this review.');
        }

        ReviewReply::create([
            'review_id' => $review->id,
            'user_id' => auth()->id(),
            'reply' => $request->reply,
        ]);

        return back()->with('success', 'Reply posted successfully!');
    }
}
