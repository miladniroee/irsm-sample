<?php

namespace App\Traits;


use Illuminate\Support\Str;

trait Slug
{
    protected static function makeSlug(string $title, $class): string
    {
        $slug = Str::slug($title);

        $i = 1;
        while ($class::withoutGlobalScopes()
            ->whereSlug($slug)
            ->orWhere('slug', urlencode($slug))
            ->exists()) {
            $slug = Str::slug($title) . '-' . $i;
            $i++;
        }

        return $slug;
    }
}
