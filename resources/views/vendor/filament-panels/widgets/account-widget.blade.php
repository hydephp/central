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
                    {{ filament()->getUserName($user) }}
                </h2>
            </div>

            <form
                    action="{{ filament()->getLogoutUrl() }}"
                    method="post"
                    class="my-auto -me-2.5 sm:me-0"
            >
                @csrf

                <x-filament::link tag="button" type="submit" class="font-normal text-sm">{{ __('filament-panels::widgets/account-widget.actions.logout.label') }}</x-filament::link>
            </form>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
