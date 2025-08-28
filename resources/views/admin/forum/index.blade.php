<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yönetici Paneli - Forum Gönderileri') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100" x-data="forumPosts()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

                <h3 class="text-2xl font-bold text-gray-900 mb-6">Yönetilen Forumlar</h3>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3 px-6">Başlık</th>
                            <th scope="col" class="py-3 px-6">Yazar</th>
                            <th scope="col" class="py-3 px-6">Oluşturulma Tarihi</th>
                            <th scope="col" class="py-3 px-6">İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($posts as $post)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $post->title }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $post->user->name }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $post->created_at->format('d.m.Y H:i') }}
                                </td>
                                <td class="py-4 px-6 flex space-x-2">
                                    {{-- Düzenle --}}
                                    <a href="{{ route('admin.forum.show', $post->id) }}" class="font-medium text-blue-600 hover:underline">
                                        Düzenle
                                    </a>

                                    <form
                                        id="delete-form-{{ $post->id }}"
                                        {{-- Silme --}}
                                        action="{{ route('admin.forum.destroy', $post->id) }}"
                                        method="POST"
                                        @submit.prevent
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="button"
                                            @click="confirmDelete({{ $post->id }}, '{{ addslashes($post->title) }}')"
                                            class="font-medium text-red-600 hover:underline"
                                        >
                                            Sil
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white">
                                <td colspan="4" class="py-4 px-6 text-center text-gray-600">
                                    Henüz hiç forum gönderisi bulunmamaktadır.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                </div>

                <div
                    x-show="showConfirm"
                    x-transition
                    style="display: none;"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                >
                    <div class="bg-white rounded-lg p-6 w-96 max-w-full shadow-lg">
                        <h2 class="text-lg font-semibold mb-4 text-red-600">Gönderiyi Sil</h2>
                        <p class="mb-6">"<span x-text="deleteTitle"></span>" başlıklı gönderiyi silmek istediğinize emin misiniz?</p>
                        <div class="flex justify-end space-x-4">
                            <button
                                @click="showConfirm = false"
                                class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300"
                            >
                                İptal
                            </button>

                            <button
                                @click="submitDelete()"
                                class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700"
                            >
                                Sil
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>

    <script>
        function forumPosts() {
            return {
                showConfirm: false,
                deleteId: null,
                deleteTitle: '',

                confirmDelete(id, title) {
                    this.deleteId = id;
                    this.deleteTitle = title;
                    this.showConfirm = true;
                },

                submitDelete() {
                    this.showConfirm = false;
                    const form = document.getElementById('delete-form-' + this.deleteId);
                    if (form) form.submit();
                }
            }
        }
    </script>
</x-app-layout>
