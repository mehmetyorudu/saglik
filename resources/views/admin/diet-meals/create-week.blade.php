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

    function getDefaultOrder($mealTypeKey) {
        switch ($mealTypeKey) {
            case 'breakfast': return 1;
            case 'snack': return 2;
            case 'lunch': return 3;
            case 'dinner': return 4;
            case 'supper': return 5;
            case 'other' : return 6;
            default: return 7;
        }
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Haftalık Öğünleri Ekle - ') . $dietPlan->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6 space-y-6">

                @if(session('success'))
                    <div class="p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.diet-plans.diet-meals.update-week', $dietPlan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

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
                                    $dayMeals = $meals->where('day_number', $dayNum);
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-3 py-2 font-semibold text-center bg-indigo-100 text-indigo-800">{{ $dayName }}</td>
                                    @foreach($mealTypes as $mealKey => $mealLabel)
                                        @php
                                            $meal = $dayMeals->firstWhere('meal_type', $mealKey);
                                        @endphp
                                        <td class="border px-2 py-2 align-top">
                                            <div class="relative flex flex-col h-full">
                                                    <textarea name="meals[{{ $dayNum }}][{{ $mealKey }}][notes]"
                                                              rows="4"
                                                              class="w-full border border-gray-300 rounded-lg px-2 py-1 text-sm resize-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500"
                                                              placeholder="Yemekleri buraya yaz">{{ $meal->notes ?? '' }}</textarea>

                                                <input type="hidden" name="meals[{{ $dayNum }}][{{ $mealKey }}][id]" value="{{ $meal->id ?? '' }}">
                                                <input type="hidden" name="meals[{{ $dayNum }}][{{ $mealKey }}][meal_type]" value="{{ $mealKey }}">
                                                <input type="hidden" name="meals[{{ $dayNum }}][{{ $mealKey }}][day_number]" value="{{ $dayNum }}">
                                                <input type="hidden" name="meals[{{ $dayNum }}][{{ $mealKey }}][order]" value="{{ getDefaultOrder($mealKey) }}">
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

                    <div class="flex justify-end space-x-2 mt-6">
                        <a href="{{ route('admin.diet-plans.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Geri</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Kaydet</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
