<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PaginationResource
{
    public static function links(LengthAwarePaginator $collection): array
    {
        $queryParams = request()->query();
        unset($queryParams['page']);

        return [
            'first' => $collection->appends($queryParams)->url(1),
            'last' => $collection->appends($queryParams)->url($collection->lastPage()),
            'prev' => $collection->appends($queryParams)->previousPageUrl(),
            'next' => $collection->appends($queryParams)->nextPageUrl(),
        ];
    }

    public static function meta(LengthAwarePaginator $collection, array $meta = []): array
    {

        return [
            'current_page' => $collection->currentPage(),
            'last_page' => $collection->lastPage(),
            'total' => $collection->total(),
            ...$meta
        ];
    }


    public static function make(LengthAwarePaginator $collection, array $meta = []): array
    {
        return [
            'links' => self::links($collection),
            'meta' => self::meta($collection, $meta),
        ];
    }
}
