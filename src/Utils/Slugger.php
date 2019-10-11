<?php

namespace App\Utils;

/**
 * @author CE <ce@europa.eu>
 */
final class Slugger
{
    public function sluggify(string $toSlug): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $toSlug)));
    }
}
