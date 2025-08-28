<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'question_text',
    ];

    /**
     * Sorunun ait olduğu testi döndürür.
     */
    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    /**
     * Soruya ait cevapları döndürür.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Soruya ait kullanıcı cevaplarını döndürür.
     */
    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }
}