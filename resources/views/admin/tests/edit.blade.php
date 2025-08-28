<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yönetici Paneli - Testi Düzenle') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Testi Düzenle: {{ $test->title }}</h3>

                <form method="POST" action="{{ route('admin.tests.update', $test) }}">
                    @csrf
                    @method('PUT')

                    <!-- Başlık -->
                    <div>
                        <x-label for="title" :value="__('Test Başlığı')" />
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $test->title)" required autofocus />
                        @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Açıklama -->
                    <div class="mt-4">
                        <x-label for="description" :value="__('Açıklama')" />
                        <textarea id="description" name="description" rows="5" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">{{ old('description', $test->description) }}</textarea>
                        @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-button class="ml-4">
                            {{ __('Testi Güncelle ve Sorulara Geç') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
