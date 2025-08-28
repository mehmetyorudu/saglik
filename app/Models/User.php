<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'height',
        'weight',
        'waist_circumference',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['is_doctor'];

    /**
     * Kullanıcı soft delete edildiğinde, ona ait tüm ilişkili kayıtları da soft delete yapar.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            $user->appointments()->delete();
            $user->dietPlans()->delete();
            $user->forumPosts()->delete();
            $user->comments()->delete();
            $user->articles()->delete();
            $user->tests()->delete();
            $user->userTestAttempts()->delete();
        });
    }

    /**
     * Kullanıcının sahip olduğu forum gönderilerini döndürür.
     */
    public function forumPosts()
    {
        return $this->hasMany(ForumPost::class);
    }

    /**
     * Kullanıcının yaptığı yorumları döndürür.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Kullanıcının (adminin) yazdığı makaleleri döndürür.
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    /**
     * Kullanıcının yaptığı test denemelerini döndürür.
     */
    public function userTestAttempts()
    {
        return $this->hasMany(UserTestAttempt::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Kullanıcının Diyet Planlarını döndürür.
     */
    public function dietPlans()
    {
        return $this->hasMany(DietPlan::class);
    }

    /**
     * Kullanıcının Doktor Olup olmadığına bakar.
     * Bu bir HasOne ilişkisidir.
     */
    public function doctorProfile(): HasOne
    {
        return $this->hasOne(Doctor::class);
    }

    /**
     * Kullanıcının doktor olup olmadığını kolayca kontrol etmek için bir "accessor".
     * $user->is_doctor şeklinde erişmenizi sağlar.
     */
    public function getIsDoctorAttribute(): bool
    {
        return $this->doctorProfile()->exists();
    }
}
