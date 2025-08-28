<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yönetici Paneli - Soru Ekle') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">"{{ $test->title }}" Testine Soru Ekle</h3>

                <form method="POST" action="{{ route('admin.tests.questions.store', $test) }}">
                    @csrf

                    <!-- Soru Metni -->
                    <div>
                        <x-label for="question_text" :value="__('Soru Metni')" />
                        <textarea id="question_text" name="question_text" rows="4" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>{{ old('question_text') }}</textarea>
                        @error('question_text')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cevaplar (4 Şık) -->
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-3">Cevap Seçenekleri (Tam 4 Şık)</h4>
                        <div id="answers-container">
                            @for ($i = 0; $i < 4; $i++)
                                <div class="flex items-center space-x-2 mb-3 answer-item">
                                    <input type="radio" name="correct_answer" value="{{ $i }}" class="form-radio text-indigo-600" {{ old('correct_answer') == $i ? 'checked' : '' }} required>
                                    <input type="text" name="answers[{{ $i }}][text]" placeholder="Cevap {{ $i + 1 }}" class="flex-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('answers.' . $i . '.text') }}" required />
                                </div>
                            @endfor
                        </div>
                        @error('answers')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        @error('answers.*.text')
                        <p class="text-red-500 text-xs mt-1">Tüm cevap alanları dolu olmalıdır.</p>
                        @enderror
                        @error('correct_answer')
                        <p class="text-red-500 text-xs mt-1">Lütfen doğru cevabı seçin.</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-button class="ml-4">
                            {{ __('Soruyu Kaydet') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- JavaScript artık dinamik ekleme/silme için gerekli değil, sadece old() değerlerini yüklemek için --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                console.log('admin/tests/questions/create.blade.php: Sabit 4 şık alanı yüklendi.');
            });
        </script>
    @endpush
</x-app-layout>
