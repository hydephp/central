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
                <div class="text-sm text-gray-500 dark:text-gray-400 flex flex-wrap" style="flex-direction: row;">
                    <p>This website</p>
                    <p>&nbsp;</p>
                    <p>will give you</p>
                    <p>&nbsp;</p>
                    <p>quick access</p>
                    <p>&nbsp;</p>
                    <p>and insight</p>
                    <p>&nbsp;</p>
                    <p> to all things</p>
                    <p>&nbsp;</p>
                    <p><x-filament::link href="https://hydephp.com/">HydePHP</x-filament::link></p>
                    <p>!</p>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
