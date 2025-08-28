<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

class DoctorAppointmentController extends Controller
{
    /**
     * Sadece giriş yapmış doktora ait gelecek ve geçmiş randevuları listeler.
     */
    public function index()
    {
        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();

        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->with('user')
            ->get();

        $upcomingAppointments = $appointments->filter(function ($appointment) {
            $appointmentDateTime = \Carbon\Carbon::parse($appointment->appointment_date . ' ' . $appointment->appointment_time);
            return $appointmentDateTime->isFuture(); // Gelecek randevular
        })->sortBy('appointment_date')->sortBy('appointment_time');

        $pastAppointments = $appointments->filter(function ($appointment) {
            $appointmentDateTime = \Carbon\Carbon::parse($appointment->appointment_date . ' ' . $appointment->appointment_time);
            return $appointmentDateTime->isPast();
        })->sortByDesc('appointment_date')->sortByDesc('appointment_time');

        return view('doctor.appointments.index', compact('upcomingAppointments', 'pastAppointments'));
    }


    /**
     * Randevuyu onaylar.
     */
    public function approve(Appointment $appointment)
    {
        $doctor = Doctor::where('user_id', Auth::id())->first();

        if (!$doctor || $appointment->doctor_id !== $doctor->id) {
            abort(403, 'Bu randevuyu onaylama yetkiniz yok.');
        }

        $appointment->update([
            'is_approved' => true,
        ]);

        return redirect()->route('doctor.appointments.index')->with('success', 'Randevu onaylandı.');
    }

    /**
     * Randevuyu reddeder (siler).
     */
    public function reject(Appointment $appointment)
    {
        $doctor = Doctor::where('user_id', Auth::id())->first();

        if (!$doctor || $appointment->doctor_id !== $doctor->id) {
            abort(403, 'Bu randevuyu reddetme yetkiniz yok.');
        }

        $appointment->delete();

        return redirect()->route('doctor.appointments.index')->with('success', 'Randevu reddedildi ve silindi.');
    }

    /**
     * Geçmiş randevuyu tamamlandı olarak işaretler.
     */
    public function complete(Appointment $appointment)
    {
        $doctor = Doctor::where('user_id', Auth::id())->first();

        if (!$doctor || $appointment->doctor_id !== $doctor->id) {
            abort(403, 'Bu randevuyu tamamlandı olarak işaretleme yetkiniz yok.');
        }

        $appointment->update([
            'is_completed' => true
        ]);

        return redirect()->route('doctor.appointments.index', ['tab' => 'past'])->with('success', 'Randevu tamamlandı olarak işaretlendi.');
    }

    /**
     * Geçmiş randevuyu tamamlanmadı olarak işaretler.
     */
    public function incomplete(Appointment $appointment)
    {
        $doctor = Doctor::where('user_id', Auth::id())->first();

        if (!$doctor || $appointment->doctor_id !== $doctor->id) {
            abort(403, 'Bu randevuyu tamamlanmadı olarak işaretleme yetkiniz yok.');
        }

        $appointment->update([
            'is_completed' => false
        ]);

        return redirect()->route('doctor.appointments.index', ['tab' => 'past'])->with('error', 'Randevu tamamlanmadı olarak işaretlendi.');
    }
}
