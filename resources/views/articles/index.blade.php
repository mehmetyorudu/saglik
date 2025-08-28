<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Makaleler') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Makaleler</h3>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @forelse ($articles as $article)
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md border border-gray-200 mb-4">
                        <h4 class="text-xl font-semibold text-gray-800 mb-2">
                            <a href="{{ route('articles.show', $article->id) }}" class="text-indigo-600 hover:text-indigo-800">
                                {{ $article->title }}
                            </a>
                        </h4>
                        <p class="text-gray-700 text-sm mb-3">
                            {{ Str::limit(strip_tags($article->content), 150) }}
                        </p>
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span>Yazan: {{ $article->user->name ?? 'Bilinmiyor' }}</span>

                            <span>{{ $article->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md border border-gray-200 text-center text-gray-600">
                        Henüz hiç makale bulunmamaktadır.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
