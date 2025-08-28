<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yönetici Paneli - Makaleler') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100" x-data="articleList()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Yönetilen Makaleler</h3>
                    <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Yeni Makale Ekle
                    </a>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                Başlık
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Yazar
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Oluşturulma Tarihi
                            </th>
                            <th scope="col" class="py-3 px-6">
                                İşlemler
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($articles as $article)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $article->title }}
                                </th>
                                <td class="py-4 px-6">
                                    {{ $article->user->name }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $article->created_at->format('d.m.Y H:i') }}
                                </td>
                                <td class="py-4 px-6 flex space-x-2">
                                    <a href="{{ route('admin.articles.edit', $article) }}" class="font-medium text-blue-600 hover:underline">Düzenle</a>

                                    <form
                                        id="delete-form-{{ $article->id }}"
                                        action="{{ route('admin.articles.destroy', $article) }}"
                                        method="POST"
                                        @submit.prevent
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="button"
                                            @click="confirmDelete({{ $article->id }}, '{{ addslashes($article->title) }}')"
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
                                    Henüz hiç makale bulunmamaktadır.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Silme Onay Modalı -->
        <div
            x-show="showConfirm"
            x-transition
            style="display: none;"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        >
            <div class="bg-white rounded-lg p-6 w-96 max-w-full shadow-lg">
                <h2 class="text-lg font-semibold mb-4 text-red-600">Makaleyi Sil</h2>
                <p class="mb-6">"<span x-text="deleteTitle"></span>" başlıklı makaleyi silmek istediğinize emin misiniz?</p>
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

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <script>
        function articleList() {
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
