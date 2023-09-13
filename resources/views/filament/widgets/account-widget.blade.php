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
                    {{ __('Welcome to :app, :user!', ['app' => config('app.name'), 'user' => filament()->getUserName($user)]) }}
                </h2>
                <div class="text-sm text-gray-500 dark:text-gray-400 grid md:grid-cols-12">
                    <p class="mb-4 col-span-5">
                        This website will give you quick access and insight to all things
                        <x-filament::link href="https://hydephp.com/">HydePHP</x-filament::link>
                        &ndash; the static site generator you've been waiting for.
                    </p>
                    <p class="col-span-7 md:ps-6">
                        Please note that this platform is intended for those who wish to contribute
                        to the library source code itself, and if you are simply looking to create
                        a site with HydePHP, you may instead want to head over to the
                        <a href="https://hydephp.com/docs" style="--c-300:var(--primary-300);--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);" class="fi-link fi-link-size-md relative inline-flex items-center justify-center font-semibold outline-none transition duration-75 hover:underline focus:underline gap-1.5 text-sm text-custom-600 dark:text-custom-400">official docs</a>!
                    </p>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
