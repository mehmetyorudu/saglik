<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yönetici Paneli - Test Sonuçları') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100" x-data="attemptList()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">"{{ $test->title }}" Testinin Sonuçları</h3>

                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="text-xs uppercase bg-gray-100 border-b border-gray-300">
                        <tr>
                            <th class="py-3 px-6">Kullanıcı Adı</th>
                            <th class="py-3 px-6">Doğru Cevap</th>
                            <th class="py-3 px-6">Yanlış Cevap</th>
                            <th class="py-3 px-6">Toplam Soru</th>
                            <th class="py-3 px-6">Deneme Tarihi</th>
                            <th class="py-3 px-6">İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($attempts as $attempt)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <th class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $attempt->user->name }}
                                </th>
                                <td class="py-4 px-6 text-green-600 font-semibold">{{ $attempt->correct_answers }}</td>
                                <td class="py-4 px-6 text-red-600 font-semibold">{{ $attempt->incorrect_answers }}</td>
                                <td class="py-4 px-6">{{ $attempt->total_questions }}</td>
                                <td class="py-4 px-6">{{ $attempt->attempt_date->format('d.m.Y H:i') }}</td>
                                <td class="py-4 px-6 flex space-x-2">
                                    <a href="{{ route('admin.tests.attempt_detail', $attempt) }}" class="font-medium text-indigo-600 hover:underline">Görüntüle</a>

                                    <!-- Sil Butonu ve Form -->
                                    <form
                                        id="delete-form-{{ $attempt->id }}"
                                        action="{{ route('admin.tests.attempt_delete', $attempt) }}"
                                        method="POST"
                                        @submit.prevent
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="button"
                                            @click="confirmDelete({{ $attempt->id }}, '{{ addslashes($attempt->user->name) }}')"
                                            class="font-medium text-red-600 hover:underline"
                                        >
                                            Sil
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 px-6 text-center text-gray-500">
                                    Bu test için henüz bir deneme bulunmamaktadır.
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
                <h2 class="text-lg font-semibold mb-4 text-red-600">Denemeyi Sil</h2>
                <p class="mb-6">"<span x-text="deleteTitle"></span>" adlı denemeyi silmek istediğinize emin misiniz? Bu işlem geri alınamaz.</p>
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
        function attemptList() {
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
