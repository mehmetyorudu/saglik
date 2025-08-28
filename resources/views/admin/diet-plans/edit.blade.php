<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yönetici Paneli - Diyet Planını Düzenle') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <form action="{{ route('admin.diet-plans.update', $dietPlan->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="doctor_id" class="block text-gray-700 font-semibold mb-2">Doktor</label>
                        <select name="doctor_id" id="doctor_id" required
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('doctor_id') border-red-500 @enderror">
                            <option value="">-- Doktor Seçiniz --</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id', $dietPlan->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="title" class="block text-gray-700 font-semibold mb-2">Başlık</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $dietPlan->title) }}" required maxlength="255"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-500 @enderror" />
                        @error('title')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-gray-700 font-semibold mb-2">Açıklama</label>
                        <textarea name="description" id="description" rows="4"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $dietPlan->description) }}</textarea>
                        @error('description')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.diet-plans.index') }}"
                           class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">İptal</a>
                        <button type="submit"
                                class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-300">
                            Güncelle
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
