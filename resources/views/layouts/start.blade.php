<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Поисковая оптимизация -->
    <title>{{ __('messages.Управление спортивной командой просто и удобно | SocMan') }}</title>
    <meta name="description" content="SportControl — приложение для тренера командных видов спорта, которое упрощает учет спортсменов и планирование тренировок. Всё в одном приложении для вашей спортивной команды."/>
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://load-control.ru/" />
    <meta property="og:locale" content="ru_RU" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Управление спортивной командой просто и удобно | SportControl" />
    <meta property="og:description" content="SportControl — приложение для тренера командных видов спорта, которое упрощает учет спортсменов и планирование тренировок. Всё в одном приложении для вашей спортивной команды." />
    <meta property="og:url" content="https://load-control.ru/" />
    <meta property="og:site_name" content="Управление спортивной командой просто и удобно | SportControl" />
    <meta property="og:updated_time" content="2025-06-15T01:04:38+03:00" />
    <meta property="og:image" content="/images/screen.jpg" />
    <meta property="og:image:secure_url" content="/images/screen.jpg" />
    <meta property="og:image:width" content="640" />
    <meta property="og:image:height" content="770" />
    <meta property="og:image:alt" content="SportControl" />
    <meta property="og:image:type" content="image/png" />
    <meta property="article:published_time" content="2024-01-29T12:09:05+03:00" />
    <meta property="article:modified_time" content="2025-06-15T01:04:38+03:00" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Управление спортивной командой просто и удобно | SportControl" />
    <meta name="twitter:description" content="SportControl — приложение для тренера командных видов спорта, которое упрощает учет спортсменов и планирование тренировок. Всё в одном приложении для вашей спортивной команды." />
    <meta name="twitter:image" content="/images/screen.jpg" />
    <meta name="twitter:label1" content="Автор" />
    <meta name="twitter:data1" content="masyanov" />
    <meta name="twitter:label2" content="Время чтения" />
    <meta name="twitter:data2" content="Меньше минуты" />
    <!-- /SEO -->
    <meta name="yandex-verification" content="07ba4fe0adb4fad2" />

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m,e,t,r,i,k,a){
            m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
        })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=103806977', 'ym');

        ym(103806977, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", accurateTrackBounce:true, trackLinks:true});
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/103806977" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SocMan') }}</title>
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
                <div class="flex items-center lg:order-2">
                    <button data-modal-target="subscriptionModal" data-modal-toggle="subscriptionModal"
                            class="me-3 bg-indigo-500 hover:bg-rose-500 text-white px-4 py-2 rounded"
                            title="Заказать подписку">
                        Купить
                    </button>
                    <a href="{{ route('login') }}"
                       class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        {{ __('messages.Войти') }}
                    </a>


                    <button data-collapse-toggle="mobile-menu-2" type="button"
                            class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                            aria-controls="mobile-menu-2" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                    <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                        <li>
                            <a href="#about"
                               class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">
                                О приложении
                            </a>
                        </li>
                        <li>
                            <a href="#price"
                               class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">
                                Цены
                            </a>
                        </li>
                        <li>
                            <a href="#steps"
                               class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">
                                Как получить
                            </a>
                        </li>
                        <li>
                            <a href="#faq"
                               class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">
                                FAQ
                            </a>
                        </li>

                    </ul>
                </div>
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
                    <a href="/oferta" target="_blank" class="text-xs text-white hover:text-indigo-500" title="{{ __('messages.Оферта') }}">{{ __('messages.Оферта') }}</a>
                    <a href="/policy" target="_blank" class="text-xs text-white hover:text-indigo-500" title="{{ __('messages.Политика конфиденциальности') }}">{{ __('messages.Политика конфиденциальности') }}</a>
                    <a href="/rules" target="_blank" class="text-xs text-white hover:text-indigo-500" title="{{ __('messages.Пользовательское соглашение') }}">{{ __('messages.Пользовательское соглашение') }}</a>
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
@include('components.subscription-modal')


