<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DietMeal extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'diet_meals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'diet_plan_id',
        'day_number',
        'meal_type',
        'title',
        'notes',
        'order',
    ];

    /**
     * Get the diet plan that owns the meal.
     */
    public function dietPlan()
    {
        return $this->belongsTo(DietPlan::class);
    }
}
