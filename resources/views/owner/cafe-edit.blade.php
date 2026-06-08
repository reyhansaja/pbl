@extends('layouts.app')

@section('title', __('Edit Cafe'))

@section('content')
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <div class="mb-8">
        <a href="{{ route('owner.dashboard') }}" class="text-hearth-500 hover:text-hearth-800 text-sm font-medium inline-flex items-center gap-1 mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            {{ __('Back to Dashboard') }}
        </a>
        <h1 class="font-serif text-3xl font-bold text-hearth-800">{{ __('Edit Your Cafe') }}</h1>
    </div>

    <form method="POST" action="{{ route('owner.cafe.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        {{-- Basic Info --}}
        <div class="card p-6">
            <h2 class="font-serif text-xl font-semibold text-hearth-800 mb-5">{{ __('Basic Information') }}</h2>

            <div class="space-y-5">
                <div>
                    <label for="name" class="block text-sm font-semibold text-hearth-600 mb-2">{{ __('Cafe Name') }} *</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $cafe->name) }}" required class="input-field">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="about" class="block text-sm font-semibold text-hearth-600 mb-2">{{ __('About Your Cafe') }} *</label>
                    <textarea id="about" name="about" rows="5" required class="input-field">{{ old('about', $cafe->about) }}</textarea>
                    @error('about') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-semibold text-hearth-600 mb-2">{{ __('Address') }} *</label>
                    <div class="flex gap-2">
                        <input id="address" type="text" name="address" value="{{ old('address', $cafe->address) }}" required class="input-field flex-1" placeholder="Jl. Braga No. 58, Bandung">
                        <button type="button" id="btn-geocode" class="px-4 py-2 bg-hearth-100 hover:bg-hearth-200 active:bg-hearth-300 text-hearth-700 text-sm font-semibold rounded-lg transition-all flex items-center gap-2 border border-hearth-200">
                            <svg id="geocode-icon" class="w-4 h-4 text-hearth-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <svg id="geocode-spinner" class="w-4 h-4 animate-spin text-hearth-600 hidden" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span id="btn-geocode-text">{{ __('Find GPS') }}</span>
                        </button>
                    </div>
                    <div id="geocode-feedback" class="text-xs mt-1 transition-all">
                        <span class="text-hearth-400">{{ __('Coordinates will automatically fill when you type your address or click "Find GPS".') }}</span>
                    </div>
                    @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="latitude" class="block text-sm font-semibold text-hearth-600 mb-2">{{ __('Latitude') }}</label>
                        <input id="latitude" type="text" name="latitude" value="{{ old('latitude', $cafe->latitude) }}" class="input-field bg-hearth-50/50" placeholder="e.g. -6.9174639">
                        @error('latitude') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="longitude" class="block text-sm font-semibold text-hearth-600 mb-2">{{ __('Longitude') }}</label>
                        <input id="longitude" type="text" name="longitude" value="{{ old('longitude', $cafe->longitude) }}" class="input-field bg-hearth-50/50" placeholder="e.g. 107.6191228">
                        @error('longitude') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-hearth-600 mb-2">{{ __('Pinpoint Location on Map') }}</label>
                    <div id="form-map" class="rounded-xl border border-hearth-200 overflow-hidden shadow-sm" style="height: 250px; z-index: 1;"></div>
                    <p class="text-xs text-hearth-400 mt-1">{{ __('Drag the marker to pinpoint the exact location if needed.') }}</p>
                </div>

                <div>
                    <label for="maps_embed" class="block text-sm font-semibold text-hearth-600 mb-2">{{ __('Google Maps Embed (Optional Fallback)') }}</label>
                    <textarea id="maps_embed" name="maps_embed" rows="3" class="input-field text-sm">{{ old('maps_embed', $cafe->maps_embed) }}</textarea>
                    <p class="text-xs text-hearth-400 mt-1">{{ __('Go to Google Maps → Share → Embed a map → Copy the iframe code') }}</p>
                    @error('maps_embed') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Existing Photos --}}
        <div class="card p-6" x-data="editPhotos()">
            <h2 class="font-serif text-xl font-semibold text-hearth-800 mb-5">{{ __('Photos') }}</h2>

            @if($cafe->photos->count() > 0)
                <div class="grid grid-cols-3 sm:grid-cols-4 gap-3 mb-4">
                    @foreach($cafe->photos as $photo)
                        <div class="relative aspect-square rounded-lg overflow-hidden group"
                             :class="deletedPhotos.includes({{ $photo->id }}) ? 'opacity-30' : ''">
                            <img src="{{ asset('storage/' . $photo->photo_path) }}" class="w-full h-full object-cover">

                            @if($photo->is_primary)
                                <div class="absolute top-1 left-1 bg-hearth-500 text-white text-xs px-2 py-0.5 rounded-full">{{ __('Primary') }}</div>
                            @endif

                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                <button type="button" @click="setPrimary({{ $photo->id }})"
                                        class="p-1.5 bg-white rounded-lg text-hearth-600 hover:text-hearth-800 text-xs">{{ __('Primary') }}</button>
                                <button type="button" @click="toggleDelete({{ $photo->id }})"
                                        class="p-1.5 bg-red-500 rounded-lg text-white text-xs"
                                        x-text="deletedPhotos.includes({{ $photo->id }}) ? '{{ __('Undo') }}' : '{{ __('Delete') }}'">{{ __('Delete') }}</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <input type="hidden" name="delete_photos" :value="deletedPhotos.join(',')">
            <input type="hidden" name="primary_photo_id" x-model="primaryPhotoId">

            <div>
                <label class="block text-sm font-semibold text-hearth-600 mb-2">{{ __('Add New Photos') }}</label>
                <input type="file" name="new_photos[]" multiple accept="image/*"
                       class="input-field text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-hearth-100 file:text-hearth-600 hover:file:bg-hearth-200">
            </div>
        </div>

        {{-- Schedule --}}
        <div class="card p-6">
            <h2 class="font-serif text-xl font-semibold text-hearth-800 mb-5">{{ __('Opening Hours') }}</h2>

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
                            <span class="text-sm font-medium text-hearth-800 capitalize">{{ __($day) }}</span>
                        </label>
                        <div x-show="isOpen" class="flex items-center gap-2 flex-1">
                            <input type="time" name="schedule[{{ $day }}][open_time]"
                                   value="{{ $schedule ? substr($schedule->open_time, 0, 5) : '09:00' }}"
                                   class="input-field text-sm py-2">
                            <span class="text-hearth-400 text-sm">{{ __('to') }}</span>
                            <input type="time" name="schedule[{{ $day }}][close_time]"
                                   value="{{ $schedule ? substr($schedule->close_time, 0, 5) : '22:00' }}"
                                   class="input-field text-sm py-2">
                        </div>
                        <span x-show="!isOpen" class="text-sm text-red-500 font-medium">{{ __('Closed') }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('owner.dashboard') }}" class="btn-secondary">{{ __('Cancel') }}</a>
            <button type="submit" class="btn-primary px-10">{{ __('Save Changes') }}</button>
        </div>
    </form>
