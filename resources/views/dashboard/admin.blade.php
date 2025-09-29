@php $referralSetting = Auth::user()->settings->firstWhere('slug', 'referral_code');  @endphp

<div class="w-full max-w-sm">
    <div class="mb-2 flex justify-between items-center">
        <label for="website-url" class="text-sm font-medium text-gray-900 dark:text-white">Ваша реферальная ссылка:</label>
    </div>
    <div class="flex items-center">
        <span
            class="shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg dark:bg-gray-600 dark:text-white dark:border-gray-600">REF</span>
        <div class="relative w-full">
            <input id="website-url" type="text" aria-describedby="helper-text-explanation"
                   class="bg-gray-50 border border-e-0 border-gray-300 text-gray-500 dark:text-gray-400 text-sm border-s-0 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                   value="{{ url('/register') }}?ref={{ $referralSetting->value }}" readonly disabled/>
        </div>
        <button data-tooltip-target="tooltip-website-url" data-copy-to-clipboard-target="website-url"
                class="shrink-0 z-10 inline-flex items-center py-3 px-4 text-sm font-medium text-center text-white bg-blue-700 rounded-e-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 border border-blue-700 dark:border-blue-600 hover:border-blue-800 dark:hover:border-blue-700"
                type="button">
            <span id="default-icon">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                     viewBox="0 0 18 20">
                    <path
                        d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                </svg>
            </span>
            <span id="success-icon" class="hidden">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
            </span>
        </button>
        <div id="tooltip-website-url" role="tooltip"
             class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
            <span id="default-tooltip-message">Скопировать</span>
            <span id="success-tooltip-message" class="hidden">Скопировано!</span>
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
    </div>
    <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">Ваши тренеры должны регистрироваться по вашей реферальной ссылке.</p>
</div>

<div class="relative overflow-x-auto mb-6 shadow-md sm:rounded-lg">
    <h2 class="flex justify-between items-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight py-4">
        Тренеры
    </h2>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">
                Имя
            </th>
            <th scope="col" class="px-6 py-3">
                Команды тренера
            </th>
            <th scope="col" class="px-6 py-3">
                Ссылка для входа
            </th>
            <th scope="col" class="px-6 py-3">
                Активность
            </th>
            <th scope="col" class="px-6 py-3">
                Удалить
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach(coaches(Auth::user()->id) as $coach)
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row"
                    class="flex gap-1 px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <div>{{ $coach->name }} {{ $coach->last_name }}</div>
                    @if($coach->active)
                        <div id="changeAvailable{{ $coach->id }}">
                            <div
                                class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                <div class="w-2 h-2 me-1 bg-green-500 rounded-full"></div>
                                {{ __('messages.Активный') }}
                            </div>
                        </div>
                    @else
                        <div id="changeAvailable{{ $coach->id }}">
                            <div
                                class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                <div class="w-2 h-2 me-1 bg-red-500 rounded-full"></div>
                                {{ __('messages.Не активный') }}
                            </div>
                        </div>
                    @endif
                </th>
                <th scope="row"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    @if(whatInArray(teamsOfCoach($coach->id)))
                        @foreach (teamsOfCoach($coach->id) as $key => $team)
                            {{ $team->name }} - {{ $team->team_code }}<br>
                        @endforeach
                    @else
                        <div>{{ __('messages.Команд нет') }}</div>
                    @endif
                </th>
                <td class="px-6 py-4">
                    <a href="/adminLoginAsUser/{{ $coach->id }}"
                       class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Войти
                        под этим пользователем</a>
                </td>

                <th scope="row"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="flex">
                        <input type="checkbox"
                               onclick="updateActive({{ $coach->id }}, '{{ __('messages.Активный') }}', '{{ __('messages.Не активный') }}', this)"
                               data-user-id="{{ $coach->id }}" {{ $coach->active ? 'checked' : '' }}>
                    </div>
                </th>
                <th scope="row"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <a id="button_del_user" href="javascript:void(0)"
                       class="p-2 rounded-md bg-red-500 hover:bg-red-700 flex w-fit h-full"
                       onclick="deleteUser({{ $coach->id }})"
                       title="{{ __('messages.Удалить') }}">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                               stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16"
                                    stroke="#d1d1d1" stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </g>
                        </svg>
                    </a>
                </th>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

