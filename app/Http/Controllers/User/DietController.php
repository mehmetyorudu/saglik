<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DietPlan;
use Illuminate\Support\Facades\Auth;

class DietController extends Controller
{
    // Kullanıcının diyet planlarını listele
    public function index()
    {
        $user = Auth::user();
        $dietPlans = $user->dietPlans()->get();
        return view('user.diet.index', compact('dietPlans'));
    }

    public function show(DietPlan $dietPlan)
    {
        if ($dietPlan->user_id !== auth()->id()) {
            abort(403, 'Bu diyet planını görüntüleme yetkiniz yok.');
        }

        $dietPlan->load('meals');
        return view('user.diet.show', compact('dietPlan'));
    }

}
