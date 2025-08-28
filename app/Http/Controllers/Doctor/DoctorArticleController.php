<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

class DoctorArticleController extends Controller
{
    /**
     * Doktorun kendi makalelerini listele
     */
    public function index()
    {
        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();

        $articles = Article::where('doctor_id', $doctor->id)
            ->latest()
            ->get();

        return view('doctor.articles.index', compact('articles'));
    }

    /**
     * Yeni makale oluşturma formu
     */
    public function create()
    {
        return view('doctor.articles.create');
    }

    /**
     * Yeni makale kaydet
     */
    public function store(Request $request)
    {
        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Article::create([
            'title'     => $request->title,
            'content'   => $request->content,
            'doctor_id' => $doctor->id,
            'user_id'   => Auth::id(),
        ]);

        return redirect()->route('doctor.articles.index')
            ->with('success', 'Makale başarıyla oluşturuldu.');
    }

    /**
     * Makale düzenleme formu
     */
    public function edit($id)
    {
        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();

        $article = Article::where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();

        return view('doctor.articles.edit', compact('article'));
    }

    /**
     * Makale güncelle
     */
    public function update(Request $request, $id)
    {
        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();

        $article = Article::where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();

        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $article->update([
            'title'   => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('doctor.articles.index')
            ->with('success', 'Makale başarıyla güncellendi.');
    }

    /**
     * Makale sil
     */
    public function destroy($id)
    {
        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();

        $article = Article::where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();

        $article->delete();

        return redirect()->route('doctor.articles.index')
            ->with('success', 'Makale başarıyla silindi.');
    }
}
