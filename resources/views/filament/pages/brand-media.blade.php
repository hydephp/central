<x-filament-panels::page>
    <x-filament::card>
        <article class="prose dark:prose-invert max-w-full">

        <p class="mb-2">
            <strong>Welcome to the HydePHP Brand Asset Media Library.</strong>
            This page will give you quick access to our brand assets.
        </p>

        <ul class="text-sm mt-0 max-w-2xl">
            <li>
                <strong>Terms and Information</strong>
            </li>
            <li>
                To contribute to the assets, please do so through the
                <x-filament::link href="https://github.com/hydephp/hydephp/tree/master/assets" rel="nofollow noopener noreferer" target="_blank" style="margin: 0;">
                    GitHub repository
                </x-filament::link>
                which this page proxies.
            </li>
            <li>
                Please use common sense and respect when using these assets.
                You may not use our logo or brand name in any way that suggests an endorsement or affiliation.
                As long as you use the assets in good faith, we won't be needing any annoying and complex terms of service.
            </li>
            <li>
                By using these assets you agree to the information on our
                <x-filament::link href="https://hydephp.com/legal" rel="nofollow" target="_blank" style="margin: 0;">
                    Legal information
                </x-filament::link>
                page.
            </li>
            <li>
                Remember that the filenames may change, so if you are hotlinking,
                make sure to include the commit hash to get a permanent URL,
                and abide by GitHub's terms of service.
            </li>
        </ul>
        </article>
    </x-filament::card>

    <x-filament::card>
        <header class="flex justify-between mb-4">
            <h2>
                <strong>All media files</strong>
                <small>({{ count($this->getItems()) }} total)</small>
            </h2>
            <form class="flex text-sm items-center">
                <label for="gridSizeInput" class="me-1">Grid size</label>
                <input id="gridSizeInput" type="range" min="1" max="9" value="3" title="3 columns" oninput="setGridSize()">
            </form>
        </header>
        <section class="grid grid-cols-3 gap-4" id="mediaGrid">

            @foreach($this->getItems() as $item)
                <figure class="border rounded-xl flex flex-col">
                    <img src="{{ $item->download }}" alt="{{ $item->name }}" class="p-4 cursor-pointer" loading="lazy" onclick="window.open('{{ $item->link }}')" title="View on GitHub">
                    <figcaption class="p-4 border-t prose dark:prose-invert">
                        <div>
                            <strong>{{ $item->name }}</strong>
                            <small class="opacity-70">({{ \Illuminate\Support\Str::bytesToHuman($item->size) }})</small>
                        </div>
                        <div class="text-sm">
                            <a href="{{ $item->link }}" target="_blank" rel="noopener noreferrer nofollow">View on GitHub</a>
                            &nbsp;
                            <a href="{{ $item->download }}" target="_blank" rel="noopener noreferrer nofollow">Download</a>
                        </div>
                    </figcaption>
                </figure>
            @endforeach
            <script>
                function setGridSize(customSize = null) {
                    const grid = document.getElementById('mediaGrid');
                    const input = document.getElementById('gridSizeInput');
                    let size = customSize ?? input.value;

                    input.title = `${size} columns`;
                    grid.style.gridTemplateColumns = `repeat(${size},minmax(0,1fr))`;

                    if (size > 5) {
                        grid.classList.remove('gap-4');
                        grid.classList.add('gap-2');
                    } else {
                        grid.classList.add('gap-4');
                        grid.classList.remove('gap-2');
                    }

                    // Store preferred size in local storage
                    localStorage.setItem('brandMediaGridSize', size);
                }

                // Load preferred size from local storage
                let preferredSize = localStorage.getItem('brandMediaGridSize');
                if (preferredSize) {
                    document.getElementById('gridSizeInput').value = preferredSize;
                    setGridSize(preferredSize);
                }
            </script>
        </section>
    </x-filament::card>
</x-filament-panels::page>
