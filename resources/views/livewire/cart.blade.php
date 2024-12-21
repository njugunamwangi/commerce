<?php

use Livewire\Volt\Component;

new class extends Component {

    public $subTotal = 0;

    private function user()
    {
        return auth()->user();
    }

    public function decrementQuantity($cartId): void
    {
        $model = $this->user()->carts()->where('id', $cartId)->first();

        if ($model->quantity > 1) {
            $model->decrement('quantity');
            Toaster::success('Product decreased');
        }

    }

    public function incrementQuantity($cartId): void
    {
        $model = $this->user()->carts()->where('id', $cartId)->first();

        if ($model) {
            $model->increment('quantity');
            Toaster::success('Product increased');
        }
    }

    public function placeOrder()
    {
        $user = $this->user();

        $cart = $this->user()->carts();

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

        Toaster::success('Order placed successfully');

        return redirect()->to('orders');
    }

    public function removeItem($cartId)
    {
        $model = $this->user()->carts()->where('id', $cartId)->first();

        if($model)
        {
            $model->delete();
            Toaster::warning('Product removed from cart');

        }
    }

    public function with()
    {
        return [
            'cart' => auth()->user() ? $this->user()->carts()->get() : '',
        ];

    }

}; ?>

<div>
    @if (auth()->user())
        @if ($cart && $cart->count() > 0)
            <div class="bg-white dark:bg-gray-900">
                <div class="max-w-2xl px-4 pt-16 pb-24 mx-auto sm:px-6 lg:max-w-7xl lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Shopping Cart</h1>
                <form class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
                    <section aria-labelledby="cart-heading" class="lg:col-span-7">
                    <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>

                    <ul role="list" class="border-t border-b border-gray-200 divide-y divide-gray-200">
                        @foreach ($cart as $item)
                            <li class="flex py-6 sm:py-10">
                            <div class="shrink-0">
                                <img src="{{ $item->product->photo() }}" alt="Front of men&#039;s Basic Tee in sienna." class="object-cover rounded-md size-24 sm:size-48">
                            </div>

                            <div class="flex flex-col justify-between flex-1 ml-4 sm:ml-6">
                                <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                <div>
                                    <div class="flex justify-between">
                                        <h3 class="text-sm">
                                            <a href="{{ route('product.show', $item->product) }}" class="font-medium text-gray-700 dark:text-white hover:text-gray-800">{{ $item->product->name }}</a>
                                        </h3>
                                    </div>
                                    <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">$ {{ $item->unit_price }}</p>
                                </div>

                                <div class="mt-4 sm:mt-0 sm:pr-9">
                                    <div class="flex justify-between mt-4 sm:mt-0 sm:pr-9">
                                        <label for="quantity-0" class="sr-only">{{ $item->product->product }}</label>
                                        <div class="flex flex-row h-8 ">
                                            <button
                                                wire:click.prevent="decrementQuantity({{ $item->id }})"
                                                wire:loading.attr="disabled"
                                                type="button"
                                                class="inline-flex items-center px-2 py-2 -ml-px text-gray-400 bg-white rounded-l-md ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10">
                                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 256 256" xml:space="preserve">
                                                    <defs>
                                                    </defs>
                                                    <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
                                                        <path d="M 88.616 46.384 H 1.583 c -0.82 0 -1.484 -0.664 -1.484 -1.483 s 0.664 -1.484 1.484 -1.484 h 87.033 c 0.819 0 1.484 0.664 1.484 1.484 S 89.435 46.384 88.616 46.384 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                                    </g>
                                                </svg>
                                            </button>

                                            <input disabled value="{{ $item->quantity }}" class="w-16 border border-gray-300 py-1.5 text-center text-base font-medium leading-5 text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm" />

                                            <button
                                                wire:click.prevent="incrementQuantity({{ $item->id }})"
                                                wire:loading.attr="disabled"
                                                type="button"
                                                class="inline-flex items-center px-2 py-2 text-gray-400 bg-white rounded-r-md ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10">
                                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 256 256" xml:space="preserve">
                                                    <defs>
                                                    </defs>
                                                    <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
                                                        <path d="M 88.516 43.517 H 46.484 V 1.484 C 46.484 0.664 45.819 0 45 0 s -1.484 0.664 -1.484 1.484 v 42.033 H 1.484 C 0.664 43.517 0 44.181 0 45 s 0.664 1.483 1.484 1.483 h 42.033 v 42.033 C 43.516 89.335 44.18 90 45 90 s 1.484 -0.664 1.484 -1.484 V 46.483 h 42.033 C 89.336 46.483 90 45.82 90 45 S 89.336 43.517 88.516 43.517 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                                    </g>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="absolute top-0 right-0">
                                        <button wire:click.prevent='removeItem({{ $item->id }})' type="button" class="inline-flex p-2 -m-2 text-gray-400 hover:text-gray-500">
                                            <span class="sr-only">Remove</span>
                                            <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                            <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                </div>

                                <p class="flex mt-4 space-x-2 text-sm text-gray-700 dark:text-gray-400">
                                <svg class="text-green-500 size-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                </svg>
                                <span>In stock</span>
                                </p>
                            </div>
                            </li>
                            @php $subTotal += $item->unit_price * $item->quantity @endphp
                        @endforeach

                    </ul>
                    </section>

                    <!-- Order summary -->
                    <section aria-labelledby="summary-heading" class="px-4 py-6 mt-16 rounded-lg bg-gray-50 sm:p-6 lg:col-span-5 lg:mt-0 lg:p-8">
                    <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Order summary</h2>

                    <dl class="mt-6 space-y-4">
                        <div class="flex items-center justify-between">
                        <dt class="text-sm text-gray-600">Subtotal</dt>
                        <dd class="text-sm font-medium text-gray-900">$ {{ number_format($subTotal) }}</dd>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <dt class="flex items-center text-sm text-gray-600">
                            <span>Shipping estimate</span>
                            <a href="#" class="ml-2 text-gray-400 shrink-0 hover:text-gray-500">
                            <span class="sr-only">Learn more about how shipping is calculated</span>
                            <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0ZM8.94 6.94a.75.75 0 1 1-1.061-1.061 3 3 0 1 1 2.871 5.026v.345a.75.75 0 0 1-1.5 0v-.5c0-.72.57-1.172 1.081-1.287A1.5 1.5 0 1 0 8.94 6.94ZM10 15a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                            </svg>
                            </a>
                        </dt>
                        <dd class="text-sm font-medium text-gray-900">$0</dd>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <dt class="flex text-sm text-gray-600">
                            <span>Tax estimate</span>
                            <a href="#" class="ml-2 text-gray-400 shrink-0 hover:text-gray-500">
                            <span class="sr-only">Learn more about how tax is calculated</span>
                            <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0ZM8.94 6.94a.75.75 0 1 1-1.061-1.061 3 3 0 1 1 2.871 5.026v.345a.75.75 0 0 1-1.5 0v-.5c0-.72.57-1.172 1.081-1.287A1.5 1.5 0 1 0 8.94 6.94ZM10 15a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                            </svg>
                            </a>
                        </dt>
                        <dd class="text-sm font-medium text-gray-900">$0</dd>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <dt class="text-base font-medium text-gray-900">Order total</dt>
                        <dd class="text-base font-medium text-gray-900">$ {{ number_format($subTotal) }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6">
                        <button wire:click.prevent="placeOrder" class="w-full px-4 py-3 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-xs hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50 focus:outline-hidden">
                            Place Order
                        </button>
                    </div>
                    </section>
                </form>
                </div>
            </div>

        @else
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            {{ __("No items in your cart") }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("No items in the cart cart") }}
                    </div>
                </div>
            </div>
        </div>
    @endif


</div>
