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
                and abide by GitHub's terms of service. Also note that generally these files are the originals, and are not minified or optimized for web use.
            </li>
        </ul>
        </article>
    </x-filament::card>

    <x-filament::card>
        <header class="flex justify-between mb-4">
            <h2>
                @if($this->loaded)
                    <strong>All media files</strong>
                    <small>({{ count($this->items) }} total)</small>
                @else
                    <strong>Loading media files...</strong>
                @endif
            </h2>
            <form class="flex text-sm items-center">
                <label for="gridSizeInput" class="me-1">Grid size</label>
                <input id="gridSizeInput" type="range" min="1" max="9" value="3" title="3 columns" oninput="setGridSize()">
            </form>
        </header>
        <section class="grid grid-cols-3 gap-4" id="mediaGrid">
            @if(! $this->loaded)
                {{-- Credit https://flowbite.com/docs/components/spinner/ --}}
                <div role="status" wire:init="mountItems">
                    <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            @endif

            @foreach($this->items as $item)
                <figure class="border dark:border-gray-600 rounded-xl flex flex-col">
                    <img src="{{ $item->download }}" alt="{{ $item->name }}" class="p-4 cursor-pointer" loading="lazy" onclick="window.open('{{ $item->link }}')" title="View on GitHub">
                    <figcaption class="p-4 border-t dark:border-gray-600 prose dark:prose-invert">
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
