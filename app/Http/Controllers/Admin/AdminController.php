<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of all users with search and filter functionality.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function users(Request $request)
    {
        $users = User::query();

        // İsim veya e-posta ile arama
        $users->when($request->input('search'), function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        });

        // Yönetici veya doktor filtreleme
        $role = $request->input('role');

        if ($role === 'admin') {
            $users->where('is_admin', true);
        } elseif ($role === 'doctor') {
            $users->has('doctorProfile');
        } elseif ($role === 'regular') {
            $users->where('is_admin', false)->doesntHave('doctorProfile');
        }

        $users = $users->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Delete the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Kullanıcı başarıyla silindi.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'is_admin' => 'boolean',
            'is_doctor' => 'boolean',
            'specialty' => 'nullable|string|in:Diyetisyen,Stajyer Diyetisyen',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->is_admin = $request->has('is_admin');

        $isDoctor = $request->has('is_doctor');

        if ($isDoctor) {

            if (!$user->doctorProfile) {
                $user->doctorProfile()->create([
                    'name' => $user->name,
                    'specialty' => $request->input('specialty'),
                ]);
            } else {

                $user->doctorProfile->name = $user->name;
                $user->doctorProfile->specialty = $request->input('specialty');
                $user->doctorProfile->save();
            }
        } elseif (!$isDoctor && $user->doctorProfile) {
            $user->doctorProfile()->delete();
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Kullanıcı bilgileri başarıyla güncellendi.');
    }
}
