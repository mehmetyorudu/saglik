<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;

class AdminAppointmentController extends Controller
{
    /**
     * Admin paneli için tüm randevuları listeler.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $upcomingAppointments = Appointment::with(['user', 'doctor'])
            ->where(function ($query) {
                $query->whereDate('appointment_date', '>', Carbon::today())
                    ->orWhere(function ($query) {
                        $query->whereDate('appointment_date', '=', Carbon::today())
                            ->whereTime('appointment_time', '>', Carbon::now()->format('H:i:s'));
                    });
            })
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        $pastAppointments = Appointment::with(['user', 'doctor'])
            ->where(function ($query) {
                $query->whereDate('appointment_date', '<', Carbon::today())
                    ->orWhere(function ($query) {
                        $query->whereDate('appointment_date', '=', Carbon::today())
                            ->whereTime('appointment_time', '<', Carbon::now()->format('H:i:s'));
                    });
            })
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        return view('admin.appointments.index', compact('upcomingAppointments', 'pastAppointments'));
    }

    /**
     * Randevuyu onaylar.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Appointment $appointment)
    {

        $appointment->update([
            'is_approved' => true,
        ]);

        return redirect()->route('admin.appointments.index')->with('success', 'Randevu onaylandı.');
    }

    /**
     * Randevuyu reddeder (siler).
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')->with('success', 'Randevu reddedildi ve silindi.');

    }

    /**
     * Geçmiş randevuyu tamamlandı olarak işaretler.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function complete(Appointment $appointment)
    {
        $appointment->update([
            'is_completed' => true
        ]);

        return redirect()->route('admin.appointments.index', ['tab' => 'past'])->with('success', 'Randevu  tamamlandı olarak işaretlendi.');
    }

    /**
     * Geçmiş randevuyu tamamlanmadı olarak işaretler.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function incomplete(Appointment $appointment)
    {
        $appointment->update([
            'is_completed' => false
        ]);

        return redirect()->route('admin.appointments.index', ['tab' => 'past'])->with('error', 'Randevu tamamlanmadı olarak işaretlendi.');
    }
}
