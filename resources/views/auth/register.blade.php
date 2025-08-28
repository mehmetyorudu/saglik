<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kayıt Ol</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white">

<div class="relative flex items-center justify-center min-h-screen">

    <div class="w-full max-w-4xl bg-white dark:bg-gray-800 rounded-xl shadow-lg p-10">
        <div class="text-center mb-8">
            <div class="text-3xl mb-2">🍏</div>
            <h2 class="text-2xl font-bold">Kayıt Olun</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Lütfen bilgilerinizi girin</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 text-sm text-red-600">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium mb-1">Ad Soyad</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" required autofocus>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium mb-1">Şifre</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium mb-1">Şifreyi Onayla</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="age" class="block text-sm font-medium mb-1">Yaş</label>
                    <input type="number" name="age" id="age" value="{{ old('age') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" required min="1">
                </div>

                <div>
                    <label for="height" class="block text-sm font-medium mb-1">Boy (cm)</label>
                    <input type="number" name="height" id="height" value="{{ old('height') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" required min="1">
                </div>

                <div>
                    <label for="weight" class="block text-sm font-medium mb-1">Kilo (kg)</label>
                    <input type="number" name="weight" id="weight" value="{{ old('weight') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" required min="1">
                </div>

                <div>
                    <label for="waist_circumference" class="block text-sm font-medium mb-1">Bel Çevresi (cm)</label>
                    <input type="number" name="waist_circumference" id="waist_circumference" value="{{ old('waist_circumference') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500" required min="1">
                </div>
            </div>

            <div class="flex items-center justify-between mt-8">
                <a href="{{ url('/') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-400 dark:hover:text-white">
                    Zaten hesabınız var mı?
                </a>

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Kayıt Ol
                </button>
            </div>
        </form>
    </div>

</div>
</body>
</html>
