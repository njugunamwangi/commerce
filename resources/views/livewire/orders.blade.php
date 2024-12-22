<?php

use Livewire\Volt\Component;

new class extends Component {

    private function user()
    {
        return auth()->user();
    }

    public function with()
    {
        return [
            'orders' => auth()->user() ? $this->user()->orders()->get() : '',
        ];
    }

}; ?>

<div wire:poll.keep-alive>
    @if (auth()->user())
        @if ($orders && $orders->count() > 0)
            <div class="bg-gray-900">
                <div class="mx-auto max-w-7xl">
                <div class="py-10 bg-gray-900">
                    <div class="px-4 sm:px-6 lg:px-8">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold text-white">Order History</h1>
                        </div>
                    </div>
                    <div class="flow-root mt-8">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-700">
                            <thead>
                                <tr>
                                <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-white sm:pl-0">Date</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Amount</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Order Status</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Payment Status</th>
                                <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
                                    <span class="sr-only">Action</span>
                                </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="py-4 pl-4 pr-3 text-sm font-medium text-white whitespace-nowrap sm:pl-0">
                                            {{ $order->created_at }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-300 whitespace-nowrap">$ {{ number_format($order->total, 2) }} </td>
                                        <td class="px-3 py-4 text-sm text-gray-300 whitespace-nowrap"> {{ $order->order_status->getLabel() }} </td>
                                        <td class="px-3 py-4 text-sm text-gray-300 whitespace-nowrap"> {{ $order->payment_status->getLabel() }} </td>
                                        <td class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                            <a href="#" class="text-indigo-400 hover:text-indigo-300">View<span class="sr-only">, view</span></a>
                                        </td>
                                    </tr>
                                @endforeach

                                <!-- More people... -->
                            </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        @else
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            {{ __("No orders") }}
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
                        {{ __("No orders") }}
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
