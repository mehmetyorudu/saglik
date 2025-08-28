<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function editUser()
    {
        $user = Auth::user();
        return view('user.profile.edit-user', compact('user'));
    }


    public function editHealth()
    {
        $user = Auth::user();
        return view('user.profile.edit-health', compact('user'));
    }


    public function updateUser(Request $request)
    {
        $user = auth()->user();


        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);


        $user->name = $validated['name'];
        $user->email = $validated['email'];


        if (!empty($validated['password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Mevcut şifre doğru değil.'])->withInput();
            }

            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect('/dashboard')->with('success', 'Profil başarıyla güncellendi.');
    }


    public function updateHealth(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'age' => 'nullable|integer|min:0',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'waist_circumference' => 'nullable|numeric|min:0',
        ]);

        $user->update($validated);

        return redirect('/dashboard')->with('success', 'Sağlık bilgileri güncellendi.');
    }

    //Kalori Hesaplama
    public function calculateCalories(Request $request)
    {
        $request->validate([
            'weight' => 'required|numeric|min:10|max:500',
            'minutes' => 'required|numeric|min:1|max:300',
            'sport' => 'required|string',
        ]);

        $sports = config('met_sports');

        if (!array_key_exists($request->sport, $sports)) {
            return back()->withErrors(['sport' => 'Geçersiz spor seçimi'])->withInput();
        }

        $weight = $request->input('weight');
        $minutes = $request->input('minutes');
        $met = $sports[$request->sport];

        $calories = $met * $weight * ($minutes / 60);
        $calories = round($calories, 2);

        return back()->with('calories', $calories)->withInput();

    }
}
