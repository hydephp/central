<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot:heading>
            Upcoming Features
            <small class="opacity-70">
                ({{ count($features) }})
            </small>
        </x-slot:heading>
        @if($failedToLoad)
            <x-filament::section.description>
                Failed to load upcoming features.
            </x-filament::section.description>
        @else
            <x-filament::section.description>
                <style>
                    .features-table {
                        width: 100%;
                        max-width: 100%;
                    }
                    .features-table th  {
                        max-width: 95%;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                        display: block;
                    }
                    .features-table code::before, .features-table code::after {
                        content: none;
                    }
                </style>
                <div class="features-table prose dark:prose-invert">
                    <table>
                        <tbody>
                        @php /** @var $features array<int, object{title: string, url: string, id: int, created_at: string, is_open: bool, merged: bool}> */ @endphp
                        @foreach($features as $feature)
                            <tr>
                                <td>
                                    <a href="{{ $feature->url }}" target="_blank" rel="noopener noreferrer nofollow">
                                        <code>#{{ $feature->id }}</code>
                                    </a>
                                </td>
                                <th title="{{ $feature->title }}">
                                    {{ $feature->title }}
                                </th>
                                <td>
                                    <span style="{{ $feature->merged ? 'opacity: 75%' : ($feature->is_open ? 'color: #4caf50' : 'color: #f44336') }}">
                                        {{ $feature->merged ? 'Merged' : ($feature->is_open ? 'Open' : 'Closed') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </x-filament::section.description>
            <hr class="max-w-4xl opacity-50 my-2">
            <small class="opacity-70">
                These features are in the works of the next release of HydePHP. Please note that these features are in development, and thus subject to any change or even removal.
            </small>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
