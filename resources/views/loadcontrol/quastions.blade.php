<div id="minutes_until_training" class="mb-2 text-sm text-gray-700">

</div>
@if (Auth::user()->active == 0)

    <div id="toast-danger"
         class="flex items-center w-full p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-700"
         role="alert">
        <div
            class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                 viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
            </svg>
            <span class="sr-only">Error icon</span>
        </div>
        <div
            class="ms-3 text-sm font-normal">{{ __('messages.Чтобы вы могли получать вопросы LoadControl, ваш аккаунт должен быть активен.') }}</div>
        <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                data-dismiss-target="#toast-danger" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
@else
    @if(checkLoadControlForPlayer())
        <div class="flex gap-7 flex-col justify-center">
            <div id="message"></div>
            @if(!checkAnswerRecoveryToday())
                <form id="form_question_recovery" action="{{ route('questions.store') }}" method="POST" class="flex-col"
                      style="display: none">
                    @csrf
                    <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}"/>
                    <div
                        class="flex flex-col border border-gray-600 rounded-lg w-full sm:w-96 p-4 sm:p-7">
                        <h2 class="flex text-center justify-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ __('messages.Опрос по ВОССТАНОВЛЕНИЮ') }}
                        </h2>
                        @if(checkExtraLoadControlForPlayer())
                            <div
                                class="flex flex-col justify-center items-center border-b-2 border-gray-700">
                                <h3 class="w-full pt-5 font-normal text-lg text-gray-800 dark:text-gray-200 leading-tight">
                                    {{ __('messages.Ощущали ли Вы дискомфорт или боль? (1-5 присутствует некий дискомфорт, 6-10 выраженная боль)') }}
                                </h3>
                                <div class="pt-5">
                                    <input type="radio" id="pain-0" name="pain" value="0" required
                                           class="hidden peer" checked/>
                                    <label for="pain-0"
                                           class="flex items-center justify-center w-fit h-10 p-3 text-white bg-green-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-green-500 dark:text-white dark:bg-green-400 dark:hover:bg-green-500">
                                        <div class="block">
                                            {{ __('messages.Ничего не беспокоит') }}
                                        </div>
                                    </label>
                                </div>
                                <ul class="grid w-fit gap-1 sm:gap-2 grid-cols-10 py-5">
                                    <li>
                                        <input type="radio" id="pain-1" name="pain" value="1"
                                               class="hidden peer"/>
                                        <label for="pain-1"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-blue-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-blue-500 dark:text-white dark:bg-blue-400 dark:hover:bg-blue-500">
                                            <div class="block">
                                                1
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="pain-2" name="pain" value="2"
                                               class="hidden peer">
                                        <label for="pain-2"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-cyan-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-cyan-500 dark:text-white dark:bg-cyan-400 dark:hover:bg-cyan-500">
                                            <div class="block">
                                                2
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="pain-3" name="pain" value="3"
                                               class="hidden peer">
                                        <label for="pain-3"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-teal-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-teal-500 dark:text-white dark:bg-teal-400 dark:hover:bg-teal-500">
                                            <div class="block">
                                                3
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="pain-4" name="pain" value="4"
                                               class="hidden peer">
                                        <label for="pain-4"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-emerald-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-emerald-500 dark:text-white dark:bg-emerald-400 dark:hover:bg-emerald-500">
                                            <div class="block">
                                                4
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="pain-5" name="pain" value="5"
                                               class="hidden peer">
                                        <label for="pain-5"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-green-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-green-500 dark:text-white dark:bg-green-400 dark:hover:bg-green-500">
                                            <div class="block">
                                                5
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="pain-6" name="pain" value="6"
                                               class="hidden peer">
                                        <label for="pain-6"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-lime-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-lime-500 dark:text-white dark:bg-lime-400 dark:hover:bg-lime-500">
                                            <div class="block">
                                                6
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="pain-7" name="pain" value="7"
                                               class="hidden peer">
                                        <label for="pain-7"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-yellow-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-yellow-500 dark:text-white dark:bg-yellow-400 dark:hover:bg-yellow-500">
                                            <div class="block">
                                                7
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="pain-8" name="pain" value="8"
                                               class="hidden peer">
                                        <label for="pain-8"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-amber-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-amber-500 dark:text-white dark:bg-amber-400 dark:hover:bg-amber-500">
                                            <div class="block">
                                                8
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="pain-9" name="pain" value="9"
                                               class="hidden peer">
                                        <label for="pain-9"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-orange-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-orange-500 dark:text-white dark:bg-orange-400 dark:hover:bg-orange-500">
                                            <div class="block">
                                                9
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="pain-10" name="pain" value="10"
                                               class="hidden peer">
                                        <label for="pain-10"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-red-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-red-500 dark:text-white dark:bg-red-400 dark:hover:bg-red-500">
                                            <div class="block">
                                                10
                                            </div>
                                        </label>
                                    </li>
                                </ul>
                                <div id="local-block">
                                    <label for="local"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Локализация') }}</label>
                                    <div class="relative mb-6">
                                        <input type="text" id="local" name="local"
                                               class="bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500"
                                               placeholder="{{ __('messages.Где болит?') }}">
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ __('messages.Опиши кратко что болит.') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="flex flex-col justify-center items-center border-b-2 border-gray-700">
                                <h3 class="w-full pt-5 font-normal text-lg text-gray-800 dark:text-gray-200 leading-tight">
                                    {{ __('messages.Оцените качество сна (1- очень плохо спал, 10-очень хорошо спал)') }}
                                </h3>
                                <ul class="grid w-fit gap-1 sm:gap-2 grid-cols-10 py-5">
                                    <li>
                                        <input type="radio" id="sleep-1" name="sleep"
                                               value="1"
                                               class="hidden peer" required/>
                                        <label for="sleep-1"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-red-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-red-500 dark:text-white dark:bg-red-400 dark:hover:bg-red-500">
                                            <div class="block">
                                                1
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="sleep-2" name="sleep"
                                               value="2"
                                               class="hidden peer">
                                        <label for="sleep-2"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-orange-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-orange-500 dark:text-white dark:bg-orange-400 dark:hover:bg-orange-500">
                                            <div class="block">
                                                2
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="sleep-3" name="sleep"
                                               value="3"
                                               class="hidden peer">
                                        <label for="sleep-3"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-amber-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-amber-500 dark:text-white dark:bg-amber-400 dark:hover:bg-amber-500">
                                            <div class="block">
                                                3
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="sleep-4" name="sleep"
                                               value="4"
                                               class="hidden peer">
                                        <label for="sleep-4"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-yellow-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-yellow-500 dark:text-white dark:bg-yellow-400 dark:hover:bg-yellow-500">
                                            <div class="block">
                                                4
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="sleep-5" name="sleep"
                                               value="5"
                                               class="hidden peer">
                                        <label for="sleep-5"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-lime-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-lime-500 dark:text-white dark:bg-lime-400 dark:hover:bg-lime-500">
                                            <div class="block">
                                                5
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="sleep-6" name="sleep"
                                               value="6"
                                               class="hidden peer">
                                        <label for="sleep-6"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-green-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-green-500 dark:text-white dark:bg-green-400 dark:hover:bg-green-500">
                                            <div class="block">
                                                6
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="sleep-7" name="sleep"
                                               value="7"
                                               class="hidden peer">
                                        <label for="sleep-7"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-emerald-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-emerald-500 dark:text-white dark:bg-emerald-400 dark:hover:bg-emerald-500">
                                            <div class="block">
                                                7
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="sleep-8" name="sleep"
                                               value="8"
                                               class="hidden peer">
                                        <label for="sleep-8"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-teal-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-teal-500 dark:text-white dark:bg-teal-400 dark:hover:bg-teal-500">
                                            <div class="block">
                                                8
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="sleep-9" name="sleep"
                                               value="9"
                                               class="hidden peer">
                                        <label for="sleep-9"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-cyan-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-cyan-500 dark:text-white dark:bg-cyan-400 dark:hover:bg-cyan-500">
                                            <div class="block">
                                                9
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="sleep-10" name="sleep"
                                               value="10"
                                               class="hidden peer">
                                        <label for="sleep-10"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-blue-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-blue-500 dark:text-white dark:bg-blue-400 dark:hover:bg-blue-500">
                                            <div class="block">
                                                10
                                            </div>
                                        </label>
                                    </li>
                                </ul>

                                <div id="sleep-block" class="flex w-full flex-col mb-5">
                                    <h3 class="w-full pt-5 mb-5 font-normal text-lg text-gray-800 dark:text-gray-200 leading-tight">
                                        {{ __('messages.Во сколько уснул?') }}
                                    </h3>
                                    <div class="flex flex-col flex-wrap col-2 gap-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="sleep_time" value="< 23:00"
                                                   class="form-radio text-blue-600 rounded" required checked>
                                            <span class="ml-2 text-white">{{ __('messages.До 23:00') }}</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="sleep_time" value="23:00"
                                                   class="form-radio text-blue-600 rounded">
                                            <span class="ml-2 text-white">{{ __('messages.23:00') }}</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="sleep_time" value="23:30"
                                                   class="form-radio text-blue-600 rounded">
                                            <span class="ml-2 text-white">{{ __('messages.23:30') }}</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="sleep_time" value="00:00"
                                                   class="form-radio text-blue-600 rounded">
                                            <span class="ml-2 text-white">{{ __('messages.00:00') }}</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="sleep_time" value="00:30"
                                                   class="form-radio text-blue-600 rounded">
                                            <span class="ml-2 text-white">{{ __('messages.00:30') }}</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="sleep_time" value="> 01:00"
                                                   class="form-radio text-blue-600 rounded">
                                            <span class="ml-2 text-white">{{ __('messages.Позднее 01:00') }}</span>
                                        </label>
                                        <span id="sleep-error" class="text-red-600 text-xs"></span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="flex flex-col justify-center items-center border-b-2 border-gray-700">
                                <h3 class="w-full pt-5 font-normal text-lg text-gray-800 dark:text-gray-200 leading-tight">
                                    {{ __('messages.Оцените своё морально-психологическое состояние (1-очень плохое, 10-очень хорошее)') }}
                                </h3>
                                <ul class="grid w-fit gap-2 grid-cols-10 py-5">
                                    <li>
                                        <input type="radio" id="moral-1" name="moral"
                                               value="1"
                                               class="hidden peer" required/>
                                        <label for="moral-1"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-red-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-red-500 dark:text-white dark:bg-red-400 dark:hover:bg-red-500">
                                            <div class="block">
                                                1
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="moral-2" name="moral"
                                               value="2"
                                               class="hidden peer">
                                        <label for="moral-2"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-orange-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-orange-500 dark:text-white dark:bg-orange-400 dark:hover:bg-orange-500">
                                            <div class="block">
                                                2
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="moral-3" name="moral"
                                               value="3"
                                               class="hidden peer">
                                        <label for="moral-3"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-amber-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-amber-500 dark:text-white dark:bg-amber-400 dark:hover:bg-amber-500">
                                            <div class="block">
                                                3
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="moral-4" name="moral"
                                               value="4"
                                               class="hidden peer">
                                        <label for="moral-4"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-yellow-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-yellow-500 dark:text-white dark:bg-yellow-400 dark:hover:bg-yellow-500">
                                            <div class="block">
                                                4
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="moral-5" name="moral"
                                               value="5"
                                               class="hidden peer">
                                        <label for="moral-5"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-lime-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-lime-500 dark:text-white dark:bg-lime-400 dark:hover:bg-lime-500">
                                            <div class="block">
                                                5
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="moral-6" name="moral"
                                               value="6"
                                               class="hidden peer">
                                        <label for="moral-6"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-green-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-green-500 dark:text-white dark:bg-green-400 dark:hover:bg-green-500">
                                            <div class="block">
                                                6
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="moral-7" name="moral"
                                               value="7"
                                               class="hidden peer">
                                        <label for="moral-7"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-emerald-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-emerald-500 dark:text-white dark:bg-emerald-400 dark:hover:bg-emerald-500">
                                            <div class="block">
                                                7
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="moral-8" name="moral"
                                               value="8"
                                               class="hidden peer">
                                        <label for="moral-8"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-teal-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-teal-500 dark:text-white dark:bg-teal-400 dark:hover:bg-teal-500">
                                            <div class="block">
                                                8
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="moral-9" name="moral"
                                               value="9"
                                               class="hidden peer">
                                        <label for="moral-9"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-cyan-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-cyan-500 dark:text-white dark:bg-cyan-400 dark:hover:bg-cyan-500">
                                            <div class="block">
                                                9
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="moral-10" name="moral"
                                               value="10"
                                               class="hidden peer">
                                        <label for="moral-10"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-blue-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-blue-500 dark:text-white dark:bg-blue-400 dark:hover:bg-blue-500">
                                            <div class="block">
                                                10
                                            </div>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div
                                class="flex flex-col justify-center items-center border-b-2 border-gray-700">
                                <h3 class="w-full pt-5 font-normal text-lg text-gray-800 dark:text-gray-200 leading-tight">
                                    {{ __('messages.Оцените своё физическое состояние (1-очень плохое, 10-очень хорошее)') }}
                                </h3>
                                <ul class="grid w-fit gap-2 grid-cols-10 py-5">
                                    <li>
                                        <input type="radio" id="physical-1" name="physical"
                                               value="1"
                                               class="hidden peer" required/>
                                        <label for="physical-1"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-red-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-red-500 dark:text-white dark:bg-red-400 dark:hover:bg-red-500">
                                            <div class="block">
                                                1
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="physical-2" name="physical"
                                               value="2"
                                               class="hidden peer">
                                        <label for="physical-2"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-orange-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-orange-500 dark:text-white dark:bg-orange-400 dark:hover:bg-orange-500">
                                            <div class="block">
                                                2
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="physical-3" name="physical"
                                               value="3"
                                               class="hidden peer">
                                        <label for="physical-3"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-amber-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-amber-500 dark:text-white dark:bg-amber-400 dark:hover:bg-amber-500">
                                            <div class="block">
                                                3
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="physical-4" name="physical"
                                               value="4"
                                               class="hidden peer">
                                        <label for="physical-4"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-yellow-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-yellow-500 dark:text-white dark:bg-yellow-400 dark:hover:bg-yellow-500">
                                            <div class="block">
                                                4
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="physical-5" name="physical"
                                               value="5"
                                               class="hidden peer">
                                        <label for="physical-5"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-lime-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-lime-500 dark:text-white dark:bg-lime-400 dark:hover:bg-lime-500">
                                            <div class="block">
                                                5
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="physical-6" name="physical"
                                               value="6"
                                               class="hidden peer">
                                        <label for="physical-6"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-green-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-green-500 dark:text-white dark:bg-green-400 dark:hover:bg-green-500">
                                            <div class="block">
                                                6
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="physical-7" name="physical"
                                               value="7"
                                               class="hidden peer">
                                        <label for="physical-7"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-emerald-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-emerald-500 dark:text-white dark:bg-emerald-400 dark:hover:bg-emerald-500">
                                            <div class="block">
                                                7
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="physical-8" name="physical"
                                               value="8"
                                               class="hidden peer">
                                        <label for="physical-8"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-teal-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-teal-500 dark:text-white dark:bg-teal-400 dark:hover:bg-teal-500">
                                            <div class="block">
                                                8
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="physical-9" name="physical"
                                               value="9"
                                               class="hidden peer">
                                        <label for="physical-9"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-cyan-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-cyan-500 dark:text-white dark:bg-cyan-400 dark:hover:bg-cyan-500">
                                            <div class="block">
                                                9
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="physical-10" name="physical"
                                               value="10"
                                               class="hidden peer">
                                        <label for="physical-10"
                                               class="flex items-center justify-center p-1 w-7 h-7 text-white bg-blue-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-blue-500 dark:text-white dark:bg-blue-400 dark:hover:bg-blue-500">
                                            <div class="block">
                                                10
                                            </div>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        @endif
                        <div class="flex flex-col justify-center items-center">
                            <h3 class="w-full pt-5 font-normal text-lg text-gray-800 dark:text-gray-200 leading-tight">
                                {{ __('messages.Оцените уровень восстановления после последней нагрузки по шкале от 0 до 10 (где 0 - это полное отсутствие восстановления, 5 - средний уровень, а 10 - полное восстановление и наилучшее состояние)') }}
                            </h3>
                            <div class="my-5">
                                <label class="inline-flex items-center cursor-pointer mb-2">
                                    <input type="checkbox" value="" class="sr-only peer" id="presence_check"
                                           name="presence_check" checked>
                                    <div
                                        class="relative w-20 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-500 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-gray-200 after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span
                                        class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('messages.Планируешь присутствовать сегодня на тренировке?') }}</span>
                                </label>
                                <div id="cause-block">
                                    <input type="text" id="cause"
                                           class="bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500"
                                           placeholder="{{ __('messages.Причина') }}">
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ __('messages.Коротко опиши причину отсутствия.') }}</p>
                                </div>
                            </div>

                            <ul class="grid w-fit gap-2 grid-cols-10 py-5">
                                <li>
                                    <input type="radio" id="recovery-1" name="recovery_q" value="1"
                                           class="hidden peer" required/>
                                    <label for="recovery-1"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-red-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-red-500 dark:text-white dark:bg-red-400 dark:hover:bg-red-500">
                                        <div class="block">
                                            1
                                        </div>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="recovery-2" name="recovery_q" value="2"
                                           class="hidden peer">
                                    <label for="recovery-2"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-orange-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-orange-500 dark:text-white dark:bg-orange-400 dark:hover:bg-orange-500">
                                        <div class="block">
                                            2
                                        </div>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="recovery-3" name="recovery_q" value="3"
                                           class="hidden peer">
                                    <label for="recovery-3"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-amber-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-amber-500 dark:text-white dark:bg-amber-400 dark:hover:bg-amber-500">
                                        <div class="block">
                                            3
                                        </div>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="recovery-4" name="recovery_q" value="4"
                                           class="hidden peer">
                                    <label for="recovery-4"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-yellow-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-yellow-500 dark:text-white dark:bg-yellow-400 dark:hover:bg-yellow-500">
                                        <div class="block">
                                            4
                                        </div>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="recovery-5" name="recovery_q" value="5"
                                           class="hidden peer">
                                    <label for="recovery-5"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-lime-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-lime-500 dark:text-white dark:bg-lime-400 dark:hover:bg-lime-500">
                                        <div class="block">
                                            5
                                        </div>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="recovery-6" name="recovery_q" value="6"
                                           class="hidden peer">
                                    <label for="recovery-6"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-green-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-green-500 dark:text-white dark:bg-green-400 dark:hover:bg-green-500">
                                        <div class="block">
                                            6
                                        </div>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="recovery-7" name="recovery_q" value="7"
                                           class="hidden peer">
                                    <label for="recovery-7"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-emerald-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-emerald-500 dark:text-white dark:bg-emerald-400 dark:hover:bg-emerald-500">
                                        <div class="block">
                                            7
                                        </div>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="recovery-8" name="recovery_q" value="8"
                                           class="hidden peer">
                                    <label for="recovery-8"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-teal-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-teal-500 dark:text-white dark:bg-teal-400 dark:hover:bg-teal-500">
                                        <div class="block">
                                            8
                                        </div>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="recovery-9" name="recovery_q" value="9"
                                           class="hidden peer">
                                    <label for="recovery-9"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-cyan-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-cyan-500 dark:text-white dark:bg-cyan-400 dark:hover:bg-cyan-500">
                                        <div class="block">
                                            9
                                        </div>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="recovery-10" name="recovery_q" value="10"
                                           class="hidden peer">
                                    <label for="recovery-10"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-blue-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-blue-500 dark:text-white dark:bg-blue-400 dark:hover:bg-blue-500">
                                        <div class="block">
                                            10
                                        </div>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <button type="button" id="button_send_recovery"
                            class="mt-5 w-full sm:w-96 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        {{ __('messages.Ответить') }}</button>
                    <div id="response" class="py-3"></div>
                </form>
                <button id="btn_recovery_success" data-modal-target="add_recovery_success"
                        data-modal-toggle="add_recovery_success"
                        class="hidden" type="button"></button>
                <div id="add_recovery_success" tabindex="-1" aria-hidden="true"
                     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div id="alert-border-3"
                         class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800"
                         role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <div class="ms-3 text-sm font-medium">
                            {{ __('messages.Ответ сохранен') }}
                        </div>
                        <button type="button"
                                class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                                data-dismiss-target="#alert-border-3" aria-label="Close">
                            <span class="sr-only">Dismiss</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if(!checkAnswerLoadToday())
                <form id="form_question_load" class="d-none flex-col" style="display: none">
                    <div
                        class="flex flex-col border border-gray-600 rounded-lg w-full sm:w-96 p-4 sm:p-7">
                        <h2 class="flex text-center justify-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ __('messages.Опрос по НАГРУЗКЕ') }}
                        </h2>
                        <div class="flex flex-col justify-center items-center">
                            <h3 class="w-full pt-5 font-normal text-lg text-gray-800 dark:text-gray-200 leading-tight">
                                {{ __('messages.Оцените уровень утомления и тяжести нагрузки по шкале от 0 до 10 (где 0 - это отсутствие нагрузки, 5 - средний уровень, а 10 - максимально возможная нагрузка)') }}
                            </h3>
                            <div class="pt-5">
                                <input type="radio" id="load-0" name="load_q" value="0"
                                       class="hidden peer" required/>
                                <label for="load-0"
                                       class="flex items-center justify-center w-fit h-10 p-3 text-white bg-green-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-green-500 dark:text-white dark:bg-green-400 dark:hover:bg-green-500">
                                    <div class="block">
                                        {{ __('messages.Отсутствие нагрузки') }}
                                    </div>
                                </label>
                            </div>
                            <ul class="grid w-fit gap-2 grid-cols-10 py-5">
                                <li>
                                    <input type="radio" id="load-1" name="load_q" value="1"
                                           class="hidden peer" required/>
                                    <label for="load-1"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-blue-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-blue-500 dark:text-white dark:bg-blue-400 dark:hover:bg-blue-500">
                                        <div class="block">
                                            1
                                        </div>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="load-2" name="load_q" value="2"
                                           class="hidden peer">
                                    <label for="load-2"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-cyan-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-cyan-500 dark:text-white dark:bg-cyan-400 dark:hover:bg-cyan-500">
                                        <div class="block">
                                            2
                                        </div>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="load-3" name="load_q" value="3"
                                           class="hidden peer">
                                    <label for="load-3"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-teal-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-teal-500 dark:text-white dark:bg-teal-400 dark:hover:bg-teal-500">
                                        <div class="block">
                                            3
                                        </div>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="load-4" name="load_q" value="4"
                                           class="hidden peer">
                                    <label for="load-4"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-emerald-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-emerald-500 dark:text-white dark:bg-emerald-400 dark:hover:bg-emerald-500">
                                        <div class="block">
                                            4
                                        </div>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="load-5" name="load_q" value="5"
                                           class="hidden peer">
                                    <label for="load-5"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-green-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-green-500 dark:text-white dark:bg-green-400 dark:hover:bg-green-500">
                                        <div class="block">
                                            5
                                        </div>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="load-6" name="load_q" value="6"
                                           class="hidden peer">
                                    <label for="load-6"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-lime-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-lime-500 dark:text-white dark:bg-lime-400 dark:hover:bg-lime-500">
                                        <div class="block">
                                            6
                                        </div>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="load-7" name="load_q" value="7"
                                           class="hidden peer">
                                    <label for="load-7"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-yellow-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-yellow-500 dark:text-white dark:bg-yellow-400 dark:hover:bg-yellow-500">
                                        <div class="block">
                                            7
                                        </div>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="load-8" name="load_q" value="8"
                                           class="hidden peer">
                                    <label for="load-8"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-amber-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-amber-500 dark:text-white dark:bg-amber-400 dark:hover:bg-amber-500">
                                        <div class="block">
                                            8
                                        </div>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="load-9" name="load_q" value="9"
                                           class="hidden peer">
                                    <label for="load-9"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-orange-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-orange-500 dark:text-white dark:bg-orange-400 dark:hover:bg-orange-500">
                                        <div class="block">
                                            9
                                        </div>
                                    </label>
                                </li>
                                <li>
                                    <input type="radio" id="load-10" name="load_q" value="10"
                                           class="hidden peer">
                                    <label for="load-10"
                                           class="flex items-center justify-center p-1 w-7 h-7 text-white bg-red-400 border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-white dark:border-gray-700 dark:peer-checked:text-white dark:peer-checked:border-gray-200 peer-checked:border-gray-600 peer-checked:text-white hover:text-white hover:bg-red-500 dark:text-white dark:bg-red-400 dark:hover:bg-red-500">
                                        <div class="block">
                                            10
                                        </div>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <button type="button" id="button_send_load"
                            class="mt-5 w-full sm:w-96 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        {{ __('messages.Ответить') }}</button>
                    <div id="response_load" class="py-3"></div>
                </form>
                <button id="btn_load_success" data-modal-target="add_load_success"
                        data-modal-toggle="add_load_success"
                        class="hidden" type="button"></button>
                <div id="add_load_success" tabindex="-1" aria-hidden="true"
                     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div id="alert-border-3"
                         class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800"
                         role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <div class="ms-3 text-sm font-medium">
                            {{ __('messages.Ответ сохранен') }}
                        </div>
                        <button type="button"
                                class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                                data-dismiss-target="#alert-border-3" aria-label="Close">
                            <span class="sr-only">Dismiss</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @else
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-700 dark:text-green-400"
                     role="alert">
                    {{ __('messages.Сегодня вы ответили на вопрос о нагрузке') }}
                </div>
            @endif
        </div>

    @endif

    <script>
        $(document).ready(function () {

            function parseTimeToDate(timeStr) {
                let today = new Date();
                let parts = timeStr.split(':');
                return new Date(today.getFullYear(), today.getMonth(), today.getDate(),
                    parseInt(parts[0], 10), parseInt(parts[1], 10), parseInt(parts[2], 10));
            }

            function checkTime() {
                $.ajax({
                    url: '/time',
                    method: 'GET',
                    success: function (response) {
                        console.log(response.hasAnswerToday)
                        if (response.res === true && response.start && response.finish) {
                            let trainingStart = parseTimeToDate(response.start);
                            let hasAnswerToday = response.hasAnswerToday;

                            let trainingEnd = parseTimeToDate(response.finish);

                            let currentTime = new Date();

                            let minToStart = (trainingStart - currentTime) / 60000;
                            let minAfterEnd = (currentTime - trainingEnd) / 60000;

                            let recoveryWindowMin = response.question_recovery_min || 60;
                            let loadWindowMin = response.question_load_min || 60;

                            let untilTraining = 'До тренировки';
                            let minut = 'мин.';
                            let messageNoSurvey = 'Не пришло время для опроса';
                            let todayNoTraining = 'Сегодня тренировок нет';
                            let messagehasAnswerToday = 'Сегодня вы ответили на вопрос о восстановлении';

                            // Обновляем текст с оставшимися минутами до тренировки
                            if (minToStart > 0) {
                                $('#minutes_until_training').html(
                                    '<div class="bg-blue-100 text-white text-xs font-medium inline-flex items-center px-2.5 py-1 rounded-sm dark:bg-gray-700 dark:text-white border border-white-200">' +
                                    '<svg class="w-2.5 h-2.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"> <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/></svg>' +
                                    untilTraining + ': ' + Math.ceil(minToStart) + ' ' + minut +
                                    '</div>');
                            } else {
                                $('#minutes_until_training').html(''); // Очищаем если тренировка уже началась
                            }

                            if (minToStart <= recoveryWindowMin && minToStart > 0) {
                                $('#form_question_recovery').show('slow');
                                $('#form_question_load').hide();
                                if (hasAnswerToday) {
                                    $('#message').html(
                                        '<div class="flex w-fit items-center p-4 text-sm text-gray-800 rounded-lg bg-gray-50" role="alert">' +
                                        messagehasAnswerToday +
                                        '</div>'
                                    );
                                } else {
                                    $('#message').html(
                                        '<div class="flex w-fit items-center p-4 text-sm text-gray-800 rounded-lg bg-gray-50" role="alert">' +
                                        messageNoSurvey +
                                        '</div>'
                                    );
                                }
                                return;
                            }

                            if (minAfterEnd >= 0 && minAfterEnd <= loadWindowMin) {
                                $('#form_question_recovery').hide();
                                $('#form_question_load').show('slow');
                                $('#message').html('');
                                return;
                            }

                            $('#form_question_recovery').hide();
                            $('#form_question_load').hide();

                            if (hasAnswerToday) {
                                $('#message').html(
                                    '<div class="flex w-fit items-center p-4 text-sm text-gray-800 rounded-lg bg-gray-50" role="alert">' +
                                    messagehasAnswerToday +
                                    '</div>'
                                );
                            } else {
                                $('#message').html(
                                    '<div class="flex w-fit items-center p-4 text-sm text-gray-800 rounded-lg bg-gray-50" role="alert">' +
                                    messageNoSurvey +
                                    '</div>'
                                );
                            }

                        } else {
                            $('#form_question_recovery').hide();
                            $('#form_question_load').hide();
                            $('#message').html(
                                '<div class="flex items-center p-4 text-sm text-gray-800 rounded-lg bg-gray-50" role="alert">' +
                                '{{ __("messages.Сегодня тренировок нет") }}' +
                                '</div>'
                            );
                            $('#minutes_until_training').text(''); // очищаем если нет тренировки
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Ошибка AJAX:', error);
                    }
                });
            }

            checkTime();
            setInterval(checkTime, 5000);
        });
    </script>

@endif
