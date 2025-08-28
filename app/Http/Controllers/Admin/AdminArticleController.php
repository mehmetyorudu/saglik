<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminArticleController extends Controller
{
    /**
     * Tüm makaleleri yönetici panelinde listele.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $articles = Article::with('user')->latest()->get();
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Yeni makale oluşturma formunu göster.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * Yeni makaleyi veritabanına kaydet.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Auth::user()->articles()->create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Makale başarıyla oluşturuldu!');
    }

    /**
     * Makaleyi düzenleme formunu göster.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\View\View
     */
    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    /**
     * Makaleyi güncelle.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $article->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Makale başarıyla güncellendi!');
    }

    /**
     * Makaleyi sil.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Makale başarıyla silindi!');
    }
}