</section>

@push('scripts')
{{-- Include Leaflet CSS and JS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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

document.addEventListener('DOMContentLoaded', function () {
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const addressInput = document.getElementById('address');
    const btnGeocode = document.getElementById('btn-geocode');
    const btnGeocodeText = document.getElementById('btn-geocode-text');

    // Default coordinates (Use saved cafe coordinates if available, otherwise Bandung center)
    let initialLat = parseFloat(latInput.value) || -6.9174639;
    let initialLng = parseFloat(lngInput.value) || 107.6191228;
    let initialZoom = (latInput.value && lngInput.value) ? 16 : 13;

    // Initialize Map
    const map = L.map('form-map', {
        zoomControl: false
    }).setView([initialLat, initialLng], initialZoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.control.zoom({
        position: 'bottomright'
    }).addTo(map);

    // Custom SVG Coffee Pin (Same as Detail Page for consistency)
    const customCoffeeIcon = L.divIcon({
        className: 'custom-div-icon',
        html: `
            <div class="relative flex items-center justify-center shadow-lg rounded-full overflow-hidden bg-white border border-hearth-200" style="width: 42px; height: 42px;">
                <svg class="w-[60%] h-[60%]" viewBox="0 0 24 24" fill="none" stroke="#B85C38" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8h1a4 4 0 0 1 0 8h-1"/>
                    <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/>
                    <line x1="6" y1="2" x2="6" y2="4"/>
                    <line x1="10" y1="2" x2="10" y2="4"/>
                    <line x1="14" y1="2" x2="14" y2="4"/>
                </svg>
            </div>
            <div class="absolute bottom-[-6px] left-[50%] translate-x-[-50%] w-3 h-3 bg-white rotate-45 border-r border-b border-hearth-200 shadow-md z-[-1]"></div>
        `,
        iconSize: [42, 42],
        iconAnchor: [21, 48],
        popupAnchor: [0, -42]
    });

    // Add Draggable Marker
    const marker = L.marker([initialLat, initialLng], {
        icon: customCoffeeIcon,
        draggable: true
    }).addTo(map);

    // Update inputs on drag end
    marker.on('dragend', function (e) {
        const position = marker.getLatLng();
        latInput.value = position.lat.toFixed(7);
        lngInput.value = position.lng.toFixed(7);
        setFeedback('success', '✓ Letak pin berhasil digeser manual!');
    });

    // Update marker on manual map click
    map.on('click', function (e) {
        marker.setLatLng(e.latlng);
        latInput.value = e.latlng.lat.toFixed(7);
        lngInput.value = e.latlng.lng.toFixed(7);
        setFeedback('success', '✓ Letak pin berhasil ditentukan dari klik peta!');
    });

    // Feedback visual helper
    const feedbackEl = document.getElementById('geocode-feedback');
    const spinner = document.getElementById('geocode-spinner');
    const icon = document.getElementById('geocode-icon');

    function setFeedback(type, message) {
        if (!feedbackEl) return;
        feedbackEl.innerHTML = '';
        if (type === 'default') {
            feedbackEl.className = 'text-xs mt-1 text-hearth-400';
            feedbackEl.textContent = message || "{{ __('Coordinates will automatically fill when you type your address or click \"Find GPS\".') }}";
            spinner.classList.add('hidden');
            icon.classList.remove('hidden');
        } else if (type === 'loading') {
            feedbackEl.className = 'text-xs mt-1 text-amber-600 font-semibold flex items-center gap-1';
            feedbackEl.textContent = message || 'Mencari koordinat alamat di peta...';
            spinner.classList.remove('hidden');
            icon.classList.add('hidden');
        } else if (type === 'success') {
            feedbackEl.className = 'text-xs mt-1 text-green-600 font-semibold';
            feedbackEl.textContent = message || '✓ Lokasi ditemukan dan peta diperbarui!';
            spinner.classList.add('hidden');
            icon.classList.remove('hidden');
        } else if (type === 'error') {
            feedbackEl.className = 'text-xs mt-1 text-red-600 font-semibold';
            feedbackEl.textContent = message || '⚠ Alamat tidak ditemukan. Silakan tulis lebih lengkap (nama jalan/kota) atau geser pin langsung di peta.';
            spinner.classList.add('hidden');
            icon.classList.remove('hidden');
        }
    }

    // Geocoding function
    let geocodingInProgress = false;
    let lastGeocodedAddress = '';

    async function fetchGeocode(query) {
        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`);
            return await response.json();
        } catch (error) {
            console.error('Fetch error:', error);
            return null;
        }
    }

    async function performGeocoding() {
        const originalAddress = addressInput.value.trim();
        if (!originalAddress) {
            setFeedback('default');
            return;
        }

        // Avoid double-fetching if address is unchanged
        if (originalAddress === lastGeocodedAddress) {
            return;
        }

        if (geocodingInProgress) return;

        geocodingInProgress = true;
        btnGeocode.disabled = true;
        setFeedback('loading');

        // Let's try multiple queries in sequence as fallback!
        let queries = [];
        
        // 1. Original Address
        queries.push(originalAddress);

        // 2. Cleaned Address: stripping "No. XX"
        let clean = originalAddress;
        let withoutHouseNumber = clean
            .replace(/\b(?:no\.?|nomer|num\.?|number)?\s*\d+[a-z]?\b/gi, '')
            .replace(/\s*,\s*/g, ', ')
            .replace(/,\s*,/g, ', ')
            .trim();
            
        if (withoutHouseNumber && withoutHouseNumber !== clean) {
            queries.push(withoutHouseNumber);
        }

        // 3. Try converting "Jl." or "Jl" to "Jalan"
        let withJalan = originalAddress.replace(/\bJl\.?\b/gi, 'Jalan');
        if (withJalan !== originalAddress) {
            queries.push(withJalan);
            
            // Try with Jalan and without house number
            let withJalanNoHouse = withJalan
                .replace(/\b(?:no\.?|nomer|num\.?|number)?\s*\d+[a-z]?\b/gi, '')
                .replace(/\s*,\s*/g, ', ')
                .trim();
            if (withJalanNoHouse && withJalanNoHouse !== withJalan) {
                queries.push(withJalanNoHouse);
            }
        }
        
        // 4. Try converting "Mayjend" or "Mayjen" to "Mayor Jenderal" and "Jl." to "Jalan"
        let withMayorJenderal = originalAddress
            .replace(/\bJl\.?\b/gi, 'Jalan')
            .replace(/\bMayjend\b/gi, 'Mayor Jenderal')
            .replace(/\bMayjen\b/gi, 'Mayor Jenderal');
            
        if (withMayorJenderal !== originalAddress) {
            queries.push(withMayorJenderal);
            
            let withMayorJenderalNoHouse = withMayorJenderal
                .replace(/\b(?:no\.?|nomer|num\.?|number)?\s*\d+[a-z]?\b/gi, '')
                .replace(/\s*,\s*/g, ', ')
                .trim();
            queries.push(withMayorJenderalNoHouse);
        }

        // 5. Try explicit "Mayjen" conversion (common in Malang)
        let withMayjen = originalAddress
            .replace(/\bJl\.?\b/gi, 'Jalan')
            .replace(/\bMayjend\b/gi, 'Mayjen');
            
        if (withMayjen !== originalAddress) {
            queries.push(withMayjen);
            
            let withMayjenNoHouse = withMayjen
                .replace(/\b(?:no\.?|nomer|num\.?|number)?\s*\d+[a-z]?\b/gi, '')
                .replace(/\s*,\s*/g, ', ')
                .trim();
            queries.push(withMayjenNoHouse);
        }

        // Filter out duplicates and empty/too-short queries
        queries = [...new Set(queries)].filter(q => q.length > 5);

        let data = null;
        let successfulQuery = '';

        for (const query of queries) {
            const result = await fetchGeocode(query);
            if (result && result.length > 0) {
                data = result;
                successfulQuery = query;
                break; // Found a match!
            }
        }

        if (data && data.length > 0) {
            const result = data[0];
            const lat = parseFloat(result.lat);
            const lng = parseFloat(result.lon);

            latInput.value = lat.toFixed(7);
            lngInput.value = lng.toFixed(7);

            const newLatLng = new L.LatLng(lat, lng);
            marker.setLatLng(newLatLng);
            map.setView(newLatLng, 16);

            lastGeocodedAddress = originalAddress;
            
            let feedbackMsg = '✓ Lokasi ditemukan!';
            if (successfulQuery !== originalAddress) {
                feedbackMsg = `✓ Lokasi ditemukan (dengan kata kunci: "${successfulQuery}")!`;
            }
            setFeedback('success', feedbackMsg);
        } else {
            setFeedback('error');
        }

        geocodingInProgress = false;
        btnGeocode.disabled = false;
    }

    // Bind events
    btnGeocode.addEventListener('click', function(e) {
        e.preventDefault();
        performGeocoding();
    });
    
    // Trigger geocode on blur, but with a slight delay so button click takes priority if clicked
    addressInput.addEventListener('blur', function() {
        setTimeout(performGeocoding, 250);
    });
});
</script>

<style>
    /* Styling to blend Leaflet perfectly with Hearth styles */
    .leaflet-container {
        font-family: 'Inter', sans-serif !important;
        background: #FAF6F1 !important;
    }
    .leaflet-bar {
        border: none !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
        border-radius: 0.5rem !important;
        overflow: hidden;
    }
    .leaflet-bar a {
        background-color: #ffffff !important;
        color: #2C1810 !important;
        border-bottom: 1px solid #FAF6F1 !important;
    }
</style>
@endpush
@endsection
