<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image_path',
    ];

    /**
     * Forum gönderisinin ait olduğu kullanıcıyı döndürür.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Forum gönderisine ait yorumları döndürür.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
