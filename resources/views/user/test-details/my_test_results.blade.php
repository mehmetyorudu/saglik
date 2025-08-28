<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Test Sonuçlarım
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 text-center">Tüm Test Denemeleriniz</h3>

                    @forelse ($attempts as $attempt)
                        <div class="mb-6 p-4 border border-gray-200 rounded-lg shadow-sm bg-gray-50">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                                <div class="mb-2 md:mb-0">
                                    <p class="text-lg font-semibold text-gray-800">{{ $attempt->test->title ?? 'Test Adı Yok' }}</p>
                                    <p class="text-sm text-gray-600">
                                        <span class="font-bold">Doğru:</span> <span class="text-green-600">{{ $attempt->correct_answers }}</span> /
                                        <span class="font-bold">Yanlış:</span> <span class="text-red-600">{{ $attempt->incorrect_answers }}</span>
                                    </p>
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $attempt->attempt_date->diffForHumans() }}
                                </div>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('user.test_attempt_detail', $attempt->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Detayları Görüntüle
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-600 text-center">Henüz tamamlanmış bir testiniz bulunmamaktadır.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
