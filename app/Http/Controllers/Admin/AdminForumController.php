<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\ForumPost;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AdminForumController extends Controller
{
    public function index()
    {
        $posts = ForumPost::with('user', 'comments.user')->latest()->paginate(15);
        return view('admin.forum.index', compact('posts'));
    }
    public function edit($id)
    {
        $post = ForumPost::with('user', 'comments.user')->findOrFail($id);
        return view('admin.forum.edit', compact('post'));
    }
    // Forum gönderisini siler
    public function destroyPost($id)
    {
        $post = ForumPost::findOrFail($id);

        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->comments()->delete();
        $post->delete();

        return redirect()->route('admin.forum.index')->with('success', 'Forum gönderisi başarıyla silindi.');
    }

    public function show($id)
    {
        $post = ForumPost::with('user', 'comments.user')->findOrFail($id);
        return view('admin.forum.show', compact('post'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $post = ForumPost::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }

            $imagePath = $request->file('image')->store('forum_images', 'public');
            $post->image_path = $imagePath;
        }

        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();

        return redirect()->route('admin.forum.index')->with('success', 'Forum gönderisi başarıyla güncellendi.');
    }


    public function destroyComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return back()->with('success', 'Yorum başarıyla silindi.');
    }
}
