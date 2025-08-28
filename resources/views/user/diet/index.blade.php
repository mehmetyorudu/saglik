<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Diyet Listem') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Diyet Planlarım</h3>

                @forelse ($dietPlans as $plan)
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md border border-gray-200 mb-4">
                        <h4 class="text-xl font-semibold text-gray-800 mb-2">
                            <a href="{{ route('diet.show', $plan->id) }}" class="text-indigo-600 hover:text-indigo-800">
                                {{ $plan->title }}
                            </a>
                        </h4>
                        <p class="text-gray-700 text-sm mb-3">
                            {{ $plan->description ?? 'Açıklama yok' }}
                        </p>
                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <span>Doktor: {{ $plan->doctor->name ?? '-' }}</span>
                            <span>{{ $plan->created_at->format('d.m.Y') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md border border-gray-200 text-center text-gray-600">
                        Henüz bir diyet planınız bulunmamaktadır.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
