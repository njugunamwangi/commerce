<?php

use App\Models\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

test('user can view product', function () {

    $product = Product::factory()->create();

    get(route('home'))
        ->assertSee(value: $product->name);

});
