<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use App\Models\UserTestAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminTestController extends Controller
{
    /**
     * Tüm testleri listele.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tests = Test::with('user')->latest()->get();
        return view('admin.tests.index', compact('tests'));
    }

    /**
     * Yeni test oluşturma formunu göster.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.tests.create');
    }

    /**
     * Yeni testi veritabanına kaydet.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Auth::user()->tests()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.tests.index')->with('success', 'Test başarıyla oluşturuldu!');
    }

    /**
     * Belirli bir testi ve sorularını göster.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\View\View
     */
    public function show(Test $test)
    {
        $test->load('questions.answers');
        return view('admin.tests.show', compact('test'));
    }

    /**
     * Testi düzenleme formunu göster.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\View\View
     */
    public function edit(Test $test)
    {
        return view('admin.tests.edit', compact('test'));
    }

    /**
     * Testi güncelle.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Test $test)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $test->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.tests.show', $test)->with('success', 'Test başarıyla güncellendi!');
    }

    /**
     * Testi sil.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Test $test)
    {
        $test->delete();
        return redirect()->route('admin.tests.index')->with('success', 'Test başarıyla silindi!');
    }

    /**
     * Belirli bir teste yeni soru ekleme formunu göster.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\View\View
     */
    public function createQuestion(Test $test)
    {
        return view('admin.tests.questions.create', compact('test'));
    }

    /**
     * Yeni soruyu ve cevaplarını veritabanına kaydet.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeQuestion(Request $request, Test $test)
    {
        $request->validate([
            'question_text' => 'required|string',
            'answers' => 'required|array|min:2',
            'answers.*.text' => 'required|string|max:255',
            'correct_answer' => 'required|integer|min:0|max:' . (count($request->answers) - 1),
        ]);

        DB::transaction(function () use ($request, $test) {
            $question = $test->questions()->create([
                'question_text' => $request->question_text,
            ]);

            foreach ($request->answers as $index => $answerData) {
                $question->answers()->create([
                    'answer_text' => $answerData['text'],
                    'is_correct' => ($index == $request->correct_answer),
                ]);
            }
        });

        return redirect()->route('admin.tests.show', $test)->with('success', 'Soru ve cevapları başarıyla eklendi!');
    }

    /**
     * Soruyu düzenleme formunu göster.
     *
     * @param  \App\Models\Test  $test
     * @param  \App\Models\Question  $question
     * @return \Illuminate\View\View
     */
    public function editQuestion(Test $test, Question $question)
    {
        $question->load('answers');
        return view('admin.tests.questions.edit', compact('test', 'question'));
    }

    /**
     * Soruyu ve cevaplarını güncelle.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateQuestion(Request $request, Test $test, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string',
            'answers' => 'required|array|min:2',
            'answers.*.id' => 'nullable|exists:answers,id',
            'answers.*.text' => 'required|string|max:255',
            'correct_answer' => 'required|integer|min:0|max:' . (count($request->answers) - 1),
        ]);

        DB::transaction(function () use ($request, $question) {
            $question->update(['question_text' => $request->question_text]);


            $existingAnswerIds = $question->answers->pluck('id')->toArray();
            $updatedAnswerIds = [];

            foreach ($request->answers as $index => $answerData) {
                if (isset($answerData['id']) && in_array($answerData['id'], $existingAnswerIds)) {

                    Answer::where('id', $answerData['id'])->update([
                        'answer_text' => $answerData['text'],
                        'is_correct' => ($index == $request->correct_answer),
                    ]);
                    $updatedAnswerIds[] = $answerData['id'];
                } else {

                    $question->answers()->create([
                        'answer_text' => $answerData['text'],
                        'is_correct' => ($index == $request->correct_answer),
                    ]);
                }
            }


            $answersToDelete = array_diff($existingAnswerIds, $updatedAnswerIds);
            if (!empty($answersToDelete)) {
                Answer::whereIn('id', $answersToDelete)->delete();
            }
        });

        return redirect()->route('admin.tests.show', $test)->with('success', 'Soru ve cevapları başarıyla güncellendi!');
    }

    /**
     * Soruyu sil.
     *
     * @param  \App\Models\Test  $test
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyQuestion(Test $test, Question $question)
    {
        $question->delete();
        return redirect()->route('admin.tests.show', $test)->with('success', 'Soru başarıyla silindi!');
    }

    /**
     * Belirli bir testin tüm kullanıcı denemelerini listele (Admin için).
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\View\View
     */
    public function viewResults(Test $test)
    {
        $attempts = $test->userTestAttempts()->with('user')->latest('attempt_date')->get();
        return view('admin.tests.results', compact('test', 'attempts'));
    }

    /**
     * Belirli bir test denemesinin detaylarını göster (Admin için).
     *
     * @param  \App\Models\UserTestAttempt  $attempt
     * @return \Illuminate\View\View
     */
    public function showAttemptDetail(UserTestAttempt $attempt)
    {
        $attempt->load('user', 'test', 'userAnswers.question.answers');
        return view('admin.tests.attempt_detail', compact('attempt'));
    }

    //Kullanıcnın test sonucunu silmek için
    public function destroyAttempt(UserTestAttempt $attempt)
    {
        $attempt->delete();
        return back()->with('success', 'Test sonucu başarıyla silindi.');
    }

}
