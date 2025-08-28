<x-guest-layout>


    <x-auth-card>
        <x-slot name="logo">
            <div class="text-center mb-6">
                <div class="text-3xl mb-2">🍏</div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Şifre Sıfırlama</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Yeni şifrenizi belirleyin</p>
            </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="md:col-span-2">
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" class="block mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500"
                    type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </div>

            <!-- Password -->
            <div>
                <x-label for="password" :value="__('Yeni Şifre')" />
                <x-input id="password" class="block mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500"
                    type="password" name="password" required />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-label for="password_confirmation" :value="__('Şifreyi Onayla')" />
                <x-input id="password_confirmation" class="block mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500"
                    type="password" name="password_confirmation" required />
            </div>

            <div class="md:col-span-2 flex justify-end mt-4">
                <x-button class="bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                    {{ __('Şifreyi Sıfırla') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
    

    @stack('scripts')
    <script src="{{ mix('js/app.js') }}"></script>

</x-guest-layout>
