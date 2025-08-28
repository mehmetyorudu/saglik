<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yönetici Paneli - Ürünü Düzenle') }}
        </h2>
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <form id="product-form" action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Başlık -->
                    <div class="mb-4">
                        <x-label for="title" :value="__('Başlık')" />
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $product->title)" required autofocus />
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Ürün Fotoğrafı -->
                    <div class="mb-4">
                        <x-label for="image" :value="__('Mevcut Ürün Fotoğrafı')" />
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-32 h-32 object-cover rounded-md mb-2">
                        @endif
                        <input id="image" class="block mt-1 w-full" type="file" name="image" />
                        @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Kalori -->
                    <div class="mb-4">
                        <x-label for="calories" :value="__('Kalori')" />
                        <x-input id="calories" class="block mt-1 w-full" type="number" step="0.01" name="calories" :value="old('calories', $product->calories)" required />
                        @error('calories') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Açıklama -->
                    <div class="mb-4">
                        <x-label for="description" :value="__('Açıklama (Resim/Video Eklenebilir)')" />
                        <textarea name="description" id="description" style="display: none;">{{ old('description', $product->description) }}</textarea>
                        <div id="editor" class="rounded-md shadow-sm border-gray-300 block mt-1 w-full bg-white" style="min-height: 200px;"></div>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Güncelle Butonu -->
                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Güncelle') }}
                        </x-button>
                    </div>
                </form>

                <!-- Quill JS -->
                <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
                <script>
                    var quill = new Quill('#editor', {
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                ['bold', 'italic', 'underline', 'strike'],
                                ['blockquote', 'code-block'],
                                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                                [{ 'color': [] }, { 'background': [] }],
                                ['link', 'image', 'video'],
                                ['clean']
                            ]
                        }
                    });

                    document.addEventListener('DOMContentLoaded', function () {
                        const form = document.getElementById('product-form');
                        form.addEventListener('submit', function () {
                            const html = quill.root.innerHTML;
                            document.getElementById('description').value = html;
                            console.log("Gönderilen açıklama:", html);
                        });

                        const oldContent = document.getElementById('description').value;
                        if (oldContent) {
                            quill.root.innerHTML = oldContent;
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
