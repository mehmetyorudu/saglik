<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

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
    <div class="w-full max-w-sm bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
        <div class="text-center mb-6">
            <div class="text-xl mb-2">🍏</div>
            <h2 class="text-xl font-bold">Hoş geldiniz</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Lütfen giriş yapınız</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required autofocus>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium mb-1">Şifre</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="rounded text-blue-600 dark:bg-gray-700 dark:border-gray-600">
                    <span class="ml-2 text-sm">Beni hatırla</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Şifremi unuttum</a>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                Giriş Yap
            </button>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Hesabınız yok mu?
                    <a href="{{ route('register') }}" class="ml-1 inline-block text-blue-600 hover:underline font-medium">
                        Kayıt olun
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>

</body>
</html>
