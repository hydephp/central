<x-filament-panels::page>
    <style> /* Margin and rounding are personal preferences, overflow-x-auto is recommended. */ pre { border-radius: 0.25rem; margin-top: 1rem; margin-bottom: 1rem; overflow-x: auto; } /* Add some vertical padding and expand the width to fill its container. The horizontal padding comes at the line level so that background colors extend edge to edge. */ pre code.torchlight { display: block; min-width: -webkit-max-content; min-width: -moz-max-content; min-width: max-content; padding-top: 1rem; padding-bottom: 1rem; } /* Horizontal line padding to match the vertical padding from the code block above. */ pre code.torchlight .line { padding-left: 1rem; padding-right: 1rem; } /* Push the code away from the line numbers and summary caret indicators. */ pre code.torchlight .line-number, pre code.torchlight .summary-caret { margin-right: 1rem; } </style>
    <style>
        /** @copyright All rights reserved (Based on Argon Code Previews) */

        #code-card-wrapper {
            padding: {{ $padding }}rem;
            resize: horizontal;
            overflow: hidden;
            max-width: 100%;

            width: {{ $width }}ch; /* Todo see if we can add JS to sync resize changes to data state */
        }

        #code-card-wrapper:hover {
            outline: rgba(255, 255, 255, 0.5) solid;
        }

        .code-card {
            overflow: hidden;
            background: #292d3e;
            width: 100%;
            border-radius: 8px;
        }

        .code-card main>pre {
            margin: 0;
        }
        .code-card main>code {
            font-family: 'Fira Code', monospace
        }

        .code-card header {
            padding: 8px 4px;
            background: #212529;
            color: #fff;
            display: flex;
            align-items: center
        }

        .code-card header h1 {
            font-size: 14px;
            font-weight: 400;
            margin: 0 auto;
            color: rgba(255, 255, 255, .75);
            font-family: sans-serif
        }

        .code-card header menu {
            user-select: none;
            margin-left: 10px;
            float: left;
            position: absolute
        }

        .code-card header menu button {
            all: unset;
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            cursor: pointer;
            opacity: .75;
            margin-right: 1px;
        }

        .code-card header menu button:hover {
            opacity: 1
        }

        .code-card header menu button.red {
            background-color: #f3615a
        }

        .code-card header menu button.yellow {
            background-color: #f4c036
        }

        .code-card header menu button.green {
            background-color: #3ccb3e
        }
    </style>
    <x-filament::card>
        <x-filament-panels::form
                :wire:key="$this->getId() . '.forms.' . $this->getFormStatePath()"
                wire:submit="generate"
        >
            {{ $this->form }}

            <x-filament-panels::form.actions
                    :actions="$this->getCachedFormActions()"
                    :full-width="$this->hasFullWidthFormActions()"
            />
        </x-filament-panels::form>
    </x-filament::card>

    <x-filament::card>
        <x-filament::section.heading>
            <div class="flex justify-between">
                <div class="flex items-center mb-2">
                    <h2 class="text-xl">Result</h2>
                    <x-filament::loading-indicator class="w-6 ms-1"  wire:loading="" />
                </div>
                <div>
                    <x-filament::button onclick="render()">Download</x-filament::button>
                </div>
            </div>
        </x-filament::section.heading>
        @if($html)
            <!-- @copyright All rights reserved (Based on Argon Code Previews) -->
            <div id="code-card-wrapper">
                <section class="code-card">
                    @if($useHeader === 'true')
                        <header>
                            <menu> <button class="red"></button> <button class="yellow"></button> <button class="green"></button> </menu>
                            <h1>
                                @if($label)
                                    {{ $label }}
                                @else
                                    &nbsp; {{-- Space to keep sizing --}}
                                @endif
                            </h1>
                        </header>
                    @endif
                    <article>
                        <main>
                            {!! $html !!}
                        </main>
                    </article>
                </section>
            </div>
        @else
            <x-filament::section.description>
                Your result will show up here
            </x-filament::section.description>
        @endif
    </x-filament::card>
    <button onclick="render()">render</button>

    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script>
        async function downloadImage(data) {
            const link = document.createElement('a');
            link.href = data;
            link.download = "{{ $this->getFilename() }}";
            link.click();
            link.remove();
        }

        function render() {
            const wrapper = document.getElementById('code-card-wrapper');
            html2canvas(wrapper, {
                scale: {{ $scale }}, // Increase DPI (Resolution)
            }).then(canvas => {
                downloadImage(canvas.toDataURL());
            });
        }
    </script>
</x-filament-panels::page>
