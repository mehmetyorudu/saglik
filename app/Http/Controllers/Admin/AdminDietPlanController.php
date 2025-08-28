<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DietPlan;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDietPlanController extends Controller
{
    // Diyet planlarını listele
    public function index()
    {
        $dietPlans = DietPlan::with(['doctor', 'user'])->latest()->paginate(10);
        return view('admin.diet-plans.index', compact('dietPlans'));
    }

    // Yeni diyet planı formu
    public function create()
    {
        $doctors = Doctor::all();
        $users = User::all();
        return view('admin.diet-plans.create', compact('doctors', 'users'));
    }

    // Diyet planı kaydet
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:doctors,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $dietPlan = DietPlan::create($request->only('user_id', 'doctor_id', 'title', 'description'));

        return redirect()->route('admin.diet-plans.diet-meals.create-week', $dietPlan->id)
            ->with('success', 'Diyet planı başarıyla oluşturuldu. Şimdi öğün ekleyebilirsiniz.');
    }

    // Diyet planı düzenleme formu
    public function edit(DietPlan $dietPlan)
    {
        $doctors = Doctor::all();
        $users = User::all();
        return view('admin.diet-plans.edit', compact('dietPlan', 'doctors', 'users'));
    }

    // Diyet planı güncelle
    public function update(Request $request, DietPlan $dietPlan)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $dietPlan->update($request->only('doctor_id', 'title', 'description'));

        return redirect()->route('admin.diet-plans.index')
            ->with('success', 'Diyet planı başarıyla güncellendi.');
    }

    // Diyet planı sil
    public function destroy(DietPlan $dietPlan)
    {
        $dietPlan->delete();

        return redirect()->route('admin.diet-plans.index')
            ->with('success', 'Diyet planı başarıyla silindi.');
    }

}
