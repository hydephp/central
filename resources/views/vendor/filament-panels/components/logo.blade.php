@if (filled($brand = filament()->getBrandName()))
    <div
        {{
            $attributes->class([
                'fi-logo text-xl font-bold leading-5 tracking-tight text-gray-950 dark:text-white',
            ])
        }}
    >
        {{ $brand }}
        <sup class="text-white px-1.5 rounded-lg" style="background-color: #22c55e;">Beta</sup>
    </div>
@endif
