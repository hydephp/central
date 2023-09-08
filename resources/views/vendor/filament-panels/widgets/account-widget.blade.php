@php
    $user = filament()->auth()->user();
@endphp

<x-filament-widgets::widget class="fi-account-widget">
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <x-filament-panels::avatar.user size="lg" :user="$user" />

            <div class="flex-1">
                <h2
                        class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white"
                >
                    {{ __('filament-panels::widgets/account-widget.welcome', ['app' => config('app.name')]) }},
                    {{ filament()->getUserName($user) }}!
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    This website will give you quick access and insight to all things <x-filament::link href="https://hydephp.com/">HydePHP</x-filament::link>!
                </p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
