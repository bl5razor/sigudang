<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />

            <div class="relative">
                <x-text-input 
                    id="update_password_current_password"
                    name="current_password"
                    type="password"
                    class="mt-1 block w-full pr-10"
                    autocomplete="current-password"
                />

                <button 
                    type="button"
                    onclick="togglePassword('update_password_current_password')"
                    class="absolute right-3 top-4 text-gray-500"
                >
                    👁
                </button>
            </div>

            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />

            <div class="relative">
                <x-text-input 
                    id="update_password_password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full pr-10"
                    autocomplete="new-password"
                />

                <button 
                    type="button"
                    onclick="togglePassword('update_password_password')"
                    class="absolute right-3 top-4 text-gray-500"
                >
                    👁
                </button>
            </div>

            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />

            <div class="relative">
                <x-text-input 
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="mt-1 block w-full pr-10"
                    autocomplete="new-password"
                />

                <button 
                    type="button"
                    onclick="togglePassword('update_password_password_confirmation')"
                    class="absolute right-3 top-4 text-gray-500"
                >
                    👁
                </button>
            </div>

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);

        if (input.type === 'password') {
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    }
</script>