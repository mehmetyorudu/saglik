<?php

// app/Http/Controllers/ForumController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    /**
     * Tüm forum gönderilerini listele.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $posts = ForumPost::with('user')->latest()->get();
        // Updated view path to 'user.forum.index'
        return view('user.forum.index', compact('posts'));
    }

    /**
     * Yeni forum gönderisi oluşturma formunu göster.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('user.forum.create');
    }

    /**
     * Yeni forum gönderisini veritabanına kaydet.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('forum_images', 'public');
        }


        Auth::user()->forumPosts()->create([
            'title' => $request->title,
            'content' => $request->content,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('forum.index')->with('success', 'Forum gönderisi başarıyla oluşturuldu!');
    }


    /**
     * Belirli bir forum gönderisini ve yorumlarını göster.
     *
     * @param  \App\Models\ForumPost  $forumPost
     * @return \Illuminate\View\View
     */
    public function show(ForumPost $forumPost)
    {
        $forumPost->load('user', 'comments.user');
        // Updated view path to 'user.forum.show'
        return view('user.forum.show', compact('forumPost'));
    }

    /**
     * Belirli bir forum gönderisine yorum ekle.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ForumPost  $forumPost
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeComment(Request $request, ForumPost $forumPost)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        Auth::user()->comments()->create([
            'forum_post_id' => $forumPost->id,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Yorumunuz başarıyla eklendi!');
    }
}
