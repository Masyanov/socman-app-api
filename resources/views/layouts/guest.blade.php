<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ config('app.name', 'SportControl') }}</title>
    <link rel="icon" href="{{ url('images/logo_sc.png') }}">
    <link rel="icon" href="{{ url('images/logo_sc.png') }}" type="image/svg+xml">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <link href="{{ asset('src/fontawesome.min.css') }}" rel="stylesheet"/>
    <script src="{{ asset('src/jquery.min.js') }}" type="text/javascript"></script>
    <!-- Fancybox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body class="font-sans antialiased">
<div class="min-h-screen flex flex-col bg-gray-100 dark:bg-gray-900">
    <header class="fixed top-0 z-10 w-full">
        <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800">
            <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                <x-application-logo class="block h-16 w-auto fill-current text-gray-800 dark:text-gray-200"/>
            </div>
        </nav>
    </header>

    <!-- Page Content -->
    <main  class="flex-1">
        {{ $slot }}
    </main>
    <footer class="w-full p-4  bg-gray-900">
        <div class="bg-white rounded-lg shadow-sm  dark:bg-gray-800">
            <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
                <div class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ date('Y') }} <a
                        href="https://load-control.ru/" class="hover:underline">SportControl™</a>. Все права защищены.
                </div>
                <div class="grid grid-cols-1 gap-3 py-6 sm:space-x-8 sm:space-y-0 rtl:space-x-reverse md:gap-6 md:grid-cols-3">
                    <a href="/oferta" target="_blank" class="text-xs text-white hover:text-indigo-500" title="Оферта">Оферта</a>
                    <a href="/policy" target="_blank" class="text-xs text-white hover:text-indigo-500" title="Политика конфиденциальности">Политика конфиденциальности</a>
                    <a href="/rules" target="_blank" class="text-xs text-white hover:text-indigo-500" title="Пользовательское соглашение">Пользовательское соглашение</a>
                </div>
                <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                    <li>
                        <a href="https://t.me/masyanov" class="flex gap-3 align-items-center" target="_blank"
                           title="Напишите нам в телеграм">
                            <svg width="30" height="30" viewBox="0 0 100 100" version="1.1" xml:space="preserve"
                                 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <style type="text/css">
                                        .st117 {
                                            fill: #1B92D1;
                                        } </style>
                                    <g id="Layer_1"></g>
                                    <g id="Layer_2">
                                        <g>
                                            <path class="st117"
                                                  d="M88.723,12.142C76.419,17.238,23.661,39.091,9.084,45.047c-9.776,3.815-4.053,7.392-4.053,7.392 s8.345,2.861,15.499,5.007c7.153,2.146,10.968-0.238,10.968-0.238l33.62-22.652c11.922-8.107,9.061-1.431,6.199,1.431 c-6.199,6.2-16.452,15.975-25.036,23.844c-3.815,3.338-1.908,6.199-0.238,7.63c6.199,5.246,23.129,15.976,24.082,16.691 c5.037,3.566,14.945,8.699,16.452-2.146c0,0,5.961-37.435,5.961-37.435c1.908-12.637,3.815-24.321,4.053-27.659 C97.307,8.804,88.723,12.142,88.723,12.142z"></path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
    <button id="backToTop"
            class="hidden fixed bottom-6 right-6 bg-indigo-500 text-white p-3 rounded-full shadow-lg transition-opacity duration-300 hover:bg-rose-500"
            aria-label="Наверх">
        ↑
    </button>
</div>
</body>


