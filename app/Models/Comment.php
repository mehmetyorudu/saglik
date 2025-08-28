<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'forum_post_id',
        'content',
    ];

    /**
     * Yorumun ait olduğu kullanıcıyı döndürür.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Yorumun ait olduğu forum gönderisini döndürür.
     */
    public function forumPost()
    {
        return $this->belongsTo(ForumPost::class);
    }
}