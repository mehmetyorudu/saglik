<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Forum Gönderisini Yönet') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100" x-data="deleteHandler()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">

                {{-- Fotoğraf ve İçerik için kapsayıcı --}}
                <div class="flex flex-col md:flex-row mb-8 items-start">

                    {{-- Fotoğraf --}}
                    @if ($post->image_path)
                        <div class="mb-6 md:mb-0 md:mr-6 flex-shrink-0">
                            <img src="{{ asset('storage/' . $post->image_path) }}"
                                 alt="Forum Görseli"
                                 style="width:500px; height:400px; object-fit:cover; border-radius:6px;"
                                 class="shadow-sm">
                        </div>
                    @endif

                    {{-- İçerik Bölümü --}}
                    <div class="prose max-w-none text-gray-800">
                        <h3 class="text-3xl font-bold mb-4">{{ $post->title }}</h3>
                        <p class="text-gray-700 mb-2">{{ $post->content }}</p>
                        <p class="text-sm text-gray-500 mb-6">
                            Yazan: {{ $post->user->name }} - {{ $post->created_at->format('d.m.Y H:i') }}
                        </p>

                        {{-- Düzenle ve Sil butonları --}}
                        <div class="flex items-center mb-4">
                            <a href="{{ route('admin.forum.edit', $post->id) }}" class="text-blue-600 hover:underline text-sm mr-4">
                                Gönderiyi Düzenle
                            </a>
                            <form id="delete-form-post-{{ $post->id }}"
                                  action="{{ route('admin.forum.destroy', $post->id) }}"
                                  method="POST" @submit.prevent>
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        @click="confirmDelete('delete-form-post-{{ $post->id }}', '{{ addslashes($post->title) }}')"
                                        class="text-red-600 hover:underline text-sm">
                                    Gönderiyi Sil
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <hr class="my-6">

                <h4 class="text-2xl font-semibold mb-4">Yorumlar ({{ $post->comments->count() }})</h4>

                @forelse ($post->comments as $comment)
                    <div class="bg-gray-50 p-4 rounded-lg shadow mb-4 border border-gray-200">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold">{{ $comment->user->name }}</span>
                            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="mb-2">{{ $comment->content }}</p>

                        <form id="delete-form-comment-{{ $comment->id }}"
                              action="{{ route('admin.comments.destroy', $comment->id) }}"
                              method="POST" @submit.prevent>
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                    @click="confirmDelete('delete-form-comment-{{ $comment->id }}', 'Yorum')"
                                    class="text-red-600 hover:underline text-sm">
                                Yorumu Sil
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-600">Bu gönderiye ait hiç yorum yok.</p>
                @endforelse
            </div>
        </div>

        <div x-show="showConfirm"
             x-transition
             style="display: none;"
             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-96 max-w-full shadow-lg">
                <h2 class="text-lg font-semibold mb-4 text-red-600">Silme Onayı</h2>
                <p class="mb-6">
                    "<span x-text="deleteTitle"></span>" başlıklı öğeyi silmek istediğinize emin misiniz?
                </p>
                <div class="flex justify-end space-x-4">
                    <button @click="showConfirm = false"
                            class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">
                        İptal
                    </button>
                    <button @click="submitDelete()"
                            class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">
                        Sil
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        function deleteHandler() {
            return {
                showConfirm: false,
                deleteFormId: '',
                deleteTitle: '',
                confirmDelete(formId, title) {
                    this.deleteFormId = formId;
                    this.deleteTitle = title;
                    this.showConfirm = true;
                },
                submitDelete() {
                    this.showConfirm = false;
                    document.getElementById(this.deleteFormId)?.submit();
                }
            }
        }
    </script>
</x-app-layout>
