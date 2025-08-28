<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Doktor Paneli - Randevularım') }}
        </h2>
    </x-slot>

    <x-slot name="head">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" xintegrity="sha512-ieoQ3yO8W+f1I1r1tF7mR4gX3GgqVv2C2qL2l6e7Q5V+fP6f0F8jQ4R2Gg2L6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </x-slot>

    <div class="py-12 bg-gray-100" x-data="{ activeTab: (new URLSearchParams(window.location.search)).get('tab') || 'upcoming', ...appointmentList() }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Randevularım</h3>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                {{-- Sekme Navigasyonu --}}
                <div class="border-b border-gray-200 mb-6">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
                        <li class="mr-2">
                            <a href="#" @click.prevent="activeTab = 'upcoming'" :class="{ 'border-b-2 border-indigo-600 text-indigo-600': activeTab === 'upcoming' }" class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300">Randevular</a>
                        </li>
                        <li class="mr-2">
                            <a href="#" @click.prevent="activeTab = 'past'" :class="{ 'border-b-2 border-indigo-600 text-indigo-600': activeTab === 'past' }" class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:border-gray-300">Geçmiş Randevular</a>
                        </li>
                    </ul>
                </div>

                {{-- Randevular Listesi (Tarihi geçmemil olanlar) --}}
                <div x-show="activeTab === 'upcoming'" class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3 px-6">Randevu Alan</th>
                            <th scope="col" class="py-3 px-6">Tarih</th>
                            <th scope="col" class="py-3 px-6">Saat</th>
                            <th scope="col" class="py-3 px-6">Açıklama</th>
                            <th scope="col" class="py-3 px-6">Durum</th>
                            <th scope="col" class="py-3 px-6">İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($upcomingAppointments as $appointment)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">{{ $appointment->user ? $appointment->user->name : 'Kullanıcı Silinmiş' }}</th>
                                <td class="py-4 px-6">{{ $appointment->appointment_date }}</td>
                                <td class="py-4 px-6">{{ $appointment->appointment_time }}</td>
                                <td class="py-4 px-6">{{ $appointment->description ?? '-' }}</td>
                                <td class="py-4 px-6">
                                    @if($appointment->is_approved)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Onaylandı</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Beklemede</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 flex space-x-2">
                                    @if(!$appointment->is_approved)
                                        <form action="{{ route('doctor.appointments.approve', $appointment) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="font-medium text-green-600 hover:underline">Onayla</button>
                                        </form>

                                        <form id="reject-form-{{ $appointment->id }}" action="{{ route('doctor.appointments.reject', $appointment) }}" method="POST" @submit.prevent>
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" @click="confirmReject({{ $appointment->id }})" class="font-medium text-red-600 hover:underline">Reddet</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white">
                                <td colspan="6" class="py-4 px-6 text-center text-gray-600">Henüz onay bekleyen veya gelecek bir randevu bulunmamaktadır.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Geçmiş Randevular --}}
                <div x-show="activeTab === 'past'" style="display: none;" class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3 px-6">Randevu Alan</th>
                            <th scope="col" class="py-3 px-6">Tarih</th>
                            <th scope="col" class="py-3 px-6">Saat</th>
                            <th scope="col" class="py-3 px-6">Açıklama</th>
                            <th scope="col" class="py-3 px-6">Durum</th>
                            <th scope="col" class="py-3 px-6 text-center">İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($pastAppointments as $appointment)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">{{ $appointment->user ? $appointment->user->name : 'Kullanıcı Silinmiş' }}</th>
                                <td class="py-4 px-6">{{ $appointment->appointment_date }}</td>
                                <td class="py-4 px-6">{{ $appointment->appointment_time }}</td>
                                <td class="py-4 px-6">{{ $appointment->description ?? '-' }}</td>
                                <td class="py-4 px-6">
                                    @if($appointment->is_completed)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Tamamlandı</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tamamlanmadı</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 flex items-center justify-center">
                                    @if($appointment->is_completed)
                                        <form action="{{ route('doctor.appointments.incomplete', $appointment) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="font-medium text-red-600 hover:underline" title="Tamamlanmadı Olarak İşaretle">
                                                ✗
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('doctor.appointments.complete', $appointment) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="font-medium text-green-600 hover:underline" title="Tamamlandı Olarak İşaretle">
                                                ✓
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white">
                                <td colspan="6" class="py-4 px-6 text-center text-gray-600">Henüz geçmiş randevu bulunmamaktadır.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div
                    x-show="showConfirm"
                    x-transition
                    style="display: none;"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                >
                    <div class="bg-white rounded-lg p-6 w-96 max-w-full shadow-lg">
                        <h2 class="text-lg font-semibold mb-4 text-red-600">Randevuyu Reddet</h2>
                        <p class="mb-6">Bu randevuyu reddetmek istediğinizden emin misiniz? Bu işlem randevuyu kalıcı olarak silecektir.</p>
                        <div class="flex justify-end space-x-4">
                            <button
                                @click="showConfirm = false"
                                class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300"
                            >
                                İptal
                            </button>

                            <button
                                @click="submitReject()"
                                class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700"
                            >
                                Reddet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        function appointmentList() {
            return {
                showConfirm: false,
                rejectId: null,

                confirmReject(id) {
                    this.rejectId = id;
                    this.showConfirm = true;
                },

                submitReject() {
                    this.showConfirm = false;
                    const form = document.getElementById('reject-form-' + this.rejectId);
                    if (form) form.submit();
                }
            }
        }
    </script>
</x-app-layout>
