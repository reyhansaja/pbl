@extends('layouts.app')

@section('title', 'Register Your Cafe')

@section('content')
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <div class="mb-8">
        <p class="text-hearth-500 text-sm font-semibold uppercase tracking-wider mb-2">Get Started</p>
        <h1 class="font-serif text-3xl font-bold text-hearth-800">Register Your Cafe</h1>
        <p class="text-hearth-400 mt-2">Tell us about your cafe and start reaching coffee lovers.</p>
    </div>

    <form method="POST" action="{{ route('owner.cafe.store') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf

        {{-- Basic Info --}}
        <div class="card p-6">
            <h2 class="font-serif text-xl font-semibold text-hearth-800 mb-5">Basic Information</h2>

            <div class="space-y-5">
                <div>
                    <label for="name" class="block text-sm font-semibold text-hearth-600 mb-2">Cafe Name *</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required class="input-field" placeholder="The Gilded Bean">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="about" class="block text-sm font-semibold text-hearth-600 mb-2">About Your Cafe *</label>
                    <textarea id="about" name="about" rows="5" required class="input-field" placeholder="Tell visitors what makes your cafe special...">{{ old('about') }}</textarea>
                    @error('about') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-semibold text-hearth-600 mb-2">Address *</label>
                    <input id="address" type="text" name="address" value="{{ old('address') }}" required class="input-field" placeholder="Jl. Braga No. 58, Bandung">
                    @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="maps_embed" class="block text-sm font-semibold text-hearth-600 mb-2">Google Maps Embed Link</label>
                    <textarea id="maps_embed" name="maps_embed" rows="3" class="input-field text-sm" placeholder='Paste your Google Maps embed iframe code here...'>{{ old('maps_embed') }}</textarea>
                    <p class="text-xs text-hearth-400 mt-1">Go to Google Maps → Share → Embed a map → Copy the iframe code</p>
                    @error('maps_embed') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Photos --}}
        <div class="card p-6">
            <h2 class="font-serif text-xl font-semibold text-hearth-800 mb-5">Cafe Photos</h2>

            <div x-data="photoUpload()">
                <div class="border-2 border-dashed border-hearth-200 rounded-xl p-8 text-center hover:border-hearth-400 transition-colors cursor-pointer"
                     @click="$refs.fileInput.click()">
                    <svg class="w-10 h-10 text-hearth-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-hearth-400 text-sm mb-1">Click to upload photos</p>
                    <p class="text-hearth-300 text-xs">JPEG, PNG, WebP. Max 2MB each.</p>
                </div>
                <input type="file" x-ref="fileInput" name="photos[]" multiple accept="image/*" class="hidden" @change="handleFiles($event)">
                <input type="hidden" name="primary_photo" x-model="primaryIndex">

                <div x-show="previews.length > 0" class="grid grid-cols-3 sm:grid-cols-4 gap-3 mt-4">
                    <template x-for="(preview, index) in previews" :key="index">
                        <div class="relative aspect-square rounded-lg overflow-hidden cursor-pointer border-2 transition-all"
                             :class="primaryIndex === index ? 'border-hearth-500 ring-2 ring-hearth-500' : 'border-transparent'"
                             @click="primaryIndex = index">
                            <img :src="preview" class="w-full h-full object-cover">
                            <div x-show="primaryIndex === index" class="absolute top-1 left-1 bg-hearth-500 text-white text-xs px-2 py-0.5 rounded-full">Primary</div>
                        </div>
                    </template>
                </div>
            </div>
            @error('photos') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Schedule --}}
        <div class="card p-6">
            <h2 class="font-serif text-xl font-semibold text-hearth-800 mb-5">Opening Hours</h2>

            <div class="space-y-3">
                @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                    <div class="flex items-center gap-4 p-3 rounded-lg hover:bg-hearth-50 transition-colors" x-data="{ isOpen: true }">
                        <label class="flex items-center gap-3 w-32 flex-shrink-0">
                            <input type="checkbox" name="schedule[{{ $day }}][open]" x-model="isOpen" checked
                                   class="w-4 h-4 bg-hearth-50 border-hearth-200 rounded text-hearth-600 focus:ring-hearth-500">
                            <span class="text-sm font-medium text-hearth-800 capitalize">{{ $day }}</span>
                        </label>
                        <div x-show="isOpen" class="flex items-center gap-2 flex-1">
                            <input type="time" name="schedule[{{ $day }}][open_time]" value="09:00"
                                   class="input-field text-sm py-2">
                            <span class="text-hearth-400 text-sm">to</span>
                            <input type="time" name="schedule[{{ $day }}][close_time]" value="22:00"
                                   class="input-field text-sm py-2">
                        </div>
                        <span x-show="!isOpen" class="text-sm text-red-500 font-medium">Closed</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn-primary px-10">
                Register Cafe →
            </button>
        </div>
    </form>
</section>

@push('scripts')
<script>
function photoUpload() {
    return {
        previews: [],
        primaryIndex: 0,
        handleFiles(event) {
            const files = event.target.files;
            this.previews = [];
            for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previews.push(e.target.result);
                };
                reader.readAsDataURL(files[i]);
            }
        }
    };
}
</script>
@endpush
@endsection
