<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AddToCartRequest;
use App\Http\Requests\Api\V1\UpdateCartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function user()
    {
        return Auth::user();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = $this->user()
            ->carts()
            ->with('product')
            ->get();

        return CartResource::collection($cart);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddToCartRequest $request)
    {
        $user = $this->user();

        $request->validated();

        $product = Product::find($request->product_id);

        if($product)
        {
            // Add product to cart
            $model = Cart::query()
                ->where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->first();

            if($model) {

                return response()->json([
                    'message' => 'Product already exists in cart'
                ], Response::HTTP_CONFLICT);

            } else {

                $user->carts()->create([
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'unit_price' => $product->price
                ]);

                return response()->json([
                    'message' => 'Product added to cart'
                ], Response::HTTP_CREATED);

            }

        } else {

            return response()->json([
                'message' => 'Product not found'
            ], Response::HTTP_NO_CONTENT);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, string $id)
    {
        $request->validated();

        $item = Cart::find($id);

        if (!$item) {

            return response()->json([
                'message' => 'Cart item not found.',
            ], Response::HTTP_NOT_FOUND);

        }

        if ($item->user_id == $this->user()->id) {
            if ($request->action === 'increment') {

                $item->quantity += 1;

            } elseif ($request->action === 'decrement') {

                if ($item->quantity > 1) {

                    $item->quantity -= 1;

                } else {

                    Cart::find($item->id)->delete();

                    return response()->json([
                        'message' => 'Cart item removed',
                    ], Response::HTTP_OK);

                }
            }
        } else {

            return response()->json([
                'message' => 'Cart item not found',
            ], Response::HTTP_NOT_FOUND);

        }

        $item->save();

        return response()->json([
            'message' => 'Cart item updated successfully.',
            'data' => new CartResource($item)
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
