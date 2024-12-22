<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private function user()
    {
        return Auth::user();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = $this->user()->orders()->get();

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $this->user();

        $cart = $user->carts();

        if($cart->get()->count() > 0)
        {

            $total = 0;

            foreach($cart->get() as $item)
            {
                $total += $item->quantity * $item->unit_price;
            }

            $order = $user->orders()->create([
                'total' => $total
            ]);


            collect($cart->get())->each(function($item) use($order) {

                $order->orderItems()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                ]);

            });

            $cart->delete();

            return response()->json([

                'message' => 'Order created successfully'

            ], Response::HTTP_CREATED);

        } else {

            return response()->json([

                'message' => 'No Items in your cart'

            ], Response::HTTP_BAD_REQUEST);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $order = Order::findOrFail($id);

            return new OrderResource($order);
        } catch(ModelNotFoundException) {

            return response()->json([
                'message' => 'Order Not Found'
            ], Response::HTTP_NOT_FOUND);

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
