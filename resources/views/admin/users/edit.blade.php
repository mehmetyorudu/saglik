<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profili Düzenle') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Profil Bilgilerini Güncelle</h3>

                @if(session('success'))
                    <div class="bg-green-100 text-green-800 p-4 rounded mb-4 text-center">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 text-red-600 text-sm p-4 rounded bg-red-100 text-center">
                        <ul class="list-disc list-inside inline-block text-left">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div class="max-w-md mx-auto space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Ad Soyad</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required autofocus>
                            @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">E-posta</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Doktor ve Admin kutucukları --}}
                        <div class="pt-4 space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_admin" id="is_admin" value="1" @if($user->is_admin) checked @endif class="rounded text-indigo-600 border-gray-300 shadow-sm focus:ring-indigo-500">
                                <label for="is_admin" class="ml-2 block text-sm font-medium text-gray-700">Yönetici</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_doctor" id="is_doctor" value="1" @if($user->doctorProfile) checked @endif class="rounded text-indigo-600 border-gray-300 shadow-sm focus:ring-indigo-500">
                                <label for="is_doctor" class="ml-2 block text-sm font-medium text-gray-700">Doktor</label>
                            </div>
                        </div>

                        {{-- Uzmanlık Alanı seçimi --}}
                        <div id="specialty-field" class="
                            @if(old('is_doctor'))
                                @unless(old('is_doctor')) hidden @endunless
                            @else
                                @unless($user->doctorProfile) hidden @endunless
                            @endif">
                            <label for="specialty" class="block text-sm font-medium text-gray-700">Uzmanlık Alanı</label>
                            <select name="specialty" id="specialty" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Seçiniz</option>
                                <option value="Uzman Diyetisyen" @if(old('specialty') === 'Uzman Diyetisyen' || ($user->doctorProfile && $user->doctorProfile->specialty === 'Uzman Diyetisyen')) selected @endif>Uzman Diyetisyen</option>
                                <option value="Diyetisyen" @if(old('specialty') === 'Diyetisyen' || ($user->doctorProfile && $user->doctorProfile->specialty === 'Diyetisyen')) selected @endif>Diyetisyen</option>
                                <option value="Stajyer Diyetisyen" @if(old('specialty') === 'Stajyer Diyetisyen' || ($user->doctorProfile && $user->doctorProfile->specialty === 'Stajyer Diyetisyen')) selected @endif>Stajyer Diyetisyen</option>
                            </select>
                        </div>

                        <div class="flex justify-end pt-4 space-x-4">
                            <a href="{{ route('admin.users') }}" class="px-4 py-2 text-gray-600 hover:text-gray-900 font-medium">Geri</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 ml-4">
                                Güncelle
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

{{-- Javascript ile uzmanlık alanını gizle/göster --}}
<script>
    const isDoctorCheckbox = document.getElementById('is_doctor');
    const specialtyField = document.getElementById('specialty-field');

    const toggleSpecialtyField = () => {
        if (isDoctorCheckbox.checked) {
            specialtyField.classList.remove('hidden');
        } else {
            specialtyField.classList.add('hidden');
        }
    };

    isDoctorCheckbox.addEventListener('change', toggleSpecialtyField);

    // Sayfa yüklendiğinde kontrol et
    document.addEventListener('DOMContentLoaded', toggleSpecialtyField);
</script>
