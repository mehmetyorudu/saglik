<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'title',
        'content',

    ];

    /**
     * Makalenin ait olduğu admin kullanıcı.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Makalenin ait olduğu doktor.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}

