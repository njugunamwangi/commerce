<?php

use App\Models\Product;
use Livewire\Volt\Component;

new class extends Component {

    public function with(): array
    {
        return [
            'products' => Product::all()
        ];
    }

}; ?>

<div wire:poll.keep-alive>
    <div class="bg-white dark:bg-gray-900">
        <div class="max-w-2xl px-4 py-16 mx-auto sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
          <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Products</h2>

          <div class="grid grid-cols-1 mt-6 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">

            @foreach ($products as $product)

                <div class="relative group">
                    <a wire:navigate href="{{ route('product.show', $product) }}">
                        <img src="{{ $product->photo() }}"
                        alt="Front of men&#039;s Basic Tee in black."
                        class="object-cover w-full bg-gray-200 rounded-md aspect-square group-hover:opacity-75 lg:aspect-auto lg:h-80">
                    </a>
                    <div class="flex justify-between mt-4">
                        <div>
                        <p class="mt-1 text-sm text-gray-500 dark:text-white">{{ $product->name }}</p>
                        </div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">$ {{ $product->price }} </p>
                    </div>
                </div>

            @endforeach

          </div>
        </div>
      </div>

</div>
