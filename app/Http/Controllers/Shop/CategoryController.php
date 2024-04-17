<?php

namespace App\Http\Controllers\Shop;

use App\Helpers\PaginationResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ShopResource;
use App\Models\Category;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    use ApiResponser;

    const CACHE_TTL_TIME = 60 * 60 * 24 * 5; // 5 days

    const PER_PAGE_ITEMS_COUNT = 20;
    public function all(Request $request): \Illuminate\Http\JsonResponse
    {
        $dimensions = $request->get('d',false);

        if (!$dimensions) {
            $categories = Cache::remember('categories', self::CACHE_TTL_TIME, function () {
                return Category::shop()->get();
            });
        } else {
            $categories = Cache::remember('categories-d', self::CACHE_TTL_TIME, function () {
                return Category::shop()->with('children')->where('parent_id',null)->get();
            });
        }

        return $this->successResponse('دسته بندی ها', CategoryResource::collection($categories));
    }

    public function category(Request $request, $slug): JsonResponse
    {
        $order = $this->getOrder($request);
        $sort = $this->getSort($request);

        $products = Cache::remember('shop-category-' . $slug . $order . $sort . $request->page ?? '1', self::CACHE_TTL_TIME, function () use ($slug, $order, $sort) {
            $category = Category::shop()->where('slug', $slug)->orWhere('slug', urlencode($slug))->firstOrFail();
            return $category->products()->with('brand')->orderBy($order, $sort)->paginate(self::PER_PAGE_ITEMS_COUNT);
        });

        return $this->successResponse('لیست محصولات دسته بندی', [
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
