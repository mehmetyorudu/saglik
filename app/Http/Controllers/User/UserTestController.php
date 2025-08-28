<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Test;
use App\Models\UserTestAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserTestController extends Controller
{
    /**
     * Tüm mevcut testleri listele.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tests = Test::latest()->get();
        // Görünüm yolunu 'user.tests.index' olarak güncelledik
        return view('user.tests.index', compact('tests'));
    }

    /**
     * Belirli bir testi çözme ekranını göster.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function take(Test $test)
    {
        if ($test->questions->isEmpty()) {
            return redirect()->route('tests.index')->with('error', 'Bu test henüz soru içermemektedir.');
        }

        $test->load('questions.answers');
        // Görünüm yolunu 'user.tests.take' olarak güncelledik
        return view('user.tests.take', compact('test'));
    }

    /**
     * Kullanıcının test cevaplarını işle ve sonucu kaydet.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit(Request $request, Test $test)
    {
        $totalQuestions = $test->questions->count();
        $correctAnswersCount = 0;
        $incorrectAnswersCount = 0;

        DB::transaction(function () use ($request, $test, $totalQuestions, &$correctAnswersCount, &$incorrectAnswersCount) {
            $attempt = Auth::user()->userTestAttempts()->create([
                'test_id' => $test->id,
                'total_questions' => $totalQuestions,
                'attempt_date' => now(),
            ]);

            foreach ($test->questions as $question) {
                $selectedAnswerId = $request->input('question_' . $question->id);
                $isCorrect = false;

                if ($selectedAnswerId) {
                    $selectedAnswer = $question->answers->find($selectedAnswerId);
                    if ($selectedAnswer && $selectedAnswer->is_correct) {
                        $isCorrect = true;
                        $correctAnswersCount++;
                    } else {
                        $incorrectAnswersCount++;
                    }
                } else {
                    $incorrectAnswersCount++;
                }

                $attempt->userAnswers()->create([
                    'question_id' => $question->id,
                    'answer_id' => $selectedAnswerId,
                    'is_correct' => $isCorrect,
                ]);
            }

            $attempt->update([
                'score' => $correctAnswersCount,
                'correct_answers' => $correctAnswersCount,
                'incorrect_answers' => $incorrectAnswersCount,
            ]);
        });

        return redirect()->route('user.my_test_results')->with('success', 'Testi başarıyla tamamladınız! Sonuçlarınız kaydedildi.');
    }

    /**
     * Kullanıcının kendi test sonuçlarını listele.
     *
     * @return \Illuminate\View\View
     */
    public function myResults()
    {
        $attempts = Auth::user()->userTestAttempts()->with('test')->latest('attempt_date')->get();
        return view('user.test-details.my_test_results', compact('attempts'));
    }

    /**
     * Kullanıcının belirli bir test denemesinin detaylarını göster.
     *
     * @param  \App\Models\UserTestAttempt  $attempt
     * @return \Illuminate\View\View
     */
    public function showAttemptDetail(UserTestAttempt $attempt)
    {
        // İlişkili tüm verileri önceden yükle
        $attempt->load('user', 'test', 'userAnswers.question.answers');

        // Sayfayı, tüm ilişkileriyle birlikte yüklenmiş $attempt değişkeniyle döndür
        return view('user.test-details.test_attempt_detail', compact('attempt'));
    }
}
