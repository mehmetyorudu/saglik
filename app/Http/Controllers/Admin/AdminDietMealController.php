<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DietMeal;
use App\Models\DietPlan;
use Illuminate\Http\Request;

class AdminDietMealController extends Controller
{
    // Günler
    private $days = [
        1 => 'Pazartesi',
        2 => 'Salı',
        3 => 'Çarşamba',
        4 => 'Perşembe',
        5 => 'Cuma',
        6 => 'Cumartesi',
        7 => 'Pazar',
    ];

    // Öğün tipleri
    private $mealTypes = [
        'breakfast' => 'Kahvaltı',
        'snack'     => 'Ara Öğün (Sabah)',
        'lunch'     => 'Öğle Yemeği',
        'snack2'    => 'Ara Öğün (Öğleden Sonra)',
        'dinner'    => 'Akşam Yemeği',
        'supper'    => 'Gece Yemeği',
        'other'     => 'Notlar',
    ];

    // Haftalık öğün ekleme formu
    public function createWeek(DietPlan $dietPlan)
    {
        $meals = $dietPlan->meals()
            ->orderBy('day_number')
            ->orderBy('order')
            ->get()
            ->groupBy(function($item) {
                return $item->day_number . '-' . $item->meal_type;
            });

        return view('admin.diet-meals.create-week', [
            'dietPlan'  => $dietPlan,
            'days'      => $this->days,
            'mealTypes' => $this->mealTypes,
            'meals'     => $meals,
        ]);
    }

    // Haftalık öğünleri kaydetme / güncelleme
    public function updateWeek(Request $request, DietPlan $dietPlan)
    {
        $data = $request->validate([
            'meals' => 'required|array',
            'meals.*.*.day_number' => 'required|integer|between:1,7',
            'meals.*.*.meal_type'  => 'required|in:breakfast,snack,lunch,snack2,dinner,supper,other',
            'meals.*.*.notes'      => 'nullable|string',
            'meals.*.*.order'      => 'nullable|integer|min:0',
            'meals.*.*.id'         => 'nullable|integer|exists:diet_meals,id',
        ]);

        foreach ($data['meals'] as $dayMeals) {
            foreach ($dayMeals as $mealInput) {
                $notes = $mealInput['notes'] ?? '';

                if (!empty($mealInput['id'])) {
                    $meal = DietMeal::find($mealInput['id']);
                    if ($meal && $meal->diet_plan_id == $dietPlan->id) {
                        $meal->update([
                            'day_number' => $mealInput['day_number'],
                            'meal_type'  => $mealInput['meal_type'],
                            'title'      => '',
                            'notes'      => $notes,
                            'order'      => $mealInput['order'] ?? 0,
                        ]);
                    }
                } else {
                    if (!empty($notes)) {
                        $dietPlan->meals()->create([
                            'day_number' => $mealInput['day_number'],
                            'meal_type'  => $mealInput['meal_type'],
                            'title'      => '',
                            'notes'      => $notes,
                            'order'      => $mealInput['order'] ?? 0,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.diet-plans.diet-meals.edit-week', $dietPlan->id)
            ->with('success', 'Haftalık öğünler başarıyla güncellendi.');
    }

    // Haftalık öğünleri düzenleme sayfası
    public function editWeek(DietPlan $dietPlan)
    {
        $meals = $dietPlan->meals()
            ->orderBy('day_number')
            ->orderBy('order')
            ->get();

        return view('admin.diet-meals.edit-week', [
            'dietPlan'  => $dietPlan,
            'meals'     => $meals,
            'days'      => $this->days,
            'mealTypes' => $this->mealTypes,
        ]);
    }

    // Öğün silme
    public function destroy(DietPlan $dietPlan, DietMeal $dietMeal)
    {
        if ($dietMeal->diet_plan_id != $dietPlan->id) {
            abort(404);
        }

        $dietMeal->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.diet-plans.diet-meals.index', $dietPlan->id)
            ->with('success', 'Öğün başarıyla silindi.');
    }

    //Toplu öğün silme
    public function bulkDestroy(Request $request, DietPlan $dietPlan)
    {
        $request->validate([
            'selected_meals' => 'required|array',
            'selected_meals.*' => 'integer|exists:diet_meals,id',
        ]);
        $dietPlan->meals()->whereIn('id', $request->selected_meals)->delete();

        return redirect()->route('admin.diet-plans.diet-meals.edit-week', $dietPlan->id)
            ->with('success', count($request->selected_meals) . ' adet öğün başarıyla silindi.');
    }
}
