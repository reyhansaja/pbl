<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_cafes' => Cafe::count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_owners' => User::where('role', 'owner')->count(),
            'total_reviews' => \App\Models\Review::count(),
        ];

        $recentCafes = Cafe::with('owner')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest()
            ->take(5)
            ->get();

        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentCafes', 'recentUsers'));
    }

    public function cafes()
    {
        $cafes = Cafe::with('owner')
            ->withAvg('reviews', 'rating')
            ->withCount(['reviews', 'favorites'])
            ->paginate(15);

        return view('admin.cafes', compact('cafes'));
    }

    public function deleteCafe(Cafe $cafe)
    {
        // notify owner before deletion
        try {
            if ($cafe->owner && $cafe->owner->email) {
                \Illuminate\Support\Facades\Mail::to($cafe->owner->email)
                    ->send(new \App\Mail\CafeDeleted($cafe->name));
            }
        } catch (\Exception $e) {
            report($e);
        }

        $cafe->delete();

        return back()->with('success', __('Cafe deleted successfully.'));
    }

    public function approveCafe(Cafe $cafe)
    {
        $cafe->update(['is_approved' => true]);

        // Send notification email to cafe owner if available
        try {
            if ($cafe->owner && $cafe->owner->email) {
                \Illuminate\Support\Facades\Mail::to($cafe->owner->email)
                    ->send(new \App\Mail\CafeApproved($cafe));
            }
        } catch (\Exception $e) {
            // swallow email errors but log them
            report($e);
        }

        return back()->with('success', __('Cafe approved successfully.'));
    }

    public function users()
    {
        $users = User::withCount(['reviews', 'favorites'])
            ->paginate(15);

        return view('admin.users', compact('users'));
    }

    public function deleteUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', __('Cannot delete admin user.'));
        }

        $user->delete();

        return back()->with('success', __('User deleted successfully.'));
    }
}
