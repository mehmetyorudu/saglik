<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Market') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Ürünlerimiz</h3>

                @if ($products->isEmpty())
                    <div class="text-center text-gray-600">Henüz markette ürün bulunmamaktadır.</div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($products as $product)
                            <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden flex flex-col h-[350px]">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-full h-48 object-cover">
                                @else
                                    <img src="https://placehold.co/600x480/E2E8F0/94A3B8?text=Resim+Yok" alt="Placeholder" class="w-full h-48 object-cover">
                                @endif
                                <div class="p-4 flex flex-col flex-grow justify-between">
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900 truncate">{{ $product->title }}</h4>
                                        <p class="text-gray-600 mt-1 mb-2">{{ number_format($product->calories, 2, ',', '.') }} Kalori</p>
                                    </div>
                                    <a href="{{ route('market.show', $product->id) }}" class="block w-full text-center px-4 py-2 mt-4 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                        Daha fazlasını gör
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
