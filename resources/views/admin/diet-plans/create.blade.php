<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yönetici Paneli - Diyet Planı Oluştur') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

                @if ($errors->any())
                    <div class="mb-6">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.diet-plans.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Kullanıcı seçimi + Geri Dön butonu aynı hizada -->
                    <div class="flex items-center justify-between">
                        <label for="user_id" class="block text-gray-700 font-semibold mb-2">Danışan</label>
                        <a href="{{ route('admin.diet-plans.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                            &larr; Geri Dön
                        </a>
                    </div>
                    <select id="user_id" name="user_id" required
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('user_id') border-red-500 @enderror">
                        <option value="">-- Danışan Seçiniz --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror

                    <!-- Doktor seçimi -->
                    <div>
                        <label for="doctor_id" class="block text-gray-700 font-semibold mb-2">Doktor</label>
                        <select id="doctor_id" name="doctor_id" required
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('doctor_id') border-red-500 @enderror">
                            <option value="">-- Doktor Seçiniz --</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Başlık -->
                    <div>
                        <label for="title" class="block text-gray-700 font-semibold mb-2">Başlık</label>
                        <input type="text" id="title" name="title" required maxlength="255"
                               value="{{ old('title') }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-500 @enderror" />
                        @error('title')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Açıklama -->
                    <div>
                        <label for="description" class="block text-gray-700 font-semibold mb-2">Açıklama</label>
                        <textarea id="description" name="description" rows="4"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kaydet butonu sağda -->
                    <div class="flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-300">
                            Diyet Planı Oluştur
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

