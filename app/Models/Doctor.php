<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Doctor extends Model
    {
        use HasFactory;

        protected $fillable = ['name', 'specialty','user_id'];

        public function appointments()
        {
            return $this->hasMany(Appointment::class);
        }
        public function dietPlans()
        {
            return $this->hasMany(DietPlan::class);
        }



        public function user()
        {
            return $this->belongsTo(User::class);
        }

    }
