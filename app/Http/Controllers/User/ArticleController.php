<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Tüm makaleleri listele.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $articles = Article::with('user')->latest()->get();
        return view('articles.index', compact('articles'));
    }

    /**
     * Belirli bir makaleyi göster.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\View\View
     */
    public function show(Article $article)
    {
        $article->load('user');
        return view('articles.show', compact('article'));
    }
}
