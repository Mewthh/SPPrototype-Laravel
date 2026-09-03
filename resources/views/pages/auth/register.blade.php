<x-layouts::auth :title="__('Admin Setup')">
    <div class="flex flex-col gap-6">
        @if(\App\Models\User::where('role', 'admin')->exists())
            <x-auth-header :title="__('Admin Already Registered')" :description="__('Initial administrator registration has been completed. Please log in to access the dashboard.')" />

            <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 text-center text-sm text-zinc-600 dark:text-zinc-400">
                <span>{{ __('New administrator accounts cannot be created publicly.') }}</span>
            </div>

            <div>
                <flux:button :href="route('login')" variant="primary" class="w-full">
                    {{ __('Go to Log in') }}
                </flux:button>
            </div>
        @else
            <x-auth-header :title="__('Initial Admin Registration')" :description="__('Create the administrator account for Samahang Pisika ng Pilipinas. This is a one-time setup.')" />

            <!-- Session Status -->
            <x-auth-session-status class="text-center" :status="session('status')" />

            <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
                @csrf
                <!-- Name -->
                <flux:input
                    name="name"
                    :label="__('Full Name')"
                    :value="old('name')"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                    :placeholder="__('e.g. SPP Administrator')"
                />

                <!-- Email Address -->
                <flux:input
                    name="email"
                    :label="__('Admin Email Address')"
                    :value="old('email')"
                    type="email"
                    required
                    autocomplete="email"
                    placeholder="admin@spp-online.org"
                />

                <!-- Password -->
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Create a strong password')"
                    passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                    viewable
                />

                <!-- Confirm Password -->
                <flux:input
                    name="password_confirmation"
                    :label="__('Confirm Password')"
                    type="password"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Confirm password')"
                    passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                    viewable
                />

                <div class="flex items-center justify-end">
                    <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                        {{ __('Register as Administrator') }}
                    </flux:button>
                </div>
            </form>

            <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
                <span>{{ __('Already have an account?') }}</span>
                <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
            </div>
        @endif
    </div>
</x-layouts::auth>
