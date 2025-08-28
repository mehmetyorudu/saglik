<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Randevu Oluştur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('appointments.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="doctor_id" :value="__('Doktor Seçin')" />
                            <select id="doctor_id" name="doctor_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Doktor Seçiniz</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }} ({{ $doctor->specialty }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('doctor_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="appointment_date" :value="__('Randevu Tarihi')" />
                            <x-text-input id="appointment_date" class="block mt-1 w-full" type="date" name="appointment_date" :value="old('appointment_date')" required min="{{ now()->format('Y-m-d') }}" />
                            <x-input-error :messages="$errors->get('appointment_date')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label :value="__('Randevu Saati')" />
                            <div id="time-slots-container" class="flex flex-wrap gap-2 mt-2">
                                <p class="text-gray-500">Doktor ve Tarih Seçiniz</p>
                            </div>
                            <input type="hidden" name="appointment_time" id="selected_appointment_time" value="{{ old('appointment_time') }}" required>
                            <x-input-error :messages="$errors->get('appointment_time')" class="mt-2" />
                            <div id="loading-slots" class="text-sm text-gray-500 mt-1 hidden">Saatler yükleniyor...</div>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Açıklama (Opsiyonel)')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Randevuyu Onayla') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if($appointments->isNotEmpty())
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="font-semibold text-lg text-gray-800 leading-tight mb-4">
                            {{ __('Mevcut Randevularınız') }}
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Doktor') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Tarih') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Saat') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Açıklama') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Onay Durumu') }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($appointments as $appointment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $appointment->doctor->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $appointment->appointment_date }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $appointment->appointment_time }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $appointment->description ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($appointment->is_approved)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ __('Onaylandı') }}
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    {{ __('Beklemede') }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const doctorSelect = document.getElementById('doctor_id');
                const dateInput = document.getElementById('appointment_date');
                const timeSlotsContainer = document.getElementById('time-slots-container');
                const selectedTimeInput = document.getElementById('selected_appointment_time');
                const loadingSlots = document.getElementById('loading-slots');

                const oldAppointmentTime = @json(old('appointment_time'));
                const allPossibleTimes = ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00'];

                function fetchAvailableSlots() {
                    const doctorId = doctorSelect.value;
                    const appointmentDate = dateInput.value;

                    if (!doctorId || !appointmentDate) {
                        timeSlotsContainer.innerHTML = '<p class="text-gray-500">Doktor ve Tarih Seçiniz</p>';
                        selectedTimeInput.value = '';
                        return;
                    }

                    loadingSlots.classList.remove('hidden');
                    timeSlotsContainer.innerHTML = '<p class="text-gray-500">Yükleniyor...</p>';
                    selectedTimeInput.value = '';

                    fetch('{{ route('appointments.booked_slots') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            doctor_id: doctorId,
                            appointment_date: appointmentDate
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            const bookedSlots = data.booked_slots || [];
                            timeSlotsContainer.innerHTML = '';

                            // Anlık zamanı alma
                            const now = new Date();
                            const today = now.toISOString().slice(0, 10);
                            const selectedDateString = dateInput.value;

                            if (allPossibleTimes.length > 0) {
                                allPossibleTimes.forEach(slot => {
                                    const isBooked = bookedSlots.includes(slot);

                                    // Eğer tarih bugünse ve saat geçmişse, butonu pasif yap
                                    const [slotHour, slotMinute] = slot.split(':').map(Number);
                                    const isPastSlot = selectedDateString === today &&
                                        (slotHour < now.getHours() || (slotHour === now.getHours() && slotMinute < now.getMinutes()));

                                    const button = document.createElement('button');
                                    button.type = 'button';
                                    button.value = slot;
                                    button.textContent = slot;

                                    button.classList.add(
                                        'px-4', 'py-2', 'rounded-full', 'border', 'text-sm',
                                        'font-medium', 'transition', 'ease-in-out', 'duration-150',
                                        'focus:outline-none', 'focus:ring-2', 'focus:ring-offset-2', 'focus:ring-indigo-500'
                                    );

                                    if (isBooked || isPastSlot) {
                                        // Rezerve edilmiş veya geçmiş bir saatse pasif ve farklı bir stil
                                        button.disabled = true;
                                        button.classList.add('bg-gray-200', 'text-gray-500', 'border-gray-300', 'line-through', 'cursor-not-allowed');
                                        button.classList.remove('hover:bg-indigo-100', 'hover:text-indigo-800');
                                    } else {
                                        // Boşsa seçilebilir ve normal stil
                                        button.classList.add('bg-white', 'text-gray-700', 'border-gray-300', 'hover:bg-indigo-100', 'hover:text-indigo-800');

                                        // Daha önceden seçilmişse (old) stilini ayarla
                                        if (oldAppointmentTime && oldAppointmentTime === slot) {
                                            button.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
                                            button.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');
                                            selectedTimeInput.value = slot;
                                        }
                                        button.addEventListener('click', function() {
                                            document.querySelectorAll('#time-slots-container button').forEach(btn => {
                                                btn.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
                                                btn.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
                                            });

                                            this.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
                                            this.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');
                                            selectedTimeInput.value = this.value;
                                        });
                                    }

                                    timeSlotsContainer.appendChild(button);
                                });
                            } else {
                                timeSlotsContainer.innerHTML = '<p class="text-gray-500">Bu tarihte uygun saat bulunamadı.</p>';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching available slots:', error);
                            timeSlotsContainer.innerHTML = '<p class="text-red-500">Saatler yüklenirken bir hata oluştu.</p>';
                        })
                        .finally(() => {
                            loadingSlots.classList.add('hidden');
                        });
                }

                if (doctorSelect.value && dateInput.value) {
                    fetchAvailableSlots();
                }

                doctorSelect.addEventListener('change', fetchAvailableSlots);
                dateInput.addEventListener('change', fetchAvailableSlots);
            });
        </script>
    @endpush
</x-app-layout>
