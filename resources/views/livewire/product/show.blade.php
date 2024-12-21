<?php

use App\Models\Cart;
use App\Models\Product;
use Livewire\Volt\Component;
use Masmerise\Toaster\Toaster;

new class extends Component {

    public Product $product;

    public function addToBag()
    {
        if (!Auth::check()) {

            Toaster::error('Log in to proceed');

        } else {

            $user = Auth::user();

            $model = Cart::query()
                ->where('user_id', $user->id)
                ->where('product_id', $this->product->id)
                ->first();

            if(!$model)
            {

                $user->carts()->create([
                    'product_id' => $this->product->id,
                    'quantity' => 1,
                    'unit_price' => $this->product->price
                ]);

                Toaster::success('Product added to cart');
            } else {

                Toaster::warning('Product already exists in cart');

            }


        }

    }

    public function with()
    {

        return [
            'product' => $this->product
        ];
    }

}; ?>

<div>
    <div class="bg-white dark:bg-gray-900">
        <div class="max-w-2xl px-4 py-16 mx-auto sm:px-6 sm:py-24 lg:grid lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
          <!-- Product details -->
          <div class="lg:max-w-lg lg:self-end">

            <div class="mt-4">
              <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">{{ $product->name }}</h1>
            </div>

            <section aria-labelledby="information-heading" class="mt-4">
              <h2 id="information-heading" class="sr-only">Product information</h2>

              <div class="flex items-center">
                <p class="text-lg text-gray-900 dark:text-white sm:text-xl">$ {{ $product->price }}</p>
              </div>

              <div class="mt-4 space-y-6">
                <p class="text-base text-gray-500 dark:text-gray-400">
                    {{ $product->description }}
                </p>
              </div>

              <div class="flex items-center mt-6">
                <svg class="text-green-500 size-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                </svg>
                <p class="ml-2 text-sm text-gray-500">In stock and ready to ship</p>
              </div>
            </section>
          </div>

          <!-- Product image -->
          <div class="mt-10 lg:col-start-2 lg:row-span-2 lg:mt-0 lg:self-center">
            <img src="{{ $product->photo() }}" alt="Model wearing light green backpack with black canvas straps and front zipper pouch." class="object-cover w-full rounded-lg aspect-square">
          </div>

          <!-- Product form -->
          <div class="mt-10 lg:col-start-1 lg:row-start-2 lg:max-w-lg lg:self-start">
            <section aria-labelledby="options-heading">
              <h2 id="options-heading" class="sr-only">Product options</h2>

                <div class="mt-10">
                    <button wire:click.prevent='addToBag' class="flex items-center justify-center w-full px-8 py-3 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50 focus:outline-hidden">
                        Add to bag
                    </button>
                </div>
            </section>
          </div>
        </div>
      </div>

</div>
