<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_test_attempt_id',
        'question_id',
        'answer_id',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    /**
     * Kullanıcı cevabının ait olduğu test denemesini döndürür.
     */
    public function userTestAttempt()
    {
        return $this->belongsTo(UserTestAttempt::class);
    }

    /**
     * Kullanıcı cevabının ait olduğu soruyu döndürür.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Kullanıcının seçtiği cevabı döndürür.
     */
    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}