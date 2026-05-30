<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\CafePhoto;
use App\Models\CafeSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OwnerCafeController extends Controller
{
    public function dashboard()
    {
        $cafe = auth()->user()->cafe;

        if (!$cafe) {
            return redirect()->route('owner.cafe.create');
        }

        $cafe->load(['photos', 'schedules', 'reviews.user', 'reviews.reply']);
        $cafe->loadAvg('reviews', 'rating');
        $cafe->loadCount(['reviews', 'favorites']);

        $recentReviews = $cafe->reviews()->with(['user', 'reply'])->latest()->take(5)->get();

        return view('owner.dashboard', compact('cafe', 'recentReviews'));
    }

    public function create()
    {
        if (auth()->user()->cafe) {
            return redirect()->route('owner.dashboard')
                ->with('warning', 'You have already registered a cafe.');
        }

        return view('owner.cafe-create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->cafe) {
            return redirect()->route('owner.dashboard')
                ->with('warning', 'You have already registered a cafe.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'required|string',
            'address' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'maps_embed' => 'nullable|string',
            'photos' => 'required|array|min:1',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'primary_photo' => 'required|integer|min:0',
            'schedule' => 'required|array',
        ]);

        $cafe = Cafe::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'about' => $request->about,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'maps_embed' => $request->maps_embed,
        ]);

        // Upload photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('cafe-photos', 'public');
                CafePhoto::create([
                    'cafe_id' => $cafe->id,
                    'photo_path' => $path,
                    'is_primary' => $index == $request->primary_photo,
                ]);
            }
        }

        // Save schedules
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        foreach ($days as $day) {
            $scheduleData = $request->schedule[$day] ?? null;
            CafeSchedule::create([
                'cafe_id' => $cafe->id,
                'day' => $day,
                'is_closed' => !isset($scheduleData['open']),
                'open_time' => $scheduleData['open_time'] ?? null,
                'close_time' => $scheduleData['close_time'] ?? null,
            ]);
        }

        return redirect()->route('owner.dashboard')
            ->with('success', 'Cafe registered successfully!');
    }

    public function edit()
    {
        $cafe = auth()->user()->cafe;

        if (!$cafe) {
            return redirect()->route('owner.cafe.create');
        }

        $cafe->load(['photos', 'schedules']);

        return view('owner.cafe-edit', compact('cafe'));
    }

    public function update(Request $request)
    {
        $cafe = auth()->user()->cafe;

        if (!$cafe) {
            return redirect()->route('owner.cafe.create');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'required|string',
            'address' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'maps_embed' => 'nullable|string',
            'new_photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'schedule' => 'required|array',
        ]);

        $cafe->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'about' => $request->about,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'maps_embed' => $request->maps_embed,
        ]);

        // Delete removed photos
        if ($request->filled('delete_photos')) {
            $photoIds = explode(',', $request->delete_photos);
            $photosToDelete = CafePhoto::whereIn('id', $photoIds)->where('cafe_id', $cafe->id)->get();
            foreach ($photosToDelete as $photo) {
                Storage::disk('public')->delete($photo->photo_path);
                $photo->delete();
            }
        }

        // Upload new photos
        if ($request->hasFile('new_photos')) {
            foreach ($request->file('new_photos') as $photo) {
                $path = $photo->store('cafe-photos', 'public');
                CafePhoto::create([
                    'cafe_id' => $cafe->id,
                    'photo_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        // Update primary photo
        if ($request->filled('primary_photo_id')) {
            $cafe->photos()->update(['is_primary' => false]);
            CafePhoto::where('id', $request->primary_photo_id)
                ->where('cafe_id', $cafe->id)
                ->update(['is_primary' => true]);
        }

        // Update schedules
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        foreach ($days as $day) {
            $scheduleData = $request->schedule[$day] ?? null;
            $cafe->schedules()->updateOrCreate(
                ['day' => $day],
                [
                    'is_closed' => !isset($scheduleData['open']),
                    'open_time' => $scheduleData['open_time'] ?? null,
                    'close_time' => $scheduleData['close_time'] ?? null,
                ]
            );
        }

        return redirect()->route('owner.dashboard')
            ->with('success', 'Cafe updated successfully!');
    }
}
