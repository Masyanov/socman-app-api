<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SocMan') }}</title>
    <link rel="icon" href="{{ url('images/favicon.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
    />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/jquery.js', 'resources/js/app.js', 'resources/js/flowbite.js', 'resources/js/custom.js'])
</head>
<body class="antialiased">

<!-- component -->
<div class="relative isolate overflow-hidden bg-gray-900">
    <svg class="absolute inset-0 -z-10 h-full w-full stroke-white/10 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]" aria-hidden="true">
        <defs>
            <pattern id="983e3e4c-de6d-4c3f-8d64-b9761d1534cc" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                <path d="M.5 200V.5H200" fill="none" />
            </pattern>
        </defs>
        <svg x="50%" y="-1" class="overflow-visible fill-gray-800/20">
            <path d="M-200 0h201v201h-201Z M600 0h201v201h-201Z M-400 600h201v201h-201Z M200 800h201v201h-201Z" stroke-width="0" />
        </svg>
        <rect width="100%" height="100%" stroke-width="0" fill="url(#983e3e4c-de6d-4c3f-8d64-b9761d1534cc)" />
    </svg>
    <div class="absolute left-[calc(50%-4rem)] top-10 -z-10 transform-gpu blur-3xl sm:left-[calc(50%-18rem)] lg:left-48 lg:top-[calc(50%-30rem)] xl:left-[calc(50%-24rem)]" aria-hidden="true">
        <div class="aspect-[1108/632] w-[69.25rem] bg-gradient-to-r from-[#80caff] to-[#4f46e5] opacity-20" style="clip-path: polygon(73.6% 51.7%, 91.7% 11.8%, 100% 46.4%, 97.4% 82.2%, 92.5% 84.9%, 75.7% 64%, 55.3% 47.5%, 46.5% 49.4%, 45% 62.9%, 50.3% 87.2%, 21.3% 64.1%, 0.1% 100%, 5.4% 51.1%, 21.4% 63.9%, 58.9% 0.2%, 73.6% 51.7%)"></div>
    </div>
    <div class="mx-auto max-w-7xl px-6 pb-24 pt-10 sm:pb-32 lg:flex lg:px-8 lg:py-40">
        <div class="mx-auto max-w-2xl flex-shrink-0 lg:mx-0 lg:max-w-xl lg:pt-8">
            <x-application-logo class="block h-16 w-auto fill-current text-gray-800 dark:text-gray-200" />
            <div class="mt-24 sm:mt-32 lg:mt-16">
                <a href="#" class="inline-flex space-x-6">
                    <span class="rounded-full bg-indigo-500/10 px-3 py-1 text-sm font-semibold leading-6 text-cyan-500 ring-1 ring-inset ring-indigo-500/20">What's new</span>
                    <span class="inline-flex items-center space-x-2 text-sm font-medium leading-6 text-gray-300">
            <span>{{ __('messages.О нас') }}</span>
            <svg class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
            </svg>
          </span>
                </a>
            </div>
            <h1 class="mt-10 text-4xl font-bold tracking-tight text-white sm:text-6xl">{{ __('messages.Управляй футбольной командой с SocMan') }}</h1>
            <p class="mt-6 text-lg leading-8 text-gray-300">{{ __('messages.Все что нужно для управления футбольной командой в одном приложении') }}</p>
            <div class="mt-10 flex items-center gap-x-6">
                <a href="{{ route('login') }}" class="rounded-md bg-orange-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-400">{{ __('messages.Войти') }}</a>
                <a href="{{ route('register') }}" class="text-sm font-semibold leading-6 text-white">{{ __('messages.Регистрация') }} <span aria-hidden="true">→</span></a>
            </div>
        </div>
        <div class="mx-auto mt-16 flex max-w-2xl sm:mt-24 lg:ml-10 lg:mr-0 lg:mt-0 lg:max-w-none lg:flex-none xl:ml-32">
            <div class="max-w-3xl flex-none sm:max-w-5xl lg:max-w-none">
                <img src="https://spruko.com/demo/ren/demo/img/ltr-screens/screen2.jpg" alt="App screenshot" width="2432" height="1442" class="w-[76rem] rounded-md bg-white/5 shadow-2xl ring-1 ring-white/10">
            </div>
        </div>
    </div>
</div>

