<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ $attempt->user->name }} - {{ $attempt->test->title }} Test Detayı
        </h2>
    </x-slot>


    <div class="py-12 bg-gray-100">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-10 text-center mb-6">Cevaplar</h3>

                @forelse ($attempt->userAnswers as $index => $answer)
                    @php
                        $question = $answer->question;
                        $selected = $answer->answer_id;
                        $correctAnswer = $question->answers->firstWhere('is_correct', true);
                    @endphp

                    <div class="bg-gray-50 p-6 rounded-lg shadow-md border border-gray-200 mb-6">
                        <p class="text-lg font-semibold text-gray-800 mb-4">
                            {{ $index + 1 }}. {{ $question->question_text }}
                        </p>

                        @foreach ($question->answers as $optIndex => $opt)
                            @php
                                $isSelected = $opt->id === $selected;
                                $isCorrect = $opt->is_correct;
                            @endphp

                            <div class="flex items-center mb-3">
                                <input
                                    type="radio"
                                    disabled
                                    class="form-radio h-5 w-5 text-indigo-600"
                                    {{ $isSelected ? 'checked' : '' }}
                                >
                                <label class="ml-3 text-base {{ $isSelected && !$isCorrect ? 'text-red-600 line-through' : 'text-gray-800' }}">
                                    {{ $opt->answer_text }}
                                </label>

                                <div class="ml-3 space-x-1">
                                    @if ($isSelected)
                                        <span class="text-xs px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full">İşaretlenen</span>
                                    @endif
                                    @if ($isCorrect)
                                        <span class="text-xs px-2 py-0.5 bg-green-100 text-green-800 rounded-full">Doğru</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-4 text-sm">
                            <span class="font-semibold">Sonuç:</span>
                            @if ($selected === $correctAnswer->id)
                                <span class="text-green-600 font-semibold">Doğru</span>
                            @else
                                <span class="text-red-600 font-semibold">Yanlış</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 text-center">Bu teste ait cevap bulunamadı.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
