<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profili Düzenle') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">


                @if(session('success'))
                    <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif


                @if ($errors->any())
                    <div class="mb-6 text-red-600 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update.user') }}">
                    @csrf
                    @method('PUT')


                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Ad Soyad</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">E-posta</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="my-6">

                    <h3 class="text-lg font-bold text-gray-800 mb-4">Şifre Değiştir</h3>


                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Mevcut Şifre</label>
                        <input type="password" name="current_password"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Yeni Şifre</label>
                        <input type="password" name="password"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Yeni Şifre (Tekrar)</label>
                        <input type="password" name="password_confirmation"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>


                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Profili Güncelle
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
