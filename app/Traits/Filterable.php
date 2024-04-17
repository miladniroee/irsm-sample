<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait Filterable
{
    public function getOrder(Request $request): string
    {
        $order = $request->get('order', 'created_at');

        // Validate the order and sort parameters
        if (!in_array($order, ['created_at', 'price', 'view_count', 'average_rating', 'total_sales'])) {
            $order = 'created_at';
        }

        return $order;
    }

    public function getSort(Request $request): string
    {
        $sort = $request->get('sort', 'desc');

        if (!in_array($sort, ['asc', 'desc'])) {
            $sort = 'desc';
        }

        return $sort;
    }
}
