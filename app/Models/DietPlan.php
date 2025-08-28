<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DietPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'doctor_id',
        'user_id',
        'title',
        'description',
    ];


    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function meals()
    {
        return $this->hasMany(DietMeal::class);
    }
    public function dietMeals()
    {
        return $this->hasMany(DietMeal::class);
    }
    protected static function booted()
    {
        static::deleting(function ($dietPlan) {
            $dietPlan->meals()->delete();
        });
    }
}
