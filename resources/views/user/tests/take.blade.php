<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Test Çöz') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $test->title }}</h3>
                <p class="text-gray-600 mb-6">{{ $test->description }}</p>

                <form method="POST" action="{{ route('tests.submit', $test) }}">
                    @csrf

                    @foreach ($test->questions as $question)
                        <div class="bg-gray-50 p-6 rounded-lg shadow-md border border-gray-200 mb-6">
                            <p class="text-lg font-semibold text-gray-800 mb-4">{{ $loop->iteration }}. {{ $question->question_text }}</p>

                            @foreach ($question->answers->shuffle() as $answer) {{-- Cevapları karıştır --}}
                            <div class="flex items-center mb-3">
                                <input type="radio" name="question_{{ $question->id }}" id="answer_{{ $answer->id }}" value="{{ $answer->id }}" class="form-radio text-indigo-600 h-5 w-5">
                                <label for="answer_{{ $answer->id }}" class="ml-3 text-gray-700 text-base">{{ $answer->answer_text }}</label>
                            </div>
                            @endforeach
                            @error('question_' . $question->id)
                            <p class="text-red-500 text-xs mt-1">Bu soruya cevap vermelisiniz.</p>
                            @enderror
                        </div>
                    @endforeach

                    <div class="flex items-center justify-end mt-6">
                        <x-button class="ml-4">
                            {{ __('Testi Bitir') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
