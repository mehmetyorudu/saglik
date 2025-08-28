<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yönetici Paneli - Test Detayı') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100" x-data="deleteConfirm()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $test->title }}</h3>
                        <p class="text-gray-600 mt-2">{{ $test->description }}</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.tests.edit', $test) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                            Testi Düzenle
                        </a>
                        <a href="{{ route('admin.tests.questions.create', $test) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Yeni Soru Ekle
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <hr class="my-8 border-gray-200">

                <h4 class="text-xl font-bold text-gray-900 mb-4">Sorular ({{ $test->questions->count() }})</h4>

                @forelse ($test->questions as $question)
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md border border-gray-200 mb-4">
                        <div class="flex justify-between items-start mb-3">
                            <p class="text-lg font-semibold text-gray-800">{{ $loop->iteration }}. {{ $question->question_text }}</p>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.tests.questions.edit', [$test, $question]) }}" class="font-medium text-blue-600 hover:underline text-sm">Düzenle</a>

                                <!-- Formu data-id ile işaretliyoruz -->
                                <form
                                    action="{{ route('admin.tests.questions.destroy', [$test, $question]) }}"
                                    method="POST"
                                    x-ref="form{{ $question->id }}"
                                    @submit.prevent="openConfirm({{ $question->id }})"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:underline text-sm">Sil</button>
                                </form>
                            </div>
                        </div>

                        <ul class="list-disc ml-6 text-gray-700">
                            @foreach ($question->answers as $answer)
                                <li class="{{ $answer->is_correct ? 'text-green-600 font-medium' : '' }}">
                                    {{ $answer->answer_text }}
                                    @if ($answer->is_correct)
                                        <span class="text-xs text-green-500">(Doğru Cevap)</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @empty
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md border border-gray-200 text-center text-gray-600">
                        Bu testte henüz soru bulunmamaktadır. Yukarıdaki butonu kullanarak ilk soruyu ekleyin.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Onay Modalı -->
        <div
            x-show="showConfirm"
            x-transition
            style="display: none;"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        >
            <div class="bg-white rounded-lg p-6 w-96 max-w-full shadow-lg">
                <h2 class="text-lg font-semibold mb-4 text-red-600">Soruyu Sil</h2>
                <p class="mb-6">Bu soruyu ve tüm cevaplarını silmek istediğinizden emin misiniz?</p>
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

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        function deleteConfirm() {
            return {
                showConfirm: false,
                currentId: null,
                openConfirm(id) {
                    this.currentId = id;
                    this.showConfirm = true;
                },
                submitDelete() {
                    this.showConfirm = false;
                    // Submit ilgili formu
                    this.$refs['form' + this.currentId].submit();
                }
            }
        }
    </script>
</x-app-layout>
