<?php

namespace App\Http\Controllers\Shop;

use App\Helpers\PaginationResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Http\Resources\ShopResource;
use App\Models\Brand;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BrandController extends Controller
{
    use ApiResponser;

    const CACHE_TTL_TIME = 60 * 60 * 24 * 5; // 5 days

    const PER_PAGE_ITEMS_COUNT = 20;

    public function all()
    {
        $brands = Cache::remember('shop-brands', self::CACHE_TTL_TIME, function () {
            return Brand::all();
        });

        return $this->successResponse('لیست برندها', BrandResource::collection($brands));
    }

    public function brand(Request $request, $slug): JsonResponse
    {
        $order = $this->getOrder($request);
        $sort = $this->getSort($request);

        $products = Cache::remember('shop-brand-' . $slug . $order . $sort . $request->page ?? '1', self::CACHE_TTL_TIME, function () use ($slug, $order, $sort) {
            $brand = Brand::where('slug', $slug)->orWhere('slug', urlencode($slug))->firstOrFail();
            return $brand->products()->with('brand')->orderBy($order, $sort)->paginate(self::PER_PAGE_ITEMS_COUNT);
        });

        return $this->successResponse('لیست محصولات برند', [
            ...PaginationResource::make($products),
            'products' => ShopResource::collection($products),
        ]);
    }

    private function getOrder(Request $request): string
    {
        $order = $request->get('order', 'created_at');

        // Validate the order and sort parameters
        if (!in_array($order, ['created_at', 'price', 'view_count', 'average_rating', 'total_sales'])) {
            $order = 'created_at';
        }

        return $order;
    }

    private function getSort(Request $request): string
    {
        $sort = $request->get('sort', 'desc');

        if (!in_array($sort, ['asc', 'desc'])) {
            $sort = 'desc';
        }

        return $sort;
    }
}
