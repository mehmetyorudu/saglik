<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
    ];

    /**
     * Testi oluşturan admini döndürür.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Teste ait soruları döndürür.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Teste ait kullanıcı denemelerini döndürür.
     */
    public function userTestAttempts()
    {
        return $this->hasMany(UserTestAttempt::class);
    }
}
