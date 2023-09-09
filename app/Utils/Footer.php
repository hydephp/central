<?php

namespace App\Utils;

/**
 * Injected into the footer component
 */
class Footer
{
    public function version(): string
    {
        return substr($this->getCachedVersionFromDisk(), 0, 7);
    }

    protected function getCachedVersionFromDisk(): string
    {
        return trim((@file_get_contents(storage_path('interop/VERSION'))) ?: str_repeat('0', 40));
    }
}
