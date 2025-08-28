<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Tüm randevuları listeler.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $appointments = Auth::user()->appointments()->with('doctor')->get();
        return view('user.appointments.index', compact('appointments'));
    }

    /**
     * Randevu oluşturma sayfasını gösterir.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $doctors = Doctor::all();
        $appointments = Auth::user()->appointments()->with('doctor')->get();

        return view('user.appointments.create', compact('doctors', 'appointments'));
    }

    /**
     * Yeni randevuyu kaydeder.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => ['required', 'exists:doctors,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => [
                'required',
                'string',
                //Gün içindeki geçmiş saate randevu alınmaması için gün ve saat kontrolü
                function ($attribute, $value, $fail) use ($request) {
                    $appointmentDate = $request->input('appointment_date');
                    if ($appointmentDate === Carbon::today()->format('Y-m-d')) {
                        $appointmentDateTime = Carbon::createFromFormat('Y-m-d H:i', $appointmentDate . ' ' . $value);
                        if ($appointmentDateTime->isPast()) {
                            $fail('Bugünkü randevular için geçmiş bir saat seçemezsiniz.');
                        }
                    }
                },
            ],
            'description' => ['nullable', 'string'],
        ]);

        Appointment::create([
            'user_id' => Auth::id(),
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'description' => $request->description,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Randevunuz başarıyla oluşturuldu.');
    }

    /**
     * Seçilen doktor ve tarihe göre uygun randevu saatlerini döndürür.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBookedSlots(Request $request)
    {
        $doctorId = $request->input('doctor_id');
        $appointmentDate = $request->input('appointment_date');

        // doktor ve randevu eşleştirmesi yapıp onaylanmış randevu ise saat ve tarihini alıp book olarak işaretliyom
        $bookedSlots = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $appointmentDate)
            ->where('is_approved', true)
            ->pluck('appointment_time')
            ->toArray();

        //booked olan saatleri döndürüyorum
        return response()->json([
            'booked_slots' => $bookedSlots
        ]);
    }
}
