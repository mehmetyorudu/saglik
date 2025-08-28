<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Anasayfa') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

                <!-- Hoşgeldin Mesajı -->
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-600 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900">Hoş Geldin, {{ Auth::user()->name }}!</h3>
                </div>

                <!-- Kartlar -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kullanıcı Bilgileri Kartı -->
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md border border-gray-200 flex flex-col justify-between">
                        <div>
                            <h4 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Kullanıcı Bilgileri
                            </h4>
                            <ul class="space-y-2 text-gray-700">
                                <li><strong class="font-medium">Ad Soyad:</strong> {{ Auth::user()->name }}</li>
                                <li><strong class="font-medium">E-posta:</strong> {{ Auth::user()->email }}</li>
                            </ul>
                        </div>

                        <div class="mt-6 text-center">
                            <a href="{{ route('profile.edit.user') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Profili Düzenle
                            </a>
                        </div>
                    </div>

                    <!-- Sağlık Bilgileri Kartı -->
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md border border-gray-200 flex flex-col justify-between">
                        <div>
                            <h4 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.001 12.001 0 002.92 12c0 2.882 1.137 5.42 2.99 7.312a11.95 11.95 0 008.082 2.748 11.95 11.95 0 008.082-2.748 11.95-11.95 0 002.99-7.312c0-2.882-1.137-5.42-2.99-7.312z" />
                                </svg>
                                Sağlık Bilgileri
                            </h4>
                            <ul class="space-y-2 text-gray-700">
                                <li><strong class="font-medium">Yaş:</strong> {{ Auth::user()->age ?? 'Bilgi Yok' }}</li>
                                <li><strong class="font-medium">Boy:</strong> {{ Auth::user()->height ? Auth::user()->height . ' cm' : 'Bilgi Yok' }}</li>
                                <li><strong class="font-medium">Kilo:</strong> {{ Auth::user()->weight ? Auth::user()->weight . ' kg' : 'Bilgi Yok' }}</li>
                                <li><strong class="font-medium">Bel Çevresi:</strong> {{ Auth::user()->waist_circumference ? Auth::user()->waist_circumference . ' cm' : 'Bilgi Yok' }}</li>
                            </ul>
                        </div>

                        <div class="mt-6 text-center">
                            <a href="{{ route('profile.edit.health') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Sağlık Bilgilerini Düzenle
                            </a>
                        </div>
                    </div>
                    <div class="md:col-span-2 bg-gray-50 p-4 rounded-lg shadow-md border border-gray-200">
                        <h4 class="text-md font-semibold text-gray-800 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.001 12.001 0 002.92 12c0 2.882 1.137 5.42 2.99 7.312a11.95 11.95 0 008.082 2.748 11.95 11.95 0 008.082-2.748 11.95-11.95 0 002.99-7.312c0-2.882-1.137-5.42-2.99-7.312z" />
                            </svg>
                            {{--KALORİ HESAPLAMA KARTI--}}
                            Kalori Harcama Hesabı
                        </h4>

                        <form method="POST" action="{{ route('calculate.calories') }}" class="flex gap-6">
                            @csrf

                            <!-- Kilo -->
                            <input type="number" name="weight" step="0.1" required
                                   placeholder="{{ Auth::user()->weight ?? 'Kilo' }}"
                                   value="{{ old('weight', Auth::user()->weight) }}"
                                   class="flex-1 border border-gray-300 rounded-md text-sm px-2 py-1.5 shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">

                            <!-- Süre -->
                            <input type="number" name="minutes" required
                                   placeholder="Dakika"
                                   value="{{ old('minutes') }}"
                                   class="flex-1 border border-gray-300 rounded-md text-sm px-2 py-1.5 shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">

                            <!-- Spor seçimi -->
                            <select name="sport" required
                                    class="flex-1 border border-gray-300 rounded-md text-sm px-2 py-1.5 shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                                <option value="">Spor seçin</option>
                                @foreach(config('met_sports') as $sport => $met)
                                    <option value="{{ $sport }}" {{ old('sport') == $sport ? 'selected' : '' }}>
                                        {{ $sport }}
                                    </option>
                                @endforeach
                            </select>


                            <!-- Hesapla -->
                            <button type="submit"
                                    class="flex-1 bg-indigo-600 text-white text-sm px-2 py-1.5 rounded-md hover:bg-indigo-700 transition">
                                Hesapla
                            </button>
                        </form>
                        <br>
                        @if(session('calories'))
                            <div class=" text-center">
                                <h3 class="font-semibold mb-2">Harcadığın Kalori Miktarı:</h3>
                                <p class="text-3xl font-extrabold mb-1">{{ session('calories') }} <span class="text-xl font-medium">kcal</span></p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
