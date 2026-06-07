<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Avatar Section --}}
        <div class="mb-6 flex items-center gap-5" x-data="{ 
            previewUrl: '{{ $user->avatar ? asset('storage/' . $user->avatar) : '' }}',
            handleAvatar(event) {
                const file = event.target.files[0];
                if (file) {
                    this.previewUrl = URL.createObjectURL(file);
                }
            }
        }">
            <div class="w-20 h-20 rounded-full overflow-hidden flex items-center justify-center bg-hearth-100 border-2 border-hearth-200">
                <template x-if="previewUrl">
                    <img :src="previewUrl" alt="Avatar Preview" class="w-full h-full object-cover">
                </template>
                <template x-if="!previewUrl">
                    <span class="text-hearth-600 text-3xl font-bold font-serif">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                </template>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-hearth-800 mb-1.5">{{ __('Profile Picture') }}</label>
                <label class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-hearth-200 hover:border-hearth-400 hover:text-hearth-800 text-hearth-500 rounded-lg cursor-pointer text-xs font-semibold shadow-sm transition-colors">
                    <svg class="w-4 h-4 text-hearth-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ __('Upload New') }}</span>
                    <input type="file" name="avatar" accept="image/*" class="hidden" @change="handleAvatar($event)">
                </label>
                <p class="text-[10px] text-hearth-400 mt-1">{{ __('JPEG, PNG, JPG or WEBP. Max 2MB.') }}</p>
                @error('avatar')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
