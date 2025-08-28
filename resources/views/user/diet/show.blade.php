@php
    $mealTypes = [
          'breakfast' => 'Kahvaltı',
          'snack'    => 'Ara Öğün',
          'lunch'     => 'Öğle Yemeği',
          'snack2'    => 'Ara Öğün',
          'dinner'    => 'Akşam Yemeği',
          'supper'    => 'Gece Yemeği',
          'other'     => 'Notlar',
  ];

  $days = [
      1 => 'Pazartesi',
      2 => 'Salı',
      3 => 'Çarşamba',
      4 => 'Perşembe',
      5 => 'Cuma',
      6 => 'Cumartesi',
      7 => 'Pazar',
  ];
@endphp

<x-app-layout>
    <x-slot name="header">
        {{ __('Diyet Planım - ') . $dietPlan->title }}
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6 lg:p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Haftalık Öğünler</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-gray-700 text-sm">
                        <thead class="bg-indigo-600 text-white">
                        <tr>
                            <th class="border px-3 py-2 w-24 text-center">Gün</th>
                            @foreach($mealTypes as $mealKey => $mealLabel)
                                <th class="border px-3 py-2 text-center">{{ $mealLabel }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($days as $dayNum => $dayName)
                            @php
                                $dayMeals = $dietPlan->meals->where('day_number', $dayNum);
                            @endphp
                            <tr>
                                <td class="border px-3 py-2 font-semibold text-center bg-indigo-100 text-indigo-800">
                                    {{ $dayName }}
                                </td>
                                @foreach($mealTypes as $mealKey => $mealLabel)
                                    @php
                                        $meal = $dayMeals->firstWhere('meal_type', $mealKey);
                                    @endphp
                                    <td class="border px-2 py-2 align-top">
                                        <div class="text-sm text-gray-700">
                                            {{ $meal->notes ?? '-' }}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                            @if(!$loop->last)
                                <tr class="bg-gray-200">
                                    <td colspan="{{ count($mealTypes) + 1 }}" class="h-1 px-0 py-0"></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end mt-6">
                    <a href="{{ route('diet.index') }}" class="text-indigo-600 hover:text-indigo-800">
                        Geri
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


{{--********************************************************************************************************************************--}}
{{--
@php
    $mealTypes = [
        'breakfast' => 'Kahvaltı',
        'snack'     => 'Ara Öğün',
        'lunch'     => 'Öğle Yemeği',
        'snack2'    => 'Ara Öğün',
        'dinner'    => 'Akşam Yemeği',
        'supper'    => 'Gece Yemeği',
        'other'     => 'Notlar',
    ];

    $days = [
        1 => 'Pazartesi',
        2 => 'Salı',
        3 => 'Çarşamba',
        4 => 'Perşembe',
        5 => 'Cuma',
        6 => 'Cumartesi',
        7 => 'Pazar',
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Diyet Planım - ') . $dietPlan->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold text-gray-900 mb-10 text-center">Haftalık Öğünler</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($days as $dayNum => $dayName)
                    @php
                        $dayMeals = $dietPlan->meals->where('day_number', $dayNum);
                    @endphp

                    <div class="bg-white shadow-lg rounded-2xl border border-gray-200 p-6 hover:shadow-xl transition duration-200">
                        <h4 class="text-xl font-bold text-indigo-600 mb-6 text-center border-b pb-3">{{ $dayName }}</h4>

                        <div class="space-y-5">
                            @foreach($mealTypes as $mealKey => $mealLabel)
                                @php
                                    $meal = $dayMeals->firstWhere('meal_type', $mealKey);
                                @endphp
                                <div class="p-5 rounded-xl border border-gray-100 bg-gray-50 hover:bg-gray-100 transition">
                                    <p class="font-semibold text-gray-800">{{ $mealLabel }}</p>
                                    <p class="text-sm text-gray-600 mt-2 leading-relaxed">
                                        {{ $meal->notes ?? 'Henüz eklenmedi' }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end mt-12">
                <a href="{{ route('diet.index') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                    Geri
                </a>
            </div>
        </div>
    </div>
</x-app-layout> --}}

{{--- Akordiyon
@php
    $mealTypes = [
        'breakfast' => 'Kahvaltı',
        'snack'     => 'Ara Öğün',
        'lunch'     => 'Öğle Yemeği',
        'snack2'    => 'Ara Öğün',
        'dinner'    => 'Akşam Yemeği',
        'supper'    => 'Gece Yemeği',
        'other'     => 'Notlar',
    ];

    $days = [
        1 => 'Pazartesi',
        2 => 'Salı',
        3 => 'Çarşamba',
        4 => 'Perşembe',
        5 => 'Cuma',
        6 => 'Cumartesi',
        7 => 'Pazar',
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Diyet Planım - ') . $dietPlan->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100" x-data="{ openDay: null }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold text-gray-900 mb-10 text-center">Haftalık Öğünler</h3>

            <div class="space-y-4">
                @foreach($days as $dayNum => $dayName)
                    @php
                        $dayMeals = $dietPlan->meals->where('day_number', $dayNum);
                    @endphp

                    <div class="bg-white rounded-xl shadow border border-gray-200">
                        <!-- Gün Başlığı -->
                        <button
                            @click="openDay === {{ $dayNum }} ? openDay = null : openDay = {{ $dayNum }}"
                            class="w-full flex justify-between items-center px-6 py-4 text-lg font-semibold text-indigo-600 hover:bg-indigo-50 rounded-t-xl transition">
                            <span>{{ $dayName }}</span>
                            <svg :class="openDay === {{ $dayNum }} ? 'rotate-180' : ''" class="w-5 h-5 text-gray-500 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- İçerik -->
                        <div x-show="openDay === {{ $dayNum }}" x-collapse class="px-6 pb-6 space-y-4">
                            @foreach($mealTypes as $mealKey => $mealLabel)
                                @php
                                    $meal = $dayMeals->firstWhere('meal_type', $mealKey);
                                @endphp
                                <div class="p-4 rounded-lg border border-gray-100 bg-gray-50 hover:bg-gray-100 transition">
                                    <p class="font-semibold text-gray-800">{{ $mealLabel }}</p>
                                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">
                                        {{ $meal->notes ?? 'Henüz eklenmedi' }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end mt-12">
                <a href="{{ route('diet.index') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                    Geri
                </a>
            </div>
        </div>
    </div>
</x-app-layout>


--}}

