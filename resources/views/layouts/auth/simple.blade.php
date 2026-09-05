<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <div class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-sm flex-col gap-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <span class="flex flex-col items-center gap-1 mb-1">
                        <span style="
                            display: inline-flex;
                            align-items: center;
                            justify-content: center;
                            width: 56px;
                            height: 56px;
                            border-radius: 14px;
                            background: linear-gradient(135deg, #1a3a6b 0%, #2563eb 100%);
                            font-size: 1.15rem;
                            font-weight: 900;
                            letter-spacing: 0.04em;
                            color: #ffffff;
                            font-family: 'Inter', 'Segoe UI', sans-serif;
                            box-shadow: 0 4px 16px rgba(37,99,235,0.35);
                        ">SPP</span>
                    </span>
                    <span class="sr-only">{{ config('app.name', 'SPP') }}</span>
                </a>
                <div class="flex flex-col gap-6">
                    {{ $slot }}
                </div>
            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
