<x-start-layout>
    <!-- component -->
    <div class="relative h-full isolate bg-gray-900">
        <svg
            class="absolute inset-0 -z-10 h-full w-full stroke-white/10 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]"
            aria-hidden="true">
            <defs>
                <pattern id="983e3e4c-de6d-4c3f-8d64-b9761d1534cc" width="200" height="200" x="50%" y="-1"
                         patternUnits="userSpaceOnUse">
                    <path d="M.5 200V.5H200" fill="none"/>
                </pattern>
            </defs>
            <svg x="50%" y="-1" class="overflow-visible fill-gray-800/20">
                <path d="M-200 0h201v201h-201Z M600 0h201v201h-201Z M-400 600h201v201h-201Z M200 800h201v201h-201Z"
                      stroke-width="0"/>
            </svg>
            <rect width="100%" height="100%" stroke-width="0" fill="url(#983e3e4c-de6d-4c3f-8d64-b9761d1534cc)"/>
        </svg>
        <section class="overflow-hidden" id="home">
            <div class="h-screen mx-auto max-w-7xl pb-24 pt-10 px-5 sm:px-0 sm:pb-32 lg:flex lg:py-40">
                <div class="mx-auto max-w-2xl flex-shrink-0 lg:mx-0 lg:max-w-xl lg:pt-8">
                    <h1 class="mt-24 text-4xl font-bold tracking-tight text-white sm:text-6xl">{{ __('messages.Управляй спортивной командой с') }}
                        <div
                            class="bg-clip-text bg-gradient-to-r from-rose-800 to-indigo-500 inline-block text-transparent">
                            SportControl
                        </div>
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-gray-300">{{ __('messages.Все что нужно для управления спортивной командой в одном приложении') }}</p>
                    <div class="mt-10 flex items-center gap-x-6">
                        <button data-modal-target="subscriptionModal" data-modal-toggle="subscriptionModal"
                                class="me-3 bg-indigo-500 hover:bg-rose-500 text-white px-4 py-2 rounded"
                                title="{{ __('messages.Заказать подписку') }}">
                            {{ __('messages.Заказать подписку') }}
                        </button>
                    </div>
                </div>
                <div
                    class="mx-auto mt-16 flex max-w-2xl sm:mt-24 lg:ml-10 lg:mr-0 lg:mt-0 lg:max-w-none lg:flex-none xl:ml-32">
                    <div class="max-w-3xl flex-none sm:max-w-5xl lg:max-w-none">
                        <img src="/images/screen.jpg" alt="SportControl" width="2432" height="1442"
                             class="h-72 object-cover object-top w-[26rem] lg:w-[56rem] lg:h-full rounded-md bg-white/5 shadow-2xl ring-1 ring-white/10">
                    </div>
                </div>
            </div>
        </section>
        <section class="text-gray-400 body-font scroll-mt-20" id="about">
            <div class="container px-5 py-12 mx-auto">
                <div class="flex flex-col">
                    <div class="h-1 bg-gray-800 rounded overflow-hidden">
                        <div class="w-24 h-full bg-indigo-500"></div>
                    </div>
                    <div class="flex flex-wrap sm:flex-row flex-col py-6 mb-12">
                        <h1 class="sm:w-2/5 text-white font-medium title-font text-2xl mb-2 sm:mb-0">{{ __('messages.welcome_about_title') }}</h1>
                        <p class="sm:w-3/5 leading-relaxed text-base sm:pl-10 pl-0">{{ __('messages.welcome_about_text') }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-6 sm:-m-4 -mx-4 -mb-3 -mt-4 lg:grid-cols-3">
                    <div class="p-4 md:w-full sm:mb-0">
                        <div class="rounded-lg h-64 overflow-hidden">
                            <a data-fancybox class="w-full h-full"
                               href="/images/1755245941380.jpg">
                                <img src="/images/1755245941380.jpg"
                                     alt="{{ __('messages.welcome_feature_athletes') }}"
                                     class="object-cover object-left-top h-full w-full">
                            </a>
                        </div>
                        <h2 class="text-xl font-medium title-font text-white mt-5">{{ __('messages.welcome_feature_athletes') }}</h2>
                        <p class="text-base leading-relaxed mt-2">{{ __('messages.welcome_feature_athletes_desc') }}</p>
                    </div>
                    <div class="p-4 md:w-full sm:mb-0">
                        <div class="rounded-lg h-64 overflow-hidden">
                            <a data-fancybox class="w-full h-full"
                               href="/images/1755246042668.jpg">
                                <img src="/images/1755246042668.jpg"
                                     alt="{{ __('messages.welcome_feature_planning') }}"
                                     class="object-cover object-left-top h-full w-full">
                            </a>
                        </div>
                        <h2 class="text-xl font-medium title-font text-white mt-5">{{ __('messages.welcome_feature_planning') }}</h2>
                        <p class="text-base leading-relaxed mt-2">{{ __('messages.welcome_feature_planning_desc') }}</p>

                    </div>
                    <div class="p-4 md:w-full sm:mb-0">
                        <div class="rounded-lg h-64 overflow-hidden">
                            <a data-fancybox class="w-full h-full"
                               href="/images/1755245037150.jpg">
                                <img src="/images/1755245037150.jpg"
                                     alt="{{ __('messages.welcome_feature_attendance') }}"
                                     class="object-cover object-left-top h-full w-full">
                            </a>
                        </div>
                        <h2 class="text-xl font-medium title-font text-white mt-5">{{ __('messages.welcome_feature_attendance') }}</h2>
                        <p class="text-base leading-relaxed mt-2">{{ __('messages.welcome_feature_attendance_desc') }}</p>
                    </div>
                    <div class="p-4 md:w-full sm:mb-0">
                        <div class="rounded-lg h-64 overflow-hidden">
                            <a data-fancybox class="w-full h-full"
                               href="/images/1755250713442.jpg">
                                <img src="/images/1755250713442.jpg"
                                     alt="{{ __('messages.welcome_feature_telegram') }}"
                                     class="object-cover object-left-top h-full w-full">
                            </a>
                        </div>
                        <h2 class="text-xl font-medium title-font text-white mt-5">{{ __('messages.welcome_feature_telegram') }}</h2>
                        <p class="text-base leading-relaxed mt-2">{{ __('messages.welcome_feature_telegram_desc') }}</p>
                    </div>
                    <div class="p-4 md:w-full sm:mb-0">
                        <div class="rounded-lg h-64 overflow-hidden">
                            <a data-fancybox class="w-full h-full"
                               href="/images/1755246868428.jpg">
                                <img src="/images/1755246868428.jpg"
                                     alt="{{ __('messages.welcome_feature_ai') }}"
                                     class="object-cover object-left-top h-full w-full">
                            </a>
                        </div>
                        <h2 class="text-xl font-medium title-font text-white mt-5">{{ __('messages.welcome_feature_ai') }}</h2>
                        <p class="text-base leading-relaxed mt-2">{{ __('messages.welcome_feature_ai_desc') }}</p>
                    </div>
                    <div class="p-4 md:w-full sm:mb-0">
                        <div class="rounded-lg h-64 overflow-hidden">
                            <a data-fancybox class="w-full h-full"
                               href="/images/1755244907855.jpg">
                                <img src="/images/1755244907855.jpg"
                                     alt="{{ __('messages.welcome_feature_load') }}"
                                     class="object-cover object-left-top h-full w-full">
                            </a>
                        </div>
                        <h2 class="text-xl font-medium title-font text-white mt-5">{{ __('messages.welcome_feature_load') }}</h2>
                        <p class="text-base leading-relaxed mt-2">{{ __('messages.welcome_feature_load_desc') }}</p>
                    </div>
                    <div class="p-4 md:w-full sm:mb-0">
                        <div class="rounded-lg h-64 overflow-hidden">
                            <a data-fancybox class="w-full h-full"
                               href="/images/1755244781043.jpg">
                                <img src="/images/1755244781043.jpg"
                                     alt="{{ __('messages.welcome_feature_dashboard') }}"
                                     class="object-cover object-left-top h-full w-full">
                            </a>
                        </div>
                        <h2 class="text-xl font-medium title-font text-white mt-5">{{ __('messages.welcome_feature_dashboard') }}</h2>
                        <p class="text-base leading-relaxed mt-2">{{ __('messages.welcome_feature_dashboard_desc') }}</p>
                    </div>
                    <div class="p-4 md:w-full sm:mb-0">
                        <div class="rounded-lg h-64 overflow-hidden">
                            <a data-fancybox class="w-full h-full"
                               href="/images/1762273118126.jpg">
                                <img src="/images/1762273118126.jpg"

                                     alt="{{ __('messages.welcome_feature_tests') }}"
                                     class="object-cover object-left-top h-full w-full">
                            </a>
                        </div>
                        <h2 class="text-xl font-medium title-font text-white mt-5">{{ __('messages.welcome_feature_tests') }}</h2>
                        <p class="text-base leading-relaxed mt-2">{{ __('messages.welcome_feature_tests_desc') }}</p>
                    </div>
                    <div class="p-4 md:w-full sm:mb-0">
                        <div class="rounded-lg h-64 overflow-hidden">
                            <a data-fancybox class="w-full h-full"
                               href="/images/socman – welcome.blade.php.jpg">
                                <img src="/images/socman – welcome.blade.php.jpg"
                                     alt="{{ __('messages.welcome_feature_achievements') }}"
                                     class="object-cover object-left-top h-full w-full">
                            </a>
                        </div>
                        <h2 class="text-xl font-medium title-font text-white mt-5">{{ __('messages.welcome_feature_achievements') }}</h2>
                        <p class="text-base leading-relaxed mt-2">{{ __('messages.welcome_feature_achievements_desc') }}</p>
                    </div>
                </div>
            </div>
        </section>
        <section id="price" class="scroll-mt-20">
            <div class="container px-5 py-12 mx-auto">
                <div class="mx-auto max-w-screen-md text-center mb-8 lg:mb-12">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">{{ __('messages.welcome_price_heading') }}</h2>
                    <p class="mb-5 font-light text-gray-500 sm:text-xl dark:text-gray-400">{{ __('messages.welcome_price_sub') }}</p>
                </div>
                <div class="space-y-8 lg:grid lg:grid-cols-3 sm:gap-6 xl:gap-10 lg:space-y-0">
                    <!-- Pricing Card -->
                    <div
                        class="flex flex-col p-6 mx-auto max-w-lg text-center text-gray-900 bg-white rounded-lg border border-gray-100 shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
                        <h3 class="mb-4 text-2xl font-semibold">FREE</h3>
                        <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400">{{ __('messages.welcome_free_desc') }}</p>
                        <div class="flex justify-center my-8">
                            <span class="mr-2 text-5xl font-extrabold">0</span>
                            <span class="text-gray-500 dark:text-gray-400">₽/месяц</span>
                        </div>
                        <div class="flex h-full flex-col gap-3 justify-between">
                            <!-- List -->
                            <ul class="mb-8 space-y-4 text-left">
                                <x-item-list-tarif
                                    text="Учет команды (ограничено)"
                                    description="тренеров - 1, команд - 1"
                                    icon-type="check"
                                />
                                <x-item-list-tarif
                                    text="Планирование тренировок"
                                    description="Выбор классификации тренировки, дата и время проведения, описание"
                                    icon-type="check"
                                />
                                <x-item-list-tarif
                                    text="Учет посещений"
                                    description="Отметки о присутствии на тренировках, формирование отчета за месяц"
                                    icon-type="check"
                                />
                                <x-item-list-tarif
                                    text="Техподдержка"
                                    description="Техническая поддержка - базовая. При обращении попадаете в очередь."
                                    icon-type="check"
                                />
                                <x-item-list-tarif
                                    text="Модуль Load Control"
                                    description="Отдельный модуль контроля состояния спортсменов"
                                    icon-type="cross"
                                />
                                <x-item-list-tarif
                                    text="Telegram бот"
                                    description="Для спортсменов: удобное информирование о тренировках и возможность ответов на опросы о состоянии в телеграм-боте. Для тренеров: контроль прохождения опросов и дополнительное информирование спортсменов"
                                    icon-type="cross"
                                />
                                <x-item-list-tarif
                                    text="Модуль ИИ Анализ"
                                    description="Отдельный модуль для анализа данных о состоянии спортсменов в один клик"
                                    icon-type="cross"
                                />
                                <x-item-list-tarif
                                    text="Тестирование спортменов"
                                    description="Система фиксации данных тестирования спортсменов для дальнейшего ослеживания динамики развития и своевременного внесения корректировок в тренировочный процесс"
                                    icon-type="cross"
                                />
                                <x-item-list-tarif
                                    text="Система достижений"
                                    description="Тренер в настройках выбирает какие достижения будут доступны для игроков (голы, передачи, сейвы, чеканка и т.д.). Игрок сам фиксирует свои достижения в телеграм боте."
                                    icon-type="cross"
                                />
                            </ul>
                            <button data-modal-target="subscriptionModal" data-modal-toggle="subscriptionModal"
                                    class="bg-indigo-500 hover:bg-rose-500 text-white px-4 py-2 rounded"
                                    title="{{ __('messages.Заказать подписку') }}">
                                {{ __('messages.Заказать подписку') }}
                            </button>
                        </div>
                    </div>
                    <!-- Pricing Card -->
                    <div
                        class="flex flex-col p-6 mx-auto max-w-lg text-center text-gray-900 bg-white rounded-lg border-4 border-gray-100 shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
                        <h3 class="mb-4 text-2xl font-semibold">{{ __('messages.welcome_standard') }}</h3>
                        <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400">{{ __('messages.welcome_standard_desc') }}</p>
                        <div class="flex flex-col gap-3 justify-center my-8">
                            <div class="flex justify-center mb-3">
                                <span class="relative mr-2 text-5xl font-extrabold" id="totalSum">14900</span>
                                <span class="text-gray-500 dark:text-gray-400">₽/месяц</span>
                            </div>

                            <div class="flex w-full">
                                <form class="max-w-xs mx-auto flex flex-col items-center justify-center">
                                    <label for="numberInput" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.welcome_coaches_label') }}</label>
                                    <div class="relative flex items-center justify-center max-w-[8rem]">
                                        <button type="button" id="decrement-button" data-input-counter-decrement="numberInput" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                            <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                                            </svg>
                                        </button>
                                        <input type="text" id="numberInput" value="1" data-input-counter aria-describedby="helper-text-explanation" class="bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="1" required />
                                        <button type="button" id="increment-button" data-input-counter-increment="numberInput" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                            <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('messages.welcome_coaches_help') }}</p>
                                </form>

                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    const input = document.getElementById('numberInput');
                                    const totalSumElem = document.getElementById('totalSum');
                                    const pricePerCoach = 14900;

                                    // Создаем элемент индикатора скидки рядом с totalSum, если его ещё нет
                                    let discountLabel = totalSumElem.querySelector('.discount-label');
                                    if (!discountLabel) {
                                        discountLabel = document.createElement('div');
                                        discountLabel.classList.add(
                                            'discount-label',
                                            'absolute',
                                            'top-0',
                                            'left-0',
                                            'flex',
                                            'items-center',
                                            'justify-center',
                                            'w-10',
                                            'h-10',
                                            'rounded-full',
                                            'border-3',
                                            'border-green-500',
                                            'text-green-500',
                                            'font-bold',
                                            'text-sm',
                                            'select-none',
                                            '-translate-y-1/2',
                                            '-translate-x-1/2',
                                        );
                                        discountLabel.style.pointerEvents = 'none';
                                        totalSumElem.style.position = 'relative';
                                        totalSumElem.appendChild(discountLabel);
                                    }

                                    function updateTotal() {
                                        let value = parseInt(input.value, 10);

                                        if (isNaN(value) || value < 1) {
                                            value = 1;
                                        } else if (value > 20) {
                                            value = 20;
                                        }

                                        if(input.value != value) {
                                            originalSetter.call(input, value);
                                        }

                                        const rawTotal = value * pricePerCoach;

                                        if (value > 1) {
                                            const discounted = Math.round(rawTotal * 0.9);
                                            totalSumElem.textContent = discounted.toLocaleString('ru-RU');
                                            totalSumElem.appendChild(discountLabel);
                                            discountLabel.textContent = '-10%';
                                            discountLabel.style.display = 'flex';
                                        } else {
                                            totalSumElem.textContent = rawTotal.toLocaleString('ru-RU');
                                            discountLabel.style.display = 'none';
                                        }
                                    }

                                    const descriptor = Object.getOwnPropertyDescriptor(HTMLInputElement.prototype, 'value');
                                    const originalSetter = descriptor.set;
                                    const originalGetter = descriptor.get;

                                    Object.defineProperty(input, 'value', {
                                        get() {
                                            return originalGetter.call(this);
                                        },
                                        set(newValue) {
                                            originalSetter.call(this, newValue);
                                            updateTotal();
                                        }
                                    });

                                    input.addEventListener('input', updateTotal);

                                    updateTotal();
                                });
                            </script>




                        </div>
                        <div class="flex h-full flex-col gap-3 justify-between">
                            <!-- List -->
                            <ul class="mb-8 space-y-4 text-left">
                                <x-item-list-tarif
                                    text="Учет команды"
                                    description="Вы сами выбираете количество тренеров"
                                    icon-type="check"
                                />
                                <x-item-list-tarif
                                    text="Планирование тренировок"
                                    description="Выбор классификации тренировки, дата и время проведения, описание"
                                    icon-type="check"
                                />
                                <x-item-list-tarif
                                    text="Учет посещений"
                                    description="Отметки о присутствии на тренировках, формирование отчета за месяц"
                                    icon-type="check"
                                />
                                <x-item-list-tarif
                                    text="Техподдержка"
                                    description="Техническая поддержка - базовая. При обращении попадаете в очередь."
                                    icon-type="check"
                                />
                                <x-item-list-tarif
                                    text="Модуль Load Control"
                                    description="Отдельный модуль контроля состояния спортсменов"
                                    icon-type="check"
                                />
                                <x-item-list-tarif
                                    text="Telegram бот"
                                    description="Для спортсменов: удобное информирование о тренировках и возможность ответов на опросы о состоянии в телеграм-боте. Для тренеров: контроль прохождения опросов и дополнительное информирование спортсменов"
                                    icon-type="check"
                                />
                                <x-item-list-tarif
                                    text="Модуль ИИ Анализ"
                                    description="Отдельный модуль для анализа данных о состоянии спортсменов в один клик"
                                    icon-type="check"
                                />
                                <x-item-list-tarif
                                    text="Тестирование спортменов"
                                    description="Система фиксации данных тестирования спортсменов для дальнейшего ослеживания динамики развития и своевременного внесения корректировок в тренировочный процесс"
                                    icon-type="check"
                                />
                                <x-item-list-tarif
                                    text="Система достижений"
                                    description="Тренер в настройках выбирает какие достижения будут доступны для игроков (голы, передачи, сейвы, чеканка и т.д.). Игрок сам фиксирует свои достижения в телеграм боте."
                                    icon-type="check"
                                />

                                <x-item-list-tarif
                                    text="Личный кабинет родителя"
                                    description="В разработке! Место где родитель сможет ознакомиться с динамикой развития своего ребенка как спортсмена"
                                    icon-type="new"
                                />

                            </ul>
                            <div
                                class="flex items-center p-4 mb-4 text-sm text-green-800 border-4 border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                                role="alert">
                                <svg class="shrink-0 inline w-8 h-8 me-3" viewBox="0 0 512 512" xml:space="preserve"
                                     fill="#31c48d" stroke="#31c48d"><g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <g>
                                            <path class="st0"
                                                  d="M217.238,233.975l-18.104,4.058c-0.496,0.11-0.688,0.414-0.578,0.916l5.057,22.603 c0.11,0.503,0.413,0.688,0.909,0.578l18.118-4.051c7.743-1.729,11.932-7.647,10.306-14.894 C231.292,235.814,224.995,232.246,217.238,233.975z"></path>
                                            <path class="st0"
                                                  d="M479.546,265.761c-2.397-6.283-2.397-13.234,0-19.524l19.469-51.11c4.602-12.056,0.165-25.669-10.623-32.716 l-45.798-29.906c-5.635-3.679-9.713-9.307-11.477-15.796l-14.288-52.805c-3.376-12.442-14.963-20.86-27.832-20.22l-54.63,2.728 c-6.724,0.331-13.323-1.812-18.573-6.035L273.204,6.071c-10.044-8.095-24.359-8.095-34.404,0l-42.588,34.307 c-5.25,4.223-11.849,6.366-18.573,6.035l-54.631-2.728c-12.868-0.64-24.456,7.778-27.832,20.22L80.89,116.709 c-1.764,6.489-5.842,12.117-11.477,15.796l-45.798,29.906c-10.788,7.047-15.225,20.66-10.637,32.716l19.482,51.11 c2.397,6.29,2.397,13.24,0,19.524l-19.482,51.117c-4.588,12.042-0.152,25.668,10.637,32.716l45.798,29.905 c5.635,3.672,9.713,9.294,11.477,15.79l14.288,52.798c3.376,12.455,14.963,20.867,27.832,20.226l54.631-2.729 c6.724-0.337,13.323,1.812,18.573,6.035l42.588,34.315c10.044,8.087,24.36,8.087,34.404,0l42.588-34.315 c5.25-4.223,11.849-6.372,18.573-6.035l54.63,2.729c12.869,0.64,24.456-7.771,27.832-20.226l14.288-52.798 c1.764-6.496,5.842-12.118,11.477-15.79l45.798-29.905c10.788-7.048,15.225-20.674,10.623-32.716L479.546,265.761z M167.54,283.266 l-32.847,7.344c-0.496,0.11-0.689,0.414-0.565,0.924l7.454,33.342c0.166,0.744-0.234,1.364-0.978,1.53l-12.235,2.742 c-0.744,0.166-1.364-0.227-1.529-0.971l-18.45-82.434c-0.165-0.751,0.234-1.364,0.978-1.529l53.197-11.904 c0.759-0.166,1.364,0.22,1.544,0.971l2.397,10.74c0.166,0.752-0.22,1.358-0.978,1.53l-38.965,8.715 c-0.496,0.11-0.688,0.42-0.578,0.923l4.836,21.604c0.111,0.497,0.414,0.689,0.91,0.579l32.847-7.344 c0.758-0.173,1.378,0.22,1.543,0.964l2.398,10.74C168.684,282.481,168.298,283.094,167.54,283.266z M261.755,299.297l-13.861,3.107 c-0.992,0.22-1.584-0.042-2.15-0.834l-23.642-29.464l-14.619,3.266c-0.496,0.11-0.688,0.42-0.578,0.923l7.247,32.344 c0.166,0.75-0.234,1.364-0.978,1.529l-12.235,2.742c-0.758,0.165-1.364-0.228-1.53-0.971l-18.448-82.435 c-0.166-0.744,0.22-1.364,0.978-1.53l32.847-7.344c15.611-3.5,29.416,4.299,32.764,19.282c2.494,11.119-1.956,21.163-10.885,26.97 l25.614,30.595C262.968,298.243,262.637,299.104,261.755,299.297z M331.445,283.707l-53.197,11.904 c-0.744,0.165-1.365-0.22-1.53-0.971l-18.435-82.434c-0.179-0.751,0.22-1.357,0.964-1.523l53.198-11.904 c0.758-0.172,1.364,0.221,1.543,0.965l2.397,10.746c0.166,0.744-0.22,1.35-0.978,1.522l-38.964,8.715 c-0.496,0.117-0.688,0.42-0.578,0.922l4.643,20.73c0.11,0.503,0.414,0.696,0.909,0.586l32.847-7.351 c0.758-0.165,1.364,0.221,1.544,0.971l2.397,10.74c0.166,0.751-0.22,1.364-0.978,1.53l-32.847,7.35 c-0.496,0.11-0.689,0.414-0.578,0.916l4.808,21.48c0.11,0.496,0.414,0.696,0.91,0.586l38.965-8.721 c0.758-0.166,1.378,0.22,1.543,0.971l2.398,10.74C332.588,282.922,332.202,283.542,331.445,283.707z M402.65,267.779 l-53.211,11.904c-0.744,0.165-1.364-0.221-1.529-0.972l-18.435-82.434c-0.179-0.751,0.22-1.357,0.964-1.53l53.212-11.898 c0.744-0.172,1.35,0.214,1.529,0.965l2.397,10.74c0.166,0.751-0.22,1.357-0.964,1.53l-38.964,8.715 c-0.51,0.11-0.702,0.42-0.592,0.923l4.643,20.729c0.11,0.503,0.414,0.696,0.923,0.586l32.847-7.351 c0.744-0.172,1.35,0.221,1.53,0.972l2.397,10.733c0.166,0.758-0.22,1.364-0.964,1.536l-32.847,7.351 c-0.51,0.11-0.703,0.413-0.592,0.909l4.808,21.48c0.11,0.503,0.414,0.702,0.924,0.586l38.964-8.715 c0.744-0.165,1.364,0.221,1.53,0.972l2.398,10.74C403.78,266.994,403.394,267.614,402.65,267.779z"></path>
                                        </g>
                                    </g>
                            </svg>
                                <div>
                                    <span class="font-medium">14 дней - бесплатный пробный период</span>
                                </div>
                            </div>
                            <button data-modal-target="subscriptionModal" data-modal-toggle="subscriptionModal"
                                    class="bg-indigo-500 hover:bg-rose-500 text-white px-4 py-2 rounded"
                                    title="Заказать подписку">
                                Заказать подписку
                            </button>
                        </div>
                    </div>
                    <div
                        class="flex flex-col p-6 mx-auto max-w-lg text-center text-gray-900 bg-white rounded-lg border border-gray-100 shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
                        <h3 class="mb-4 text-2xl font-semibold">Enterprise</h3>
                        <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400">{{ __('messages.welcome_enterprise_desc') }}</p>
                        <div class="flex justify-center my-8">
                            <span class="mr-2 text-5xl font-extrabold">149 000</span>
                            <span class="text-gray-500 dark:text-gray-400">₽/месяц</span>
                        </div>
                        <div class="flex h-full flex-col gap-3 justify-between">
                            <!-- List -->
                            <ul class="mb-8 space-y-4 text-left">
                                <ul class="mb-8 space-y-4 text-left">
                                    <x-item-list-tarif
                                        text="Учет команды"
                                        description="тренеров - ∞, команд - ∞"
                                        icon-type="check"
                                    />
                                    <x-item-list-tarif
                                        text="Планирование тренировок"
                                        description="Выбор классификации тренировки, дата и время проведения, описание"
                                        icon-type="check"
                                    />
                                    <x-item-list-tarif
                                        text="Учет посещений"
                                        description="Отметки о присутствии на тренировках, формирование отчета за месяц"
                                        icon-type="check"
                                    />
                                    <x-item-list-tarif
                                        text="Техподдержка PRO"
                                        description="Приоритетная техническая поддержка. При обращении заявка обрабатывается оперативно."
                                        icon-type="check"
                                    />
                                    <x-item-list-tarif
                                        text="Модуль Load Control"
                                        description="Отдельный модуль контроля состояния спортсменов"
                                        icon-type="check"
                                    />
                                    <x-item-list-tarif
                                        text="Telegram бот"
                                        description="Для спортсменов: удобное информирование о тренировках и возможность ответов на опросы о состоянии в телеграм-боте. Для тренеров: контроль прохождения опросов и дополнительное информирование спортсменов"
                                        icon-type="check"
                                    />
                                    <x-item-list-tarif
                                        text="Модуль ИИ Анализ"
                                        description="Отдельный модуль для анализа данных о состоянии спортсменов в один клик"
                                        icon-type="check"
                                    />
                                    <x-item-list-tarif
                                        text="Выделенный сервер"
                                        description="Размещение приложения на выделенном сервере как в россии так и за рубежем"
                                        icon-type="check"
                                    />
                                    <x-item-list-tarif
                                        text="Дашборд с кастомными KPI"
                                        description="На дошборде можно вывести любую информацию"
                                        icon-type="check"
                                    />
                                    <x-item-list-tarif
                                        text="White Label"
                                        description="Полный ребрендинг под фирменный стиль клиента (логотип, цвета, домен)"
                                        icon-type="check"
                                    />
                                    <x-item-list-tarif
                                        text="Тестирование спортменов"
                                        description="Система фиксации данных тестирования спортсменов для дальнейшего ослеживания динамики развития и своевременного внесения корректировок в тренировочный процесс"
                                        icon-type="check"
                                    />
                                    <x-item-list-tarif
                                        text="Система достижений"
                                        description="Тренер в настройках выбирает какие достижения будут доступны для игроков (голы, передачи, сейвы, чеканка и т.д.). Игрок сам фиксирует свои достижения в телеграм боте."
                                        icon-type="check"
                                    />
                                    <x-item-list-tarif
                                        text="Личный кабинет родителя"
                                        description="В разработке! Место где родитель сможет ознакомиться с динамикой развития своего ребенка как спортсмена"
                                        icon-type="new"
                                    />

                                </ul>
                            </ul>
                            <button data-modal-target="subscriptionModal" data-modal-toggle="subscriptionModal"
                                    class="bg-indigo-500 hover:bg-rose-500 text-white px-4 py-2 rounded"
                                    title="{{ __('messages.Заказать подписку') }}">
                                {{ __('messages.Заказать подписку') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="text-gray-400 body-font scroll-mt-20" id="steps">
            <div class="container px-5 py-12 mx-auto">
                <div class="mx-auto max-w-screen-md text-center mb-8 lg:mb-12">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">{{ __('messages.welcome_steps_heading') }}</h2>
                    <p class="mb-5 font-light text-gray-500 sm:text-xl dark:text-gray-400">{{ __('messages.welcome_steps_sub') }}</p>
                </div>
                <ol class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <li class="flex gap-6 items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse">
                        <div
                            class="flex font-bold text-indigo-500 items-center justify-center w-8 h-8 border-2 border-rose-500 rounded-full shrink-0 dark:border-rose-500">
                            1
                        </div>
                        <div class="flex gap-3 flex-col">
                            <h3 class="font-medium leading-tight text-2xl">{{ __('messages.welcome_step1_title') }}</h3>
                            <p class="text-sm">{{ __('messages.welcome_step1_text') }}</p>
                        </div>
                    </li>
                    <li class="flex gap-6 items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse">
                        <div
                            class="flex font-bold text-indigo-500 items-center justify-center w-8 h-8 border-2 border-rose-500 rounded-full shrink-0 dark:border-rose-500">
                            2
                        </div>
                        <div class="flex gap-3 flex-col">
                            <h3 class="font-medium leading-tight text-2xl">{{ __('messages.welcome_step2_title') }}</h3>
                            <p class="text-sm">{{ __('messages.welcome_step2_text') }}</p>
                        </div>
                    </li>
                    <li class="flex gap-6 items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse">
                        <div
                            class="flex font-bold text-indigo-500 items-center justify-center w-8 h-8 border-2 border-rose-500 rounded-full shrink-0 dark:border-rose-500">
                            3
                        </div>
                        <div class="flex gap-3 flex-col">
                            <h3 class="font-medium leading-tight text-2xl">{{ __('messages.welcome_step3_title') }}</h3>
                            <p class="text-sm">{{ __('messages.welcome_step3_text') }}</p>
                        </div>
                    </li>
                    <li class="flex gap-6 items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse">
                        <div
                            class="flex font-bold text-indigo-500 items-center justify-center w-8 h-8 border-2 border-rose-500 rounded-full shrink-0 dark:border-rose-500">
                            4
                        </div>
                        <div class="flex gap-3 flex-col">
                            <h3 class="font-medium leading-tight text-2xl">{{ __('messages.welcome_step4_title') }}</h3>
                            <p class="text-sm">{{ __('messages.welcome_step4_text') }}</p>
                        </div>
                    </li>
                    <li class="flex gap-6 items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse">
                        <div
                            class="flex font-bold text-indigo-500 items-center justify-center w-8 h-8 border-2 border-rose-500 rounded-full shrink-0 dark:border-rose-500">
                            5
                        </div>
                        <div class="flex gap-3 flex-col">
                            <h3 class="font-medium leading-tight text-2xl">{{ __('messages.welcome_step5_title') }}</h3>
                            <p class="text-sm">{{ __('messages.welcome_step5_text') }}</p>
                        </div>
                    </li>
                    <li class="flex gap-6 items-center text-gray-500 dark:text-gray-400 space-x-2.5 rtl:space-x-reverse">
                        <div
                            class="flex font-bold text-indigo-500 items-center justify-center w-8 h-8 border-2 border-rose-500 rounded-full shrink-0 dark:border-rose-500">
                            6
                        </div>
                        <div class="flex gap-3 flex-col">
                            <h3 class="font-medium leading-tight text-2xl">{{ __('messages.welcome_step6_title') }}</h3>
                            <p class="text-sm">{{ __('messages.welcome_step6_text') }}</p>
                        </div>
                    </li>
                </ol>
            </div>
        </section>
        <section class="bg-white dark:bg-gray-900 scroll-mt-20" id="faq">
            <div class="container px-5 py-12 mx-auto">
                <h2 class="mb-8 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">{{ __('messages.welcome_faq_heading') }}</h2>
                <div
                    class="grid pt-8 gap-4 text-left border-t border-gray-200 md:gap-16 dark:border-gray-700 md:grid-cols-2">

                    <div class="mb-3">
                        <h3 class="flex items-center mb-4 text-lg font-medium text-gray-900 dark:text-white">
                            <svg class="flex-shrink-0 mr-2 w-5 h-5 text-gray-500 dark:text-gray-400" fill="#9f1239"
                                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            {{ __('messages.welcome_faq_what') }}
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400">{{ __('messages.welcome_faq_what_text') }}</p>
                    </div>
                    <div class="mb-3">
                        <h3 class="flex items-center mb-4 text-lg font-medium text-gray-900 dark:text-white">
                            <svg class="flex-shrink-0 mr-2 w-5 h-5 text-gray-500 dark:text-gray-400" fill="#9f1239"
                                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            {{ __('messages.welcome_faq_who') }}
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400">{{ __('messages.welcome_faq_who_text') }}</p>
                    </div>
                    <div class="mb-3">
                        <h3 class="flex items-center mb-4 text-lg font-medium text-gray-900 dark:text-white">
                            <svg class="flex-shrink-0 mr-2 w-5 h-5 text-gray-500 dark:text-gray-400" fill="#9f1239"
                                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            Какие данные я могу сохранять в SportControl?
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400">Календарь тренировок, результаты тренировок,
                            показатели нагрузок и состояния спортсмена, технические заметки по игрокам, стстистику
                            посещения</p>
                    </div>
                    <div class="mb-3">
                        <h3 class="flex items-center mb-4 text-lg font-medium text-gray-900 dark:text-white">
                            <svg class="flex-shrink-0 mr-2 w-5 h-5 text-gray-500 dark:text-gray-400" fill="#9f1239"
                                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            Могу ли я использовать SportControl для других видов спорта?
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400">Да, но функционал оптимизирован именно под командные
                            виды спорта. Некоторые функции будут работать для разных спортивных дисциплин (футзал,
                            мини‑футбол, хоккей, баскетбол, гандбол и тп).</p>
                    </div>
                    <div class="mb-3">
                        <h3 class="flex items-center mb-4 text-lg font-medium text-gray-900 dark:text-white">
                            <svg class="flex-shrink-0 mr-2 w-5 h-5 text-gray-500 dark:text-gray-400" fill="#9f1239"
                                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            Как работает безопасность данных?
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400">Все данные хранятся на защищённых серверах в РФ.
                            Передача данных происходит по защищённому протоколу HTTPS. Доступ ограничен администраторами
                            и владельцем аккаунта</p>
                    </div>
                    <div class="mb-3">
                        <h3 class="flex items-center mb-4 text-lg font-medium text-gray-900 dark:text-white">
                            <svg class="flex-shrink-0 mr-2 w-5 h-5 text-gray-500 dark:text-gray-400" fill="#9f1239"
                                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            Нужно ли мне получать согласие игроков на загрузку их данных и фото?
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400">Да. Если вы добавляете материалы с изображениями
                            людей (особенно несовершеннолетних), вы обязаны получить их письменное согласие на обработку
                            персональных данных.</p>
                    </div>
                    <div class="mb-3">
                        <h3 class="flex items-center mb-4 text-lg font-medium text-gray-900 dark:text-white">
                            <svg class="flex-shrink-0 mr-2 w-5 h-5 text-gray-500 dark:text-gray-400" fill="#9f1239"
                                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            Есть ли мобильная версия?
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400">Да, SportControl адаптирован под смартфоны и
                            планшеты, работает в браузере без установки сторонних приложений. Есть интеграция с
                            телеграм.</p>
                    </div>
                    <div class="mb-3">
                        <h3 class="flex items-center mb-4 text-lg font-medium text-gray-900 dark:text-white">
                            <svg class="flex-shrink-0 mr-2 w-5 h-5 text-gray-500 dark:text-gray-400" fill="#9f1239"
                                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            Как оформить подписку?
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400">Выберите тариф на странице «Подписка» в приложении,
                            отправьте заявку, мы заключим договор и выставим счет, после оплаты доступ откроется
                            автоматически.</p>
                    </div>
                    <div class="mb-3">
                        <h3 class="flex items-center mb-4 text-lg font-medium text-gray-900 dark:text-white">
                            <svg class="flex-shrink-0 mr-2 w-5 h-5 text-gray-500 dark:text-gray-400" fill="#9f1239"
                                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            Что делать, если я забыл пароль?
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400">На странице входа нажмите «Забыли пароль?» и
                            следуйте инструкциям для восстановления доступа.</p>
                    </div>
                    <div class="mb-3">
                        <h3 class="flex items-center mb-4 text-lg font-medium text-gray-900 dark:text-white">
                            <svg class="flex-shrink-0 mr-2 w-5 h-5 text-gray-500 dark:text-gray-400" fill="#9f1239"
                                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            Могу ли я удалить свой аккаунт?
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400">Да. Это можно сделать в настройках профиля. При
                            удалении аккаунта все данные будут стерты в течение 30 дней.</p>
                    </div>

                </div>
            </div>
        </section>
    </div>

</x-start-layout>