<!-- component -->
<div class="bg-white py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto grid max-w-2xl grid-cols-1 items-start gap-x-8 gap-y-16 sm:gap-y-24 lg:mx-0 lg:max-w-none lg:grid-cols-2">
            <div class="lg:pr-4">
                <div class="relative overflow-hidden rounded-3xl bg-gray-900 px-6 pb-9 pt-64 shadow-2xl sm:px-12 lg:max-w-lg lg:px-8 lg:pb-8 xl:px-10 xl:pb-10">
                    <img class="absolute inset-0 h-full w-full object-cover brightness-125 saturate-0" src="https://images.unsplash.com/photo-1630569267625-157f8f9d1a7e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2669&q=80" alt="">
                    <div class="absolute inset-0 bg-gray-900 mix-blend-multiply"></div>
                    <div class="absolute left-1/2 top-1/2 -ml-16 -translate-x-1/2 -translate-y-1/2 transform-gpu blur-3xl" aria-hidden="true">
                        <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-40" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
                    </div>
                    <figure class="relative isolate">
                        <svg viewBox="0 0 162 128" fill="none" aria-hidden="true" class="absolute -left-2 -top-4 -z-10 h-32 stroke-white/20">
                            <path id="0ef284b8-28c2-426e-9442-8655d393522e" d="M65.5697 118.507L65.8918 118.89C68.9503 116.314 71.367 113.253 73.1386 109.71C74.9162 106.155 75.8027 102.28 75.8027 98.0919C75.8027 94.237 75.16 90.6155 73.8708 87.2314C72.5851 83.8565 70.8137 80.9533 68.553 78.5292C66.4529 76.1079 63.9476 74.2482 61.0407 72.9536C58.2795 71.4949 55.276 70.767 52.0386 70.767C48.9935 70.767 46.4686 71.1668 44.4872 71.9924L44.4799 71.9955L44.4726 71.9988C42.7101 72.7999 41.1035 73.6831 39.6544 74.6492C38.2407 75.5916 36.8279 76.455 35.4159 77.2394L35.4047 77.2457L35.3938 77.2525C34.2318 77.9787 32.6713 78.3634 30.6736 78.3634C29.0405 78.3634 27.5131 77.2868 26.1274 74.8257C24.7483 72.2185 24.0519 69.2166 24.0519 65.8071C24.0519 60.0311 25.3782 54.4081 28.0373 48.9335C30.703 43.4454 34.3114 38.345 38.8667 33.6325C43.5812 28.761 49.0045 24.5159 55.1389 20.8979C60.1667 18.0071 65.4966 15.6179 71.1291 13.7305C73.8626 12.8145 75.8027 10.2968 75.8027 7.38572C75.8027 3.6497 72.6341 0.62247 68.8814 1.1527C61.1635 2.2432 53.7398 4.41426 46.6119 7.66522C37.5369 11.6459 29.5729 17.0612 22.7236 23.9105C16.0322 30.6019 10.618 38.4859 6.47981 47.558L6.47976 47.558L6.47682 47.5647C2.4901 56.6544 0.5 66.6148 0.5 77.4391C0.5 84.2996 1.61702 90.7679 3.85425 96.8404L3.8558 96.8445C6.08991 102.749 9.12394 108.02 12.959 112.654L12.959 112.654L12.9646 112.661C16.8027 117.138 21.2829 120.739 26.4034 123.459L26.4033 123.459L26.4144 123.465C31.5505 126.033 37.0873 127.316 43.0178 127.316C47.5035 127.316 51.6783 126.595 55.5376 125.148L55.5376 125.148L55.5477 125.144C59.5516 123.542 63.0052 121.456 65.9019 118.881L65.5697 118.507Z" />
                            <use href="#0ef284b8-28c2-426e-9442-8655d393522e" x="86" />
                        </svg>
                        <blockquote class="mt-6 text-xl font-semibold leading-8 text-white">
                            <p>“"What happens is not as important as how you react to what happens." "The journey of a thousand miles begins with one step." "The only true wisdom is in knowing you know nothing." "Just as treasures are uncovered from the earth, so virtue appears from good deeds, and wisdom appears from a pure and peaceful mind..”</p>
                        </blockquote>
                        <figcaption class="mt-6 text-sm leading-6 text-gray-300"><strong class="font-semibold text-white">Shehab Najib,</strong> ceo of ISREN</figcaption>
                    </figure>
                </div>
            </div>
            <div>
                <div class="text-base leading-7 text-gray-700 lg:max-w-lg">
                    <p class="text-base font-semibold leading-7 text-yellow-400">wisdom values</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Peaceful minds</h1>
                    <div class="max-w-xl">
                        <p class="mt-6">You won't ever have a peaceful mind unless you have a peace ful life and equal times you have a time with your religion then time for fun then time for work and study.</p>
                        <p class="mt-8">You want to have a peaceful day try ignoring problems that are blamed on you but you are sure you didn't do the mistake.</p>
                        <p class="mt-8">Try dividing your life days into equal times and do every thing on it's time.</p>
                    </div>
                </div>
                <dl class="mt-10 grid grid-cols-2 gap-8 border-t border-gray-900/10 pt-10 sm:grid-cols-4">
                    <div>
                        <dt class="text-sm font-semibold leading-6 text-gray-600">Founded</dt>
                        <dd class="mt-2 text-3xl font-bold leading-10 tracking-tight text-gray-900">end of 2023</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-semibold leading-6 text-gray-600">Employees</dt>
                        <dd class="mt-2 text-3xl font-bold leading-10 tracking-tight text-gray-900">uncounted</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-semibold leading-6 text-gray-600">Countries</dt>
                        <dd class="mt-2 text-3xl font-bold leading-10 tracking-tight text-gray-900">2</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-semibold leading-6 text-gray-600">Raised</dt>
                        <dd class="mt-2 text-3xl font-bold leading-10 tracking-tight text-gray-900">$1.5K</dd>
                    </div>
                </dl>
                <div class="mt-10 flex">
                    <a href="#" class="text-base font-semibold leading-7 text-yellow-500">Learn more about our company <span aria-hidden="true">&rarr;</span></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- component -->
