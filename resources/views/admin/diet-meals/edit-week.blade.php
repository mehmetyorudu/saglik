<x-app-layout>
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

        function getDefaultOrder($mealTypeKey) {
            switch($mealTypeKey) {
                case 'breakfast': return 1;
                case 'snack':     return 2;
                case 'lunch':     return 3;
                case 'snack2':    return 4;
                case 'dinner':    return 5;
                case 'supper':    return 6;
                case 'other':     return 7;
                default:          return 8;
            }
        }
    @endphp

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Haftalık Öğünleri Düzenle - ') . $dietPlan->title . ' - ' }}
            @if($dietPlan->user)
                {{ $dietPlan->user->name }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100" x-data="mealWeekList()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6 space-y-6">

                @if(session('success'))
                    <div class="p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Butonlar ve Form Alanı --}}
                <div class="flex items-center justify-end space-x-4 mb-6">
                    <button type="button" @click="selectAllCheckboxes()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Tümünü Seç</button>

                    <button type="button" @click="openBulkDeleteModal()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Seçili Öğünleri Sil</button>
                </div>

                {{-- Güncelleme Formu --}}
                <form action="{{ route('admin.diet-plans.diet-meals.update-week', $dietPlan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-gray-700 text-sm">
                            <thead class="bg-indigo-600 text-white">
                            <tr>
                                <th class="border px-3 py-2 w-24 text-center">Gün</th>
                                @foreach($mealTypes as $mealLabel)
                                    <th class="border px-3 py-2 text-center">{{ $mealLabel }}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($days as $dayNum => $dayName)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-3 py-2 font-semibold text-center bg-indigo-100 text-indigo-800">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="day-checkbox-{{ $dayNum }}" class="form-checkbox text-indigo-600 rounded mr-2" onclick="toggleDayCheckboxes({{ $dayNum }})">
                                            {{ $dayName }}
                                        </div>
                                    </td>
                                    @foreach($mealTypes as $mealKey => $mealLabel)
                                        @php
                                            $meal = $meals->where('day_number', $dayNum)->where('meal_type', $mealKey)->first();
                                        @endphp
                                        <td class="border px-2 py-2 align-top">
                                            <div class="flex flex-col space-y-1" @if($meal) data-meal-id="{{ $meal->id }}" @endif>
                                                    <textarea name="meals[{{ $dayNum }}][{{ $mealKey }}][notes]"
                                                              rows="4"
                                                              class="w-full border border-gray-300 rounded-lg px-2 py-1 text-sm resize-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500"
                                                              placeholder="Yemekleri buraya yaz">{{ $meal->notes ?? '' }}</textarea>

                                                <input type="hidden" name="meals[{{ $dayNum }}][{{ $mealKey }}][id]" value="{{ $meal->id ?? '' }}">
                                                <input type="hidden" name="meals[{{ $dayNum }}][{{ $mealKey }}][meal_type]" value="{{ $mealKey }}">
                                                <input type="hidden" name="meals[{{ $dayNum }}][{{ $mealKey }}][day_number]" value="{{ $dayNum }}">
                                                <input type="hidden" name="meals[{{ $dayNum }}][{{ $mealKey }}][order]" value="{{ getDefaultOrder($mealKey) }}">

                                                @if($meal)
                                                    <div class="flex justify-between items-center text-sm mt-1">
                                                        <label for="bulk-delete-{{ $meal->id }}" class="cursor-pointer text-red-600 hover:text-red-700 flex items-center">
                                                            <input type="checkbox"
                                                                   name="selected_meals[]"
                                                                   value="{{ $meal->id }}"
                                                                   id="bulk-delete-{{ $meal->id }}"
                                                                   form="bulk-delete-form"
                                                                   class="form-checkbox text-red-600 rounded mr-1 day-{{ $dayNum }}-checkbox">
                                                            Sil
                                                        </label>

                                                        <button type="button"
                                                                @click="openDeleteModal({{ $meal->id }}, '{{ addslashes($meal->notes ?? '') }}')"
                                                                class="text-red-600 hover:underline">
                                                            Sil
                                                        </button>
                                                    </div>
                                                @endif
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

                {{-- Toplu Silme Formu (Gizli) --}}
                <form id="bulk-delete-form" action="{{ route('admin.diet-plans.diet-meals.bulk-destroy', $dietPlan->id) }}" method="POST" class="m-0 p-0" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>

        <div x-show="showSingleConfirm" x-transition style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-96 max-w-full shadow-lg">
                <h2 class="text-lg font-semibold mb-4 text-red-600">Öğünü Sil</h2>
                <p class="mb-6">"<span x-text="deleteTitle"></span>" öğününü silmek istediğinize emin misiniz?</p>
                <div class="flex justify-end space-x-4">
                    <button @click="showSingleConfirm = false" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">İptal</button>
                    <button @click="submitSingleDelete()" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Sil</button>
                </div>
            </div>
        </div>

        <div x-show="showBulkConfirm" x-transition style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-96 max-w-full shadow-lg">
                <h2 class="text-lg font-semibold mb-4 text-red-600">Seçili Öğünleri Sil</h2>
                <p class="mb-6">Seçtiğiniz <strong x-text="bulkDeleteCount">0</strong> adet öğünü silmek istediğinize emin misiniz?</p>
                <div class="flex justify-end space-x-4">
                    <button @click="showBulkConfirm = false" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">İptal</button>
                    <button @click="submitBulkDelete()" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Sil</button>
                </div>
            </div>
        </div>

        <div x-show="showNoSelectionModal" x-transition style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-96 max-w-full shadow-lg">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Silinecek Öğün Yok</h2>
                <p class="mb-6">Lütfen silmek istediğiniz öğünleri seçin.</p>
                <div class="flex justify-end space-x-4">
                    <button @click="showNoSelectionModal = false" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Tamam</button>
                </div>
            </div>
        </div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        function mealWeekList() {
            return {
                showSingleConfirm: false,
                showBulkConfirm: false,
                showNoSelectionModal: false,
                deleteId: null,
                deleteTitle: '',
                bulkDeleteCount: 0,

                openDeleteModal(id, title) {
                    this.deleteId = id;
                    this.deleteTitle = title;
                    this.showSingleConfirm = true;
                },

                openBulkDeleteModal() {
                    const checkedBoxes = document.querySelectorAll('input[name="selected_meals[]"]:checked');

                    if (checkedBoxes.length === 0) {
                        this.showNoSelectionModal = true;
                        return;
                    }

                    this.bulkDeleteCount = checkedBoxes.length;
                    this.showBulkConfirm = true;
                },

                submitSingleDelete() {
                    this.showSingleConfirm = false;
                    const url = '{{ route("admin.diet-plans.diet-meals.destroy", [$dietPlan->id, ":id"]) }}'.replace(':id', this.deleteId);
                    const token = document.querySelector('meta[name="csrf-token"]').content;

                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        }
                    })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                window.location.reload();
                            } else {
                                alert('Silme başarısız');
                            }
                        })
                        .catch(e => console.error(e));
                },

                submitBulkDelete() {
                    this.showBulkConfirm = false;
                    document.getElementById('bulk-delete-form').submit();
                },

                selectAllCheckboxes() {
                    const allCheckboxes = document.querySelectorAll('input[name="selected_meals[]"]');
                    const anyUnchecked = Array.from(allCheckboxes).some(checkbox => !checkbox.checked);
                    const shouldCheck = anyUnchecked;

                    allCheckboxes.forEach(checkbox => {
                        checkbox.checked = shouldCheck;
                    });
                }
            }
        }

        function toggleDayCheckboxes(dayNum) {
            const dayCheckbox = document.getElementById('day-checkbox-' + dayNum);
            const checkboxes = document.querySelectorAll('.day-' + dayNum + '-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = dayCheckbox.checked;
            });
        }
    </script>
</x-app-layout>
