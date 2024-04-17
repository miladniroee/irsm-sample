<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCartItemRequest;
use App\Http\Requests\RemoveCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Http\Resources\CartResource;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\User;
use App\Models\Variation;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiResponser;

    private static array $texts = [
        'cart' => 'سبد خرید',
        'cart_item_added' => 'محصول به سبد خرید اضافه شد',
        'cart_item_removed' => 'محصول از سبد خرید حذف شد',
        'cart_item_updated' => 'محصول در سبد خرید بروزرسانی شد',
    ];

    public function cart(Request $request): JsonResponse
    {
        $items = $request->user()->cartItems()->with('variation.product')->get();

        return $this->successResponse(self::$texts['cart'], [
            'cart_items' => CartResource::collection($items),
            'total' => self::getCartTotal($items)
        ]);
    }

    public function add(AddCartItemRequest $request): JsonResponse
    {
        $variation = Variation::find($request->variation_id);


        $request->user()->cartItems()->updateOrCreate([
            'variation_id' => $variation ? $variation->id : null,
        ], [
            'quantity' => $request->quantity,
        ]);

        return $this->successResponse(self::$texts['cart_item_added'], null);
    }

    public function remove(RemoveCartItemRequest $request): JsonResponse
    {
        $request->user()->cartItems()->where([
            'id' => $request->id,
        ])->delete();

        return $this->successResponse(self::$texts['cart_item_removed'], null);
    }

    public function update(UpdateCartItemRequest $request): JsonResponse
    {
        $request->user()->cartItems()->where([
            'id' => $request->id,
        ])->update([
            'quantity' => $request->quantity,
        ]);

        return $this->successResponse(self::$texts['cart_item_updated'], null);
    }

    public static function getCartTotal($cartItems)
    {
        $total = 0;

        foreach ($cartItems as $item):
            $total += $item->total();
        endforeach;

        return $total;
    }

    public static function convertGuestCart($request)
    {
        $productIdsFromVariations = array_column($request->variations, 'id');
        $variations = ProductVariation::whereIn('id', $productIdsFromVariations)->get();

        return $variations->map(function ($variation) use ($request) {
            $filteredProducts = array_filter($request->variations, function ($product1) use ($variation) {
                return array_key_exists('id', $product1) && $product1['id'] == $variation->id;
            });

            $firstProduct = array_values($filteredProducts)[0] ?? null;
            $quantity = $firstProduct['quantity'] ?? 1;


            $cartItem = new CartItem;

            $cartItem->product_id = $variation->product_id;
            $cartItem->quantity = $quantity;
            $cartItem->variation_id = $variation->id;

            return $cartItem;
        });
    }


    /**
     * add or update variations sent in $request to user's cart
     *
     * @param Request $request
     * @return mixed
     */
    public static function sync(Request $request): void
    {
        $variations = ProductVariation::whereIn('id', array_column($request->variations, 'id'))->get();

        // remove everything in cart
        auth('sanctum')->user()->cartItems()->delete();

        $variations->map(function ($variation) use ($request) {
            $filteredProducts = array_filter($request->variations, function ($product1) use ($variation) {
                return array_key_exists('id', $product1) && $product1['id'] == $variation->id;
            });

            $firstProduct = array_values($filteredProducts)[0] ?? null;
            $quantity = $firstProduct['quantity'] ?? 1;

            // check if product is available and in_stock
            if ($variation->product && $variation->in_stock <= 0) {
                return auth('sanctum')->user()->cartItems()->updateOrCreate([
                    'variation_id' => $variation->id,
                ], [
                    'quantity' => $quantity,
                ]);
            } else {
                return false;
            }
        });

    }
}
