<?php

use function Pest\Laravel\get;

test('homepage can be rendered', function () {
    get('/')
         ->assertOk()
         ->assertSeeVolt('home');
});

test('cart page can be rendered', function () {
    get('/cart')
         ->assertOk()
         ->assertSeeVolt('cart');
});

test('orders page can be rendered', function () {
    get('/orders')
         ->assertOk()
         ->assertSeeVolt('orders');
});
