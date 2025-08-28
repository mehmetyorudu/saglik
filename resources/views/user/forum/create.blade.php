<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yeni Forum Gönderisi') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Yeni Gönderi Oluştur</h3>

                <form method="POST" action="{{ route('forum.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Başlık -->
                    <div>
                        <x-label for="title" :value="__('Başlık')" />
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fotoğraf Yükleme -->
                    <div class="mt-4">
                        <x-label for="image" :value="__('Fotoğraf (isteğe bağlı)')" />
                        <input id="image" name="image" type="file" accept="image/*" class="block mt-1 w-full" />
                        @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- İçerik -->
                    <div class="mt-4">
                        <x-label for="content" :value="__('İçerik')" />
                        <textarea id="content" name="content" rows="8" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>{{ old('content') }}</textarea>
                        @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-button class="ml-4">
                            {{ __('Gönderiyi Oluştur') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
