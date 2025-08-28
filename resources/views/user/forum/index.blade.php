<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Forum') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Forum Gönderileri</h3>
                    <a href="{{ route('forum.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Yeni Gönderi Oluştur
                    </a>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @forelse ($posts as $post)
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md border border-gray-200 mb-4">
                        <h4 class="text-xl font-semibold text-gray-800 mb-2">
                            <a href="{{ route('forum.show', $post) }}" class="text-indigo-600 hover:text-indigo-800">
                                {{ $post->title }}
                            </a>
                        </h4>

                        {{-- Fotoğraf varsa göster --}}
                        @if ($post->image_path)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $post->image_path) }}"
                                     alt="Forum Görseli"
                                     style="width:300px; height:200px; object-fit:cover; border-radius:6px;"
                                     class="shadow-sm">
                            </div>
                        @endif

                        <p class="text-gray-700 text-sm mb-3">
                            {{ Str::limit($post->content, 150) }}
                        </p>
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span>
                                Yazan: {{ $post->user->name }}
                                @if ($post->user->doctor)
                                    - {{ $post->user->doctor->specialty }}
                                @endif
                            </span>
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md border border-gray-200 text-center text-gray-600">
                        Henüz hiç forum gönderisi bulunmamaktadır. İlk gönderiyi sen oluştur!
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
