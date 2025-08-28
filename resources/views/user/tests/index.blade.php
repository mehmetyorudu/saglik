<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Testler') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

                {{-- Başlık ve Buton --}}
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Mevcut Testler</h3>
                    <a href="{{ route('user.my_test_results') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">
                        {{ __('Sonuçlarım') }}
                    </a>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @forelse ($tests as $test)
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md border border-gray-200 mb-4">
                        <h4 class="text-xl font-semibold text-gray-800 mb-2">{{ $test->title }}</h4>
                        <p class="text-gray-700 text-sm mb-3">
                            {{ Str::limit($test->description, 150) ?? 'Açıklama bulunmamaktadır.' }}
                        </p>
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span>Oluşturan: {{ $test->user->name }}</span>
                            <span>Soru Sayısı: {{ $test->questions->count() }}</span>
                            @if ($test->questions->count() > 0)
                                <a href="{{ route('tests.take', $test) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Testi Çöz
                                </a>
                            @else
                                <span class="text-red-500">Soru yok</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md border border-gray-200 text-center text-gray-600">
                        Henüz hiç test bulunmamaktadır.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
