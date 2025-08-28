<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Forum Gönderisini Düzenle') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Gönderiyi Düzenle</h3>

                {{-- Başarı mesajı --}}
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.forum.update', $post->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-label for="title" :value="__('Başlık')" />
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $post->title)" required autofocus />
                        @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @if ($post->image_path)
                        <div class="mt-4">
                            <x-label :value="__('Mevcut Fotoğraf')" />
                            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Mevcut Fotoğraf" class="mt-2 rounded-lg w-1/3">
                        </div>
                    @endif

                    <div class="mt-4">
                        <x-label for="image" :value="__('Yeni Fotoğraf (mevcudu değiştirmek için)')" />
                        <input id="image" name="image" type="file" accept="image/*" class="block mt-1 w-full" />
                        @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="content" :value="__('İçerik')" />
                        <textarea id="content" name="content" rows="8" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>{{ old('content', $post->content) }}</textarea>
                        @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-button class="ml-4">
                            {{ __('Gönderiyi Güncelle') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