<div class="antialiased w-full h-full bg-black text-gray-400 font-inter p-10">
    <div class="container px-4 mx-auto">
        <div>
            <div id="title" class="text-center my-10">
                <h1 class="font-bold text-4xl text-white">Pricing Plans</h1>
                <p class="text-light text-gray-500 text-xl">
                    Here are our pricing plans
                </p>
            </div>
            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 justify-evenly gap-10 pt-10"
            >
                <div
                    id="plan"
                    class="rounded-lg text-center overflow-hidden w-full transform hover:shadow-2xl hover:scale-105 transition duration-200 ease-in"
                >
                    <div id="title" class="w-full py-5 border-b border-gray-800">
                        <h2 class="font-bold text-3xl text-white">Startup</h2>
                        <h3 class="font-normal text-indigo-500 text-xl mt-2">
                            $9<sup>,99</sup>/month
                        </h3>
                    </div>
                    <div id="content" class="">
                        <div id="icon" class="my-5">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-12 w-12 mx-auto fill-stroke text-indigo-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                />
                            </svg>
                            <p class="text-gray-500 text-sm pt-2">
                                Perfect individuals or startups
                            </p>
                        </div>
                        <div id="contain" class="leading-8 mb-10 text-lg font-light">
                            <ul>
                                <li>10 hours of support</li>
                                <li>128MB of storage</li>
                                <li>2048MB bandwith</li>
                                <li>Subdomain included</li>
                            </ul>
                            <div id="choose" class="w-full mt-10 px-6">
                                <a
                                    href="#"
                                    class="w-full block bg-gray-900 font-medium text-xl py-4 rounded-xl hover:shadow-lg transition duration-200 ease-in-out hover:bg-indigo-600 hover:text-white"
                                >Choose</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    id="plan"
                    class="rounded-lg text-center overflow-hidden w-full transform hover:shadow-2xl hover:scale-105 transition duration-200 ease-in"
                >
                    <div id="title" class="w-full py-5 border-b border-gray-800">
                        <h2 class="font-bold text-3xl text-white">Corporate</h2>
                        <h3 class="font-normal text-indigo-500 text-xl mt-2">
                            $12<sup>,99</sup>/month
                        </h3>
                    </div>
                    <div id="content" class="">
                        <div id="icon" class="my-5">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-12 w-12 mx-auto fill-stroke text-indigo-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"
                                />
                            </svg>
                            <p class="text-gray-500 text-sm pt-2">
                                Perfect for teams up to 12 people
                            </p>
                        </div>
                        <div id="contain" class="leading-8 mb-10 text-lg font-light">
                            <ul>
                                <li>10 hours of support</li>
                                <li>1024MB of storage</li>
                                <li>4GB bandwith</li>
                                <li>Domain included</li>
                            </ul>
                            <div id="choose" class="w-full mt-10 px-6">
                                <a
                                    href="#"
                                    class="w-full block bg-gray-900 font-medium text-xl py-4 rounded-xl hover:shadow-lg transition duration-200 ease-in-out hover:bg-indigo-600 hover:text-white"
                                >Choose</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    id="plan"
                    class="rounded-lg text-center overflow-hidden w-full transform hover:shadow-2xl hover:scale-105 transition duration-200 ease-in"
                >
                    <div id="title" class="w-full py-5 border-b border-gray-800">
                        <h2 class="font-bold text-3xl text-white">Enterprise</h2>
                        <h3 class="font-normal text-indigo-500 text-xl mt-2">
                            $19<sup>,99</sup>/month
                        </h3>
                    </div>
                    <div id="content" class="">
                        <div id="icon" class="my-5">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-12 w-12 mx-auto fill-stroke text-indigo-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                                />
                            </svg>
                            <p class="text-gray-500 text-sm pt-2">
                                Perfect large scale team
                            </p>
                        </div>
                        <div id="contain" class="leading-8 mb-10 text-lg font-light">
                            <ul>
                                <li>10 hours of support</li>
                                <li>10GB of storage</li>
                                <li>100GB bandwith</li>
                                <li>Domain included</li>
                            </ul>
                            <div id="choose" class="w-full mt-10 px-6">
                                <a
                                    href="#"
                                    class="w-full block bg-gray-900 font-medium text-xl py-4 rounded-xl hover:shadow-lg transition duration-200 ease-in-out hover:bg-indigo-600 hover:text-white"
                                >Choose</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
