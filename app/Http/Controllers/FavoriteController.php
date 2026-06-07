<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()->favoriteCafes()
            ->where('is_approved', true)
            ->with(['photos', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->paginate(12);

        return view('user.favorites', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'cafe_id' => 'required|exists:cafes,id',
        ]);

        $cafe = Cafe::findOrFail($request->cafe_id);
        if (!$cafe->is_approved) {
            abort(403, 'This cafe is not approved yet.');
        }

        $favorite = Favorite::where('user_id', auth()->id())
            ->where('cafe_id', $request->cafe_id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $status = 'removed';
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'cafe_id' => $request->cafe_id,
            ]);
            $status = 'added';
        }

        if ($request->ajax()) {
            return response()->json(['status' => $status]);
        }

        return back()->with('success',
            $status === 'added' ? 'Cafe added to favorites!' : 'Cafe removed from favorites.'
        );
    }
}
