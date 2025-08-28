<x-guest-layout class="bg-gray-900 text-white">

    <x-auth-card class="bg-gray-800">

        <x-slot name="logo">
            <div class="text-center mb-6">
                <div class="text-4xl mb-2">🍏</div>
                <h2 class="text-2xl font-semibold text-black">Şifre Sıfırlama İsteği</h2>
                <p class="mt-1 text-sm text-black max-w-xs mx-auto">
                    Email adresinizi girin, size şifre sıfırlama bağlantısı göndereceğiz.
                </p>
            </div>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-green-400" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4 text-red-400" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" class="block mb-1 font-medium text-gray-300" />
                <x-input id="email" class="block w-full px-4 py-3 border border-gray-600 rounded-md bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    type="email" name="email" :value="old('email')" required autofocus placeholder="example@domain.com" />
            </div>

            <div class="flex justify-end">
                <x-button class="bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-400 focus:outline-none text-white font-semibold px-6 py-3 rounded-md shadow-md transition">
                    {{ __('Şifre Sıfırlama Linki Gönder') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>

</x-guest-layout>
