<x-filament-panels::page>
    <div class="bg-emerald-300 p-4 rounded-lg">
       <p class="prose max-w-full">
           This is an experiment, and may be unstable and is subject to change and/or be removed.
           Please <a href="{{ $this->feedbackUrl() }}" target="_blank" rel="nofollow noreferrer noopener">send feedback</a>!
       </p>
    </div>

    <x-filament::card class="prose max-w-full ">
        <x-filament::section.heading>
            Welcome to the experimental GitHub blog post creator for HydePHP sites!
        </x-filament::section.heading>

        <p class="mt-2">
            This form allows you to visually create blog posts for HydePHP projects with the source hosted on GitHub.
        </p>
    </x-filament::card>

    <x-filament-panels::form
            :wire:key="$this->getId() . '.forms.' . $this->getFormStatePath()"
            wire:submit="create"
    >
        {{ $this->form }}

        <x-filament-panels::form.actions
                :actions="$this->getCachedFormActions()"
                :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>
</x-filament-panels::page>
