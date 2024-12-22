<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

test('user can add item to cart', function () {

    $user = User::factory()->create();

    $product = Product::factory()->create();

    $this->actingAs($user);

    $cartItem = $user->carts()->create([
        'product_id' => $product->id,
        'quantity' => 1,
        'unit_price' => $product->price
    ]);

    get(route('cart'))
        ->assertSeeText( $cartItem->product->name);

});
