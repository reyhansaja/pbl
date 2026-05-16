@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-hearth-500 hover:text-hearth-800 text-sm font-medium inline-flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Dashboard
            </a>
            <h1 class="font-serif text-3xl font-bold text-hearth-800">Manage Users</h1>
        </div>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-hearth-50 border-b border-hearth-100">
                    <tr>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-hearth-400 uppercase tracking-wider">User</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-hearth-400 uppercase tracking-wider">Email</th>
                        <th class="text-center py-3 px-4 text-xs font-semibold text-hearth-400 uppercase tracking-wider">Role</th>
                        <th class="text-center py-3 px-4 text-xs font-semibold text-hearth-400 uppercase tracking-wider">Reviews</th>
                        <th class="text-center py-3 px-4 text-xs font-semibold text-hearth-400 uppercase tracking-wider">Favorites</th>
                        <th class="text-center py-3 px-4 text-xs font-semibold text-hearth-400 uppercase tracking-wider">Joined</th>
                        <th class="text-right py-3 px-4 text-xs font-semibold text-hearth-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-hearth-100">
                    @foreach($users as $user)
                        <tr class="hover:bg-hearth-50/50 transition-colors">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-hearth-200 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-hearth-600 text-xs font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                    <span class="font-semibold text-hearth-800">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-sm text-hearth-600">{{ $user->email }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="badge {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : ($user->role === 'owner' ? 'bg-blue-100 text-blue-800' : 'bg-hearth-100 text-hearth-600') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center text-sm text-hearth-600">{{ $user->reviews_count }}</td>
                            <td class="py-3 px-4 text-center text-sm text-hearth-600">{{ $user->favorites_count }}</td>
                            <td class="py-3 px-4 text-center text-sm text-hearth-400">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="py-3 px-4 text-right">
                                @if(!$user->isAdmin())
                                    <form method="POST" action="{{ route('admin.users.delete', $user) }}" onsubmit="return confirm('Delete this user? This will also delete their cafe and reviews.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium">Delete</button>
                                    </form>
                                @else
                                    <span class="text-xs text-hearth-300">Protected</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</section>
@endsection
