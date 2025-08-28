<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTestAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'test_id',
        'score',
        'total_questions',
        'correct_answers',
        'incorrect_answers',
        'attempt_date',
    ];

    protected $casts = [
        'attempt_date' => 'datetime',
    ];

    /**
     * Denemeyi yapan kullanıcıyı döndürür.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Denemenin ait olduğu testi döndürür.
     */
    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    /**
     * Denemeye ait kullanıcı cevaplarını döndürür.
     */
    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }
}
