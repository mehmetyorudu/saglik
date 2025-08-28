<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Doktor Paneli - Makalelerim') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100" x-data="articleList()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Makalelerim</h3>
                    <a href="{{ route('doctor.articles.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Yeni Makale Ekle
                    </a>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm table-fixed border-collapse border border-gray-200">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="py-3 px-6 text-left w-1/2">Başlık</th>
                            <th class="py-3 px-6 text-center w-1/4">Oluşturulma Tarihi</th>
                            <th class="py-3 px-6 text-right w-1/4">İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($articles as $article)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="py-4 px-6 text-left truncate">{{ $article->title }}</td>
                                <td class="py-4 px-6 text-center">{{ $article->created_at->format('d.m.Y H:i') }}</td>
                                <td class="py-4 px-6 text-right">
                                    <div class="inline-flex space-x-2">
                                        <a href="{{ route('doctor.articles.edit', $article) }}" class="font-medium text-blue-600 hover:underline">Düzenle</a>
                                        <form id="delete-form-{{ $article->id }}" action="{{ route('doctor.articles.destroy', $article) }}" method="POST" @submit.prevent>
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" @click="confirmDelete({{ $article->id }}, '{{ addslashes($article->title) }}')" class="font-medium text-red-600 hover:underline">
                                                Sil
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white">
                                <td colspan="3" class="py-4 px-6 text-center text-gray-600">Henüz hiç makale bulunmamaktadır.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Silme Onay Modalı -->
        <div x-show="showConfirm" x-transition style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-96 max-w-full shadow-lg">
                <h2 class="text-lg font-semibold mb-4 text-red-600">Makaleyi Sil</h2>
                <p class="mb-6">"<span x-text="deleteTitle"></span>" başlıklı makaleyi silmek istediğinize emin misiniz?</p>
                <div class="flex justify-end space-x-4">
                    <button @click="showConfirm = false" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">İptal</button>
                    <button @click="submitDelete()" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Sil</button>
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
