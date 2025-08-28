<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yönetici Paneli - Yeni Makale Ekle') }}
        </h2>
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Yeni Makale Oluştur</h3>

                <form id="article-form" method="POST" action="{{ route('admin.articles.store') }}">
                    @csrf

                    <!-- Başlık -->
                    <div>
                        <x-label for="title" :value="__('Başlık')" />
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- İçerik -->
                    <div class="mt-4">
                        <x-label for="content" :value="__('İçerik')" />
                        <textarea id="content" name="content" style="display: none;">{{ old('content') }}</textarea>
                        <div id="editor" class="rounded-md shadow-sm border-gray-300 block mt-1 w-full bg-white" style="min-height: 300px;">{{ old('content') }}</div>
                        @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-button class="ml-4">
                            {{ __('Makaleyi Kaydet') }}
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

                    document.getElementById('article-form').addEventListener('submit', function () {
                        document.getElementById('content').value = quill.root.innerHTML;
                    });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
