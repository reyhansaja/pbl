@extends('layouts.app')

@section('title', 'Edit Cafe')

@section('content')
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <div class="mb-8">
        <a href="{{ route('owner.dashboard') }}" class="text-hearth-500 hover:text-hearth-800 text-sm font-medium inline-flex items-center gap-1 mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Dashboard
        </a>
        <h1 class="font-serif text-3xl font-bold text-hearth-800">Edit Your Cafe</h1>
    </div>

    <form method="POST" action="{{ route('owner.cafe.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        {{-- Basic Info --}}
        <div class="card p-6">
            <h2 class="font-serif text-xl font-semibold text-hearth-800 mb-5">Basic Information</h2>

            <div class="space-y-5">
                <div>
                    <label for="name" class="block text-sm font-semibold text-hearth-600 mb-2">Cafe Name *</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $cafe->name) }}" required class="input-field">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="about" class="block text-sm font-semibold text-hearth-600 mb-2">About Your Cafe *</label>
                    <textarea id="about" name="about" rows="5" required class="input-field">{{ old('about', $cafe->about) }}</textarea>
                    @error('about') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-semibold text-hearth-600 mb-2">Address *</label>
                    <input id="address" type="text" name="address" value="{{ old('address', $cafe->address) }}" required class="input-field">
                    @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="maps_embed" class="block text-sm font-semibold text-hearth-600 mb-2">Google Maps Embed</label>
                    <textarea id="maps_embed" name="maps_embed" rows="3" class="input-field text-sm">{{ old('maps_embed', $cafe->maps_embed) }}</textarea>
                    @error('maps_embed') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Existing Photos --}}
        <div class="card p-6" x-data="editPhotos()">
            <h2 class="font-serif text-xl font-semibold text-hearth-800 mb-5">Photos</h2>

            @if($cafe->photos->count() > 0)
                <div class="grid grid-cols-3 sm:grid-cols-4 gap-3 mb-4">
                    @foreach($cafe->photos as $photo)
                        <div class="relative aspect-square rounded-lg overflow-hidden group"
                             :class="deletedPhotos.includes({{ $photo->id }}) ? 'opacity-30' : ''">
                            <img src="{{ asset('storage/' . $photo->photo_path) }}" class="w-full h-full object-cover">

                            @if($photo->is_primary)
                                <div class="absolute top-1 left-1 bg-hearth-500 text-white text-xs px-2 py-0.5 rounded-full">Primary</div>
                            @endif

                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                <button type="button" @click="setPrimary({{ $photo->id }})"
                                        class="p-1.5 bg-white rounded-lg text-hearth-600 hover:text-hearth-800 text-xs">Primary</button>
                                <button type="button" @click="toggleDelete({{ $photo->id }})"
                                        class="p-1.5 bg-red-500 rounded-lg text-white text-xs"
                                        x-text="deletedPhotos.includes({{ $photo->id }}) ? 'Undo' : 'Delete'">Delete</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <input type="hidden" name="delete_photos" :value="deletedPhotos.join(',')">
            <input type="hidden" name="primary_photo_id" x-model="primaryPhotoId">

            <div>
                <label class="block text-sm font-semibold text-hearth-600 mb-2">Add New Photos</label>
                <input type="file" name="new_photos[]" multiple accept="image/*"
                       class="input-field text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-hearth-100 file:text-hearth-600 hover:file:bg-hearth-200">
            </div>
        </div>

        {{-- Schedule --}}
        <div class="card p-6">
            <h2 class="font-serif text-xl font-semibold text-hearth-800 mb-5">Opening Hours</h2>

            <div class="space-y-3">
                @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                    @php
                        $schedule = $cafe->schedules->firstWhere('day', $day);
                    @endphp
                    <div class="flex items-center gap-4 p-3 rounded-lg hover:bg-hearth-50 transition-colors"
                         x-data="{ isOpen: {{ ($schedule && !$schedule->is_closed) ? 'true' : 'false' }} }">
                        <label class="flex items-center gap-3 w-32 flex-shrink-0">
                            <input type="checkbox" name="schedule[{{ $day }}][open]" x-model="isOpen"
                                   class="w-4 h-4 bg-hearth-50 border-hearth-200 rounded text-hearth-600 focus:ring-hearth-500">
                            <span class="text-sm font-medium text-hearth-800 capitalize">{{ $day }}</span>
                        </label>
                        <div x-show="isOpen" class="flex items-center gap-2 flex-1">
                            <input type="time" name="schedule[{{ $day }}][open_time]"
                                   value="{{ $schedule ? substr($schedule->open_time, 0, 5) : '09:00' }}"
                                   class="input-field text-sm py-2">
                            <span class="text-hearth-400 text-sm">to</span>
                            <input type="time" name="schedule[{{ $day }}][close_time]"
                                   value="{{ $schedule ? substr($schedule->close_time, 0, 5) : '22:00' }}"
                                   class="input-field text-sm py-2">
                        </div>
                        <span x-show="!isOpen" class="text-sm text-red-500 font-medium">Closed</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('owner.dashboard') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary px-10">Save Changes</button>
        </div>
    </form>
</section>

@push('scripts')
<script>
function editPhotos() {
    return {
        deletedPhotos: [],
        primaryPhotoId: {{ $cafe->photos->where('is_primary', true)->first()->id ?? 'null' }},
        toggleDelete(id) {
            if (this.deletedPhotos.includes(id)) {
                this.deletedPhotos = this.deletedPhotos.filter(p => p !== id);
            } else {
                this.deletedPhotos.push(id);
            }
        },
        setPrimary(id) {
            this.primaryPhotoId = id;
        }
    };
}
</script>
@endpush
@endsection
