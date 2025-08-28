<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Makale') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <h3 class="text-3xl font-bold text-gray-900 mb-4">{{ $article->title }}</h3>
                <p class="text-sm text-gray-600 mb-6">
                    Yazan: <span class="font-semibold">{{ $article->user->name }}</span> - {{ $article->created_at->diffForHumans() }}
                </p>
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <div class="prose max-w-none text-gray-800">
                        {{-- Makale içeriğini HTML olarak render et --}}
                        {!! $article->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
