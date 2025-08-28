<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ürün Detayı') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-4">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-full max-h-72 object-cover rounded mb-4">
                @endif

                <h3 class="text-2xl font-bold text-gray-900">{{ $product->title }}</h3>
                <p class="text-gray-700 text-lg mt-2 mb-4">{{ number_format($product->calories, 2, ',', '.') }} Kalori</p>
                <div class="prose max-w-none text-gray-800">
                    {!! $product->description !!}
                </div>
                    <a href="{{ route('market.index') }}" class="block w-full text-center px-4 py-2 mt-4 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                        Geri Dön
                    </a>
            </div>
        </div>
    </div>
</x-app-layout>
