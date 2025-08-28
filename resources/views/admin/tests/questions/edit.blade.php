<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yönetici Paneli - Soruyu Düzenle') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">"{{ $test->title }}" Testindeki Soruyu Düzenle</h3>

                <form method="POST" action="{{ route('admin.tests.questions.update', [$test, $question]) }}">
                    @csrf
                    @method('PUT')

                    <!-- Soru Metni -->
                    <div>
                        <x-label for="question_text" :value="__('Soru Metni')" />
                        <textarea id="question_text" name="question_text" rows="4" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>{{ old('question_text', $question->question_text) }}</textarea>
                        @error('question_text')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cevaplar -->
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-3">Cevap Seçenekleri (En az 2)</h4>
                        <div id="answers-container">
                            @foreach ($question->answers as $index => $answer)
                                <div class="flex items-center space-x-2 mb-3 answer-item">
                                    <input type="radio" name="correct_answer" value="{{ $index }}" class="form-radio text-indigo-600" {{ old('correct_answer', $answer->is_correct ? $index : null) == $index ? 'checked' : '' }} required>
                                    <input type="hidden" name="answers[{{ $index }}][id]" value="{{ $answer->id }}">
                                    <x-input type="text" name="answers[{{ $index }}][text]" placeholder="Cevap {{ $index + 1 }}" class="flex-1" value="{{ old('answers.' . $index . '.text', $answer->answer_text) }}" required />
                                    <button type="button" class="text-red-500 hover:text-red-700 remove-answer-btn" style="{{ count($question->answers) <= 2 && $loop->count <= 2 ? 'display:none;' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm6 0a1 1 0 012 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                            <!-- Yeni eklenen cevaplar için yer tutucu -->
                            @if (old('answers') && count(old('answers')) > count($question->answers))
                                @foreach (array_slice(old('answers'), count($question->answers)) as $index => $oldAnswer)
                                    <div class="flex items-center space-x-2 mb-3 answer-item">
                                        <input type="radio" name="correct_answer" value="{{ count($question->answers) + $index }}" class="form-radio text-indigo-600" {{ old('correct_answer') == (count($question->answers) + $index) ? 'checked' : '' }} required>
                                        <x-input type="text" name="answers[{{ count($question->answers) + $index }}][text]" placeholder="Cevap {{ count($question->answers) + $index + 1 }}" class="flex-1" value="{{ $oldAnswer['text'] }}" required />
                                        <button type="button" class="text-red-500 hover:text-red-700 remove-answer-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm6 0a1 1 0 012 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" id="add-answer-btn" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-400 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mt-2">
                            Cevap Seçeneği Ekle
                        </button>
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
                            {{ __('Soruyu Güncelle') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const answersContainer = document.getElementById('answers-container');
                const addAnswerBtn = document.getElementById('add-answer-btn');
                let answerIndex = answersContainer.children.length;

                addAnswerBtn.addEventListener('click', function() {
                    addAnswerField('', answerIndex, false);
                    answerIndex++;
                    updateRemoveButtons();
                });

                answersContainer.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-answer-btn')) {
                        const answerItem = e.target.closest('.answer-item');
                        if (answersContainer.children.length > 2) {
                            answerItem.remove();
                            reindexAnswers();
                            updateRemoveButtons();
                        }
                    }
                });

                function addAnswerField(value = '', index, isChecked = false, answerId = null) {
                    const div = document.createElement('div');
                    div.className = 'flex items-center space-x-2 mb-3 answer-item';
                    div.innerHTML = `
                    <input type="radio" name="correct_answer" value="${index}" class="form-radio text-indigo-600" ${isChecked ? 'checked' : ''} required>
                    ${answerId ? `<input type="hidden" name="answers[${index}][id]" value="${answerId}">` : ''}
                    <input type="text" name="answers[${index}][text]" placeholder="Cevap ${index + 1}" class="flex-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="${value}" required />
                    <button type="button" class="text-red-500 hover:text-red-700 remove-answer-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm6 0a1 1 0 012 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd" />
                        </svg>
                    </button>
                `;
                    answersContainer.appendChild(div);
                }

                function reindexAnswers() {
                    const answerItems = answersContainer.querySelectorAll('.answer-item');
                    answerItems.forEach((item, i) => {
                        item.querySelector('input[type="radio"]').value = i;
                        const textInput = item.querySelector('input[type="text"]');
                        textInput.name = `answers[${i}][text]`;
                        textInput.placeholder = `Cevap ${i + 1}`;
                        const idInput = item.querySelector('input[type="hidden"]');
                        if (idInput) {
                            idInput.name = `answers[${i}][id]`;
                        }
                    });
                    answerIndex = answerItems.length;
                }

                function updateRemoveButtons() {
                    const removeButtons = answersContainer.querySelectorAll('.remove-answer-btn');
                    if (answersContainer.children.length <= 2) {
                        removeButtons.forEach(btn => btn.style.display = 'none');
                    } else {
                        removeButtons.forEach(btn => btn.style.display = 'block');
                    }
                }

                // Sayfa yüklendiğinde mevcut cevapları ve doğru cevabı ayarla
                const existingAnswers = @json($question->answers->sortBy('id')->values()); // ID'ye göre sırala
                const oldAnswers = @json(old('answers'));
                const oldCorrectAnswerIndex = @json(old('correct_answer'));

                answersContainer.innerHTML = ''; // Mevcut varsayılanları temizle

                if (oldAnswers && oldAnswers.length > 0) {
                    oldAnswers.forEach((answer, i) => {
                        addAnswerField(answer.text, i, i == oldCorrectAnswerIndex, answer.id || null);
                    });
                    answerIndex = oldAnswers.length;
                } else {
                    existingAnswers.forEach((answer, i) => {
                        addAnswerField(answer.answer_text, i, answer.is_correct, answer.id);
                    });
                    answerIndex = existingAnswers.length;
                }
                updateRemoveButtons();
            });
        </script>
    @endpush
</x-app-layout>
