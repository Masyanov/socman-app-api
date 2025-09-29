<x-app-layout>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <x-slot name="header">
        <div class="flex w-full">
            <div class="flex flex-col lg:flex-row items-center justify-between w-full">

                <div class="flex mb-2 relative">
                    <button data-modal-target="add_team" data-modal-toggle="add_team" type="button"
                            class="relative text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-semibold rounded-full text-lg px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                        <span class="sr-only">Notifications</span>
                        {{ $team->name }}
                        @if ($team->active == 0)
                            <div
                                class="absolute inline-flex items-center justify-center w-7 h-7 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">{{ countPlayers($team->team_code) }}</div>
                        @else
                            <div
                                class="absolute inline-flex items-center justify-center w-7 h-7 text-xs font-bold text-white bg-green-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">{{ countPlayers($team->team_code) }}</div>
                        @endif
                    </button>
                </div>

                <div class="flex gap-6 mb-6 lg:mb-0 flex-col lg:justify-center lg:flex-row">
                    @if($team->desc)
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-tight pх-2">
                            {{ __('messages.Описание')}}
                            : {{ $team->desc }}
                        </p>
                    @endif


                    <div class="flex align-items-center gap-3">
                        <div class="w-2/3 mt-1 text-xs text-gray-700 dark:text-gray-400">
                            {{ __('messages.Код команды') }}:
                        </div>
                        <div class="w-full max-w-[16rem]">
                            <div class="relative">
                                <label for="code-team-copy-button-{{ $team->id }}"
                                       class="sr-only">Label</label>
                                <input id="code-team-copy-button-{{ $team->id }}" type="text"
                                       class="col-span-6 bg-gray-800 border border-gray-500 text-gray-500 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       value="{{ $team->team_code }}" disabled readonly>
                                <button
                                    data-copy-to-clipboard-target="code-team-copy-button-{{ $team->id }}"
                                    data-tooltip-target="tooltip-copy-code-team-copy-button-{{ $team->id }}"
                                    class="absolute end-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg p-2 inline-flex items-center justify-center">
                                    <div id="default-icon">
                                        <svg class="w-2.5 h-2.5" aria-hidden="true"
                                             xmlns="http://www.w3.org/2000/svg"
                                             fill="currentColor"
                                             viewBox="0 0 18 20">
                                            <path
                                                d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                                        </svg>
                                    </div>
                                    <div id="success-icon" class="hidden">
                                        <svg
                                            class="w-2.5 h-2.5 text-blue-700 dark:text-blue-500"
                                            aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 16 12">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                  stroke-linejoin="round" stroke-width="2"
                                                  d="M1 5.917 5.724 10.5 15 1.5"/>
                                        </svg>
                                    </div>
                                </button>
                                <div id="tooltip-copy-code-team-copy-button-{{ $team->id }}"
                                     role="tooltip"
                                     class="absolute z-10 invisible inline-block px-3 py-1 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                    <span id="default-tooltip-message-{{ $team->id }}">Скопировать</span>
                                    <span id="success-tooltip-message-{{ $team->id }}"
                                          class="hidden">Скопировано!</span>
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal toggle -->
                <div class="flex gap-6">
                    <button data-popover-target="popover-click" data-popover-trigger="click" type="button"
                            class="relative inline-flex items-center p-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg
                            hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-5 h-5" version="1.1" id="Layer_1" viewBox="0 0 511.998 511.998"
                             xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <path style="fill:#ffffff;"
                                          d="M369.656,476.269h-227.31c-27.913,0-50.622-22.708-50.622-50.622V223.836 c-5.662,3.533-12.161,5.594-19.048,5.959c-11.077,0.585-21.6-3.281-29.655-10.895l-30.459-28.789 c-14.842-14.026-16.774-36.908-4.498-53.226L71.68,52.326c7.236-9.617,21.224-16.597,33.258-16.597h51.088 c9.351,0,17.572,5.032,22.557,13.806c8.006,14.096,37.169,28.365,77.416,28.365c11.392,0,22.428-1.163,32.797-3.458 c7.373-1.628,14.666,3.023,16.296,10.392c1.63,7.37-3.022,14.666-10.392,16.296c-12.304,2.722-25.326,4.101-38.701,4.101 c-46.89,0-86.594-16.552-101.167-42.171h-49.892c-3.398,0-9.373,2.982-11.417,5.698l-63.616,84.558 c-3.905,5.191-3.29,12.468,1.43,16.929l30.459,28.789c2.562,2.42,5.926,3.65,9.431,3.464c3.521-0.187,6.72-1.764,9.01-4.443 l11.167-13.054c5.621-6.571,12.719-6.951,17.488-5.121c10.842,4.167,10.537,15.758,10.242,26.967 c-0.038,1.465-0.077,2.858-0.077,4.053v214.744c0,12.841,10.448,23.289,23.289,23.289h227.311 c12.841,0,23.289-10.448,23.289-23.289c0-7.548,6.118-13.667,13.667-13.667s13.667,6.118,13.667,13.667 C420.278,453.561,397.569,476.269,369.656,476.269z"></path>
                                    <path style="fill:#ffffff;"
                                          d="M406.612,350.299c-7.548,0-13.667-6.119-13.667-13.667v-125.73c0-1.196-0.038-2.59-0.078-4.053 c-0.294-11.209-0.599-22.8,10.243-26.967c4.77-1.831,11.868-1.45,17.486,5.122l11.166,13.052c2.292,2.679,5.491,4.257,9.012,4.443 c3.522,0.198,6.87-1.043,9.431-3.464l30.459-28.789c4.72-4.461,5.335-11.738,1.431-16.927L418.477,68.76 c-2.043-2.716-8.018-5.698-11.417-5.698h-51.377c-7.548,0-13.667-6.119-13.667-13.667s6.119-13.667,13.667-13.667h51.377 c12.035,0,26.023,6.98,33.258,16.598l63.618,84.559c12.277,16.317,10.343,39.2-4.498,53.226l-30.46,28.789 c-8.056,7.614-18.581,11.474-29.655,10.895c-6.888-0.366-13.385-2.424-19.048-5.959v112.797 C420.278,344.181,414.16,350.299,406.612,350.299z"></path>
                                </g>
                                <rect x="105.383" y="189.035" style="fill:#ffffff;" width="301.225"
                                      height="158.081"></rect>
                                <g>
                                    <path style="fill:#ffffff;"
                                          d="M406.612,360.775H105.39c-7.548,0-13.667-6.118-13.667-13.667V189.032 c0-7.548,6.119-13.667,13.667-13.667h301.222c7.548,0,13.667,6.119,13.667,13.667v158.077 C420.278,354.656,414.16,360.775,406.612,360.775z M119.056,333.441h273.889V202.697H119.056V333.441z"></path>
                                    <path style="fill:#000000;"
                                          d="M196.845,289.753v-39.837c0-25.859,16.086-35.48,36.831-35.48s36.982,9.621,36.982,35.48v39.837 c0,25.858-16.236,35.48-36.982,35.48S196.845,315.612,196.845,289.753z M247.208,249.915c0-10.374-5.111-15.033-13.53-15.033 c-8.419,0-13.38,4.659-13.38,15.033v39.837c0,10.374,4.961,15.033,13.38,15.033c8.419,0,13.53-4.659,13.53-15.033V249.915z"></path>
                                    <path style="fill:#000000;"
                                          d="M291.703,240.595l-4.36,2.705c-1.353,0.902-2.706,1.204-3.758,1.204c-4.36,0-7.366-4.66-7.366-9.321 c0-3.158,1.353-6.164,4.36-7.968l19.844-12.027c1.203-0.753,2.706-1.054,4.36-1.054c4.811,0,10.373,2.856,10.373,7.368v95.611 c0,4.812-5.863,7.216-11.726,7.216c-5.863,0-11.726-2.405-11.726-7.216V240.595z"></path>
                                </g>
                            </g></svg>
                        <span class="sr-only">Notifications</span>
                        <div
                            class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">{{ count(freeNumber($team->team_code)) }}</div>
                    </button>
                    @if(CountTeam() > 0)

                        <button id="btn_user_success" data-modal-target="add_user_success"
                                data-modal-toggle="add_user_success"
                                class="hidden" type="button"></button>
                        <div id="add_user_success" tabindex="-1" aria-hidden="true"
                             class="hidden  overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div id="alert-border-3"
                                 class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800"
                                 role="alert">
                                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                </svg>
                                <div class="ms-3 text-sm font-medium">
                                    {{ __('messages.Игрок создан') }}
                                </div>
                                <button type="button"
                                        class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                                        data-dismiss-target="#alert-border-3" aria-label="Close">
                                    <span class="sr-only">Dismiss</span>
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @else
                        <div
                            class="flex items-center p-4 text-sm text-gray-800 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600"
                            role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <div class="flex items-center flex-col gap-3  sm:flex-row">
                                {{ __('messages.Чтобы добавить игрока, вам необходимо создать команду.') }}
                                @if(Auth::user()->role == 'coach' || Auth::user()->role == 'admin')
                                    <a href="{{ route('teams.index') }}"
                                       class="ml-3 text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-2 py-1 text-center me-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                                        {{ __('messages.Мои команды') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div data-popover id="popover-click" role="tooltip"
                         class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border
                         border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                        <div
                            class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('messages.Свободные номера')}}</h3>
                        </div>
                        <div class="px-3 py-2">
                            <p>{{ implode(', ', freeNumber($team->team_code)) }}</p>
                        </div>
                        <div data-popper-arrow></div>
                    </div>
                    <button data-modal-target="add_team" data-modal-toggle="add_team"
                            class="h-fit w-fit flex text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium
                            rounded-lg text-sm p-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                            type="button" title="{{ __('messages.Редактировать команду') }}">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M15 6.5L17.5 9M11 20H20M4 20V17.5L16.75 4.75C17.4404 4.05964 18.5596 4.05964 19.25 4.75V4.75C19.9404 5.44036 19.9404 6.55964 19.25 7.25L6.5 20H4Z"
                                    stroke="#d1d1d1" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </g>
                        </svg>
                        <span class="sr-only">{{ __('messages.Редактировать команду') }}</span>
                    </button>
                    <form method="POST" action="{{ route('teams.destroy', $team->id) }}"
                          onsubmit="return confirm('Вы уверены, что хотите удалить команду?');"
                          style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium
                                rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                                title="{{ __('messages.Удалить') }}">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16"
                                    stroke="#d1d1d1" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                            <span class="sr-only">{{ __('messages.Удалить') }}</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main modal -->
            <div id="add_team" tabindex="-1" aria-hidden="true"
                 class="hidden bg-gray-900/80 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ __('messages.Редактировать команду') }}
                            </h3>
                            <button type="button"
                                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide="add_team">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">{{ __('messages.Закрыть окно') }}</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5">
                            <form class="space-y-4" method="PATCH">

                                @csrf

                                <input type="hidden" id="id" name="id" value="{{ $team->id }}"/>
                                <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}"/>
                                <!-- Name -->
                                <div>
                                    <x-input-label for="team_name" :value="__('messages.Название')"/>
                                    <x-text-input id="team_name" class="block mt-1 w-full" type="text" name="team_name"
                                                  :value="$team->name" required autofocus/>
                                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                                </div>

                                <div>
                                    <x-input-label for="desc" :value="__('messages.Описание')"/>
                                    <x-text-input id="desc" class="block mt-1 w-full" type="text" name="desc"
                                                  :value="$team->desc" autocomplete="desc"/>
                                    <x-input-error :messages="$errors->get('desc')" class="mt-2"/>
                                </div>
                                <div class="flex">
                                    <x-checkbox name="active" id="active" :checked="$team->active">
                                        {{ __('messages.Активный') }}
                                    </x-checkbox>
                                    <label class="ml-2 font-medium text-sm text-gray-700 dark:text-gray-300"
                                           for="active">{{ __('messages.Активный') }}</label>
                                </div>
                                <button type="button" id="button_edit_team"
                                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    {{ __('messages.Сохранить') }}
                                </button>
                                <div id="response"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <button id="btn_team_success" data-modal-target="add_team_success" data-modal-toggle="add_team_success"
            class="hidden" type="button"></button>
    <div id="add_team_success" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div id="alert-border-3"
             class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800"
             role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                 viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div class="ms-3 text-sm font-medium">
                {{ __('messages.Сохранено') }}
            </div>
            <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-border-3" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div>

                        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                                data-tabs-toggle="#default-tab-content" role="tablist">
                                <li class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab"
                                            data-tabs-target="#profile" type="button" role="tab"
                                            aria-controls="profile"
                                            aria-selected="false">
                                        {{ __('messages.Игроки') }}
                                    </button>
                                </li>

                                @if(checkLoadControl())
                                    <li class="me-2" role="presentation">
                                        <button
                                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                            id="settings-tab" data-tabs-target="#settings" type="button" role="tab"
                                            aria-controls="settings" aria-selected="false">
                                            {{ __('Load Control') }}
                                        </button>
                                    </li>
                                @endif
                                <li class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="test-tab"
                                            data-tabs-target="#test" type="button" role="tab"
                                            aria-controls="test"
                                            aria-selected="false">
                                        {{ __('messages.Посещение') }}
                                    </button>
                                </li>
                            </ul>
                        </div>


                        @if(!$usersOfTeam->isEmpty())
                            <div id="default-tab-content">
                                <div class="hidden rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel"
                                     aria-labelledby="profile-tab">
                                    <!-- Modal toggle -->
                                    <button data-modal-target="add_player" data-modal-toggle="add_player"
                                            class="mb-4 block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                                            type="button" title="{{ __('messages.Добавить игрока') }}">
                                        {{ __('messages.Добавить игрока') }}
                                    </button>

                                    <!-- Main modal -->
                                    <div id="add_player" tabindex="-1" aria-hidden="true"
                                         class="hidden bg-gray-900/80 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                <!-- Modal header -->
                                                <div
                                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                        {{ __('messages.Добавить нового игрока') }} в команду
                                                        - {{ $team->name }}
                                                    </h3>
                                                    <button type="button"
                                                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                            data-modal-hide="add_player">
                                                        <svg class="w-3 h-3" aria-hidden="true"
                                                             xmlns="http://www.w3.org/2000/svg"
                                                             fill="none"
                                                             viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                  stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                        </svg>
                                                        <span class="sr-only">{{ __('messages.Закрыть окно') }}</span>
                                                    </button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="p-4 md:p-5">

                                                    <form method="POST" action="{{ route('users.store') }}">
                                                        @csrf

                                                        <!-- Name -->
                                                        <div>
                                                            <x-input-label for="name" :value="__('messages.Имя')"/>
                                                            <x-text-input id="name" class="block mt-1 w-full"
                                                                          type="text" name="name"
                                                                          :value="old('name')" required
                                                                          autofocus autocomplete="name"/>
                                                            <x-input-error :messages="$errors->get('name')"
                                                                           class="mt-2"/>
                                                        </div>
                                                        <!-- Last Name -->
                                                        <div class="mt-4">
                                                            <x-input-label for="last_name"
                                                                           :value="__('messages.Фамилия')"/>
                                                            <x-text-input id="last_name" class="block mt-1 w-full"
                                                                          type="text"
                                                                          name="last_name"
                                                                          :value="old('last_name')" required
                                                                          autocomplete="last_name"/>
                                                            <x-input-error :messages="$errors->get('last_name')"
                                                                           class="mt-2"/>
                                                        </div>
                                                        <!-- Role -->

                                                        <input id="role" type="hidden" name="role" value="player"
                                                               class="hidden peer role">


                                                        <!-- Team Code -->
                                                        <div class="mt-4 hidden" id="code_field">
                                                            <x-input-label for="team_code"
                                                                           :value="__('messages.Код команды')"/>
                                                            <x-text-input id="team_code"
                                                                          class="block mt-1 w-full team_code"
                                                                          type="text"
                                                                          name="team_code"
                                                                          :value="$team->team_code"
                                                                          autocomplete="team_code"
                                                                          placeholder="999-999"/>
                                                            <x-input-error :messages="$errors->get('team_code')"
                                                                           class="mt-2"/>
                                                        </div>

                                                        <!-- Email Address -->
                                                        <div class="mt-4">
                                                            <x-input-label for="email" :value="__('Email')"/>
                                                            <x-text-input id="email" class="block mt-1 w-full"
                                                                          type="email" name="email"
                                                                          :value="old('email')" required
                                                                          autocomplete="username"/>
                                                            <x-input-error :messages="$errors->get('email')"
                                                                           class="mt-2"/>
                                                        </div>

                                                        <!-- Password -->
                                                        <div class="mt-4">
                                                            <x-input-label for="password"
                                                                           :value="__('messages.Пароль')"/>

                                                            <x-text-input id="password" class="block mt-1 w-full"
                                                                          type="password"
                                                                          name="password"
                                                                          required autocomplete="new-password"/>

                                                            <x-input-error :messages="$errors->get('password')"
                                                                           class="mt-2"/>
                                                        </div>

                                                        <!-- Confirm Password -->
                                                        <div class="mt-4">
                                                            <x-input-label for="password_confirmation"
                                                                           :value="__('messages.Подтверждение пароля')"/>

                                                            <x-text-input id="password_confirmation"
                                                                          class="block mt-1 w-full"
                                                                          type="password"
                                                                          name="password_confirmation" required
                                                                          autocomplete="new-password"/>

                                                            <x-input-error
                                                                :messages="$errors->get('password_confirmation')"
                                                                class="mt-2"/>
                                                        </div>

                                                        <div class="flex items-center justify-end mt-4">

                                                            <button type="button" id="button_save_user"
                                                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                                {{ __('messages.Регистрация') }}
                                                            </button>
                                                        </div>
                                                        <div id="response"></div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                                        <table
                                            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                            <thead
                                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    {{ __('messages.Фамилия') }} {{ __('messages.Имя') }}
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    {{ __('messages.Возраст') }}
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    {{ __('messages.Позиция') }}
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    {{ __('messages.Номер') }}
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    {{ __('messages.Телефон') }}
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    {{ __('messages.Активный') }}
                                                </th>
                                                <th scope="col" class="px-6 py-3">

                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($usersOfTeam as $user)
                                                <tr id="user-{{ $user->id }}"
                                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                    <td scope="row"
                                                        class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                                        @if($user->meta && $user->meta->avatar)
                                                            <a class=" w-10 h-10 relative" data-fancybox
                                                               data-src="/avatars/{{ $user->meta->avatar }}">
                                                                <img
                                                                    class="w-full h-10 rounded-full object-cover @if ($user->active == 0) grayscale @endif"
                                                                    src="/avatars/{{ $user->meta->avatar }}"
                                                                    alt="{{ $user->last_name }} {{ $user->name }}">
                                                            </a>
                                                        @else
                                                            <a class="w-10 h-10 relative" data-fancybox
                                                               data-src="/avatars/default-avatar.jpg">
                                                                <img class="w-full h-10 rounded-full object-contain"
                                                                     src="/images/default-avatar.jpg"
                                                                     alt="{{ $user->last_name }} {{ $user->name }}">
                                                            </a>

                                                        @endif
                                                        <div class="ps-3">
                                                            <a href="/users/{{ $user->id }}" type="button"
                                                               class="font-medium text-white dark:text-white">
                                                                <div
                                                                    class="text-base font-semibold @if ($user->active == 0) dark:text-gray-400 @endif">{{ $user->last_name }} {{ $user->name }}</div>
                                                            </a>
                                                            <div class="font-normal text-gray-500">
                                                                {{ $user->email }}
                                                            </div>
                                                            @if($user->active)
                                                                <div id="changeAvailable{{ $user->id }}">
                                                                    <div
                                                                        class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                                                        <div
                                                                            class="w-2 h-2 me-1 bg-green-500 rounded-full"></div>
                                                                        {{ __('messages.Активный') }}
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div id="changeAvailable{{ $user->id }}">
                                                                    <div
                                                                        class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                                                        <div
                                                                            class="w-2 h-2 me-1 bg-red-500 rounded-full"></div>
                                                                        {{ __('messages.Не активный') }}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        @if ($user->meta->birthday)
                                                            {{ \Carbon\Carbon::parse($user->meta->birthday)->age }}
                                                        @else
                                                            None
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $user->meta->position ?? 'None'  }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $user->meta->number ?? 'None'  }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div
                                                            class="flex gap-3 items-center justify-center h-full min-w-max">
                                                            {{ $user->meta->tel ?? 'None'  }}
                                                            @if($user->meta && $user->meta->tel)
                                                                <a href="tel:{{ $user->meta->tel }}"
                                                                   class="p-1 rounded-md bg-green-500 hover:bg-green-700 flex h-full">
                                                                    <svg class="w-3 h-3 " viewBox="0 0 24 24"
                                                                         fill="none"
                                                                         xmlns="http://www.w3.org/2000/svg">
                                                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                        <g id="SVGRepo_tracerCarrier"
                                                                           stroke-linecap="round"
                                                                           stroke-linejoin="round"></g>
                                                                        <g id="SVGRepo_iconCarrier">
                                                                            <path
                                                                                d="M13.5 2C13.5 2 15.8335 2.21213 18.8033 5.18198C21.7731 8.15183 21.9853 10.4853 21.9853 10.4853"
                                                                                stroke="#ffffff" stroke-width="1.5"
                                                                                stroke-linecap="round"></path>
                                                                            <path
                                                                                d="M14.207 5.53564C14.207 5.53564 15.197 5.81849 16.6819 7.30341C18.1668 8.78834 18.4497 9.77829 18.4497 9.77829"
                                                                                stroke="#ffffff" stroke-width="1.5"
                                                                                stroke-linecap="round"></path>
                                                                            <path
                                                                                d="M15.1007 15.0272L14.5569 14.5107L15.1007 15.0272ZM15.5562 14.5477L16.1 15.0642H16.1L15.5562 14.5477ZM17.9728 14.2123L17.5987 14.8623H17.5987L17.9728 14.2123ZM19.8833 15.312L19.5092 15.962L19.8833 15.312ZM20.4217 18.7584L20.9655 19.2749L20.4217 18.7584ZM19.0011 20.254L18.4573 19.7375L19.0011 20.254ZM17.6763 20.9631L17.7499 21.7095L17.6763 20.9631ZM7.81536 16.4752L8.35915 15.9587L7.81536 16.4752ZM3.00289 6.96594L2.25397 7.00613L2.25397 7.00613L3.00289 6.96594ZM9.47752 8.50311L10.0213 9.01963H10.0213L9.47752 8.50311ZM9.63424 5.6931L10.2466 5.26012L9.63424 5.6931ZM8.37326 3.90961L7.76086 4.3426V4.3426L8.37326 3.90961ZM5.26145 3.60864L5.80524 4.12516L5.26145 3.60864ZM3.69185 5.26114L3.14806 4.74462L3.14806 4.74462L3.69185 5.26114ZM11.0631 13.0559L11.6069 12.5394L11.0631 13.0559ZM15.6445 15.5437L16.1 15.0642L15.0124 14.0312L14.5569 14.5107L15.6445 15.5437ZM17.5987 14.8623L19.5092 15.962L20.2575 14.662L18.347 13.5623L17.5987 14.8623ZM19.8779 18.2419L18.4573 19.7375L19.5449 20.7705L20.9655 19.2749L19.8779 18.2419ZM17.6026 20.2167C16.1676 20.3584 12.4233 20.2375 8.35915 15.9587L7.27157 16.9917C11.7009 21.655 15.9261 21.8895 17.7499 21.7095L17.6026 20.2167ZM8.35915 15.9587C4.48303 11.8778 3.83285 8.43556 3.75181 6.92574L2.25397 7.00613C2.35322 8.85536 3.1384 12.6403 7.27157 16.9917L8.35915 15.9587ZM9.7345 9.32159L10.0213 9.01963L8.93372 7.9866L8.64691 8.28856L9.7345 9.32159ZM10.2466 5.26012L8.98565 3.47663L7.76086 4.3426L9.02185 6.12608L10.2466 5.26012ZM4.71766 3.09213L3.14806 4.74462L4.23564 5.77765L5.80524 4.12516L4.71766 3.09213ZM9.1907 8.80507C8.64691 8.28856 8.64622 8.28929 8.64552 8.29002C8.64528 8.29028 8.64458 8.29102 8.64411 8.29152C8.64316 8.29254 8.64219 8.29357 8.64121 8.29463C8.63924 8.29675 8.6372 8.29896 8.6351 8.30127C8.63091 8.30588 8.62646 8.31087 8.62178 8.31625C8.61243 8.32701 8.60215 8.33931 8.59116 8.3532C8.56918 8.38098 8.54431 8.41512 8.51822 8.45588C8.46591 8.53764 8.40917 8.64531 8.36112 8.78033C8.26342 9.0549 8.21018 9.4185 8.27671 9.87257C8.40742 10.7647 8.99198 11.9644 10.5193 13.5724L11.6069 12.5394C10.1793 11.0363 9.82761 10.1106 9.76086 9.65511C9.72866 9.43536 9.76138 9.31957 9.77432 9.28321C9.78159 9.26277 9.78635 9.25709 9.78169 9.26437C9.77944 9.26789 9.77494 9.27451 9.76738 9.28407C9.76359 9.28885 9.75904 9.29437 9.7536 9.30063C9.75088 9.30375 9.74793 9.30706 9.74476 9.31056C9.74317 9.31231 9.74152 9.3141 9.73981 9.31594C9.73896 9.31686 9.73809 9.31779 9.7372 9.31873C9.73676 9.3192 9.73608 9.31992 9.73586 9.32015C9.73518 9.32087 9.7345 9.32159 9.1907 8.80507ZM10.5193 13.5724C12.0422 15.1757 13.1923 15.806 14.0698 15.9485C14.5201 16.0216 14.8846 15.9632 15.1606 15.8544C15.2955 15.8012 15.4022 15.7387 15.4823 15.6819C15.5223 15.6535 15.5556 15.6266 15.5824 15.6031C15.5959 15.5913 15.6077 15.5803 15.618 15.5703C15.6232 15.5654 15.628 15.5606 15.6324 15.5562C15.6346 15.554 15.6367 15.5518 15.6387 15.5497C15.6397 15.5487 15.6407 15.5477 15.6417 15.5467C15.6422 15.5462 15.6429 15.5454 15.6431 15.5452C15.6438 15.5444 15.6445 15.5437 15.1007 15.0272C14.5569 14.5107 14.5576 14.51 14.5583 14.5093C14.5585 14.509 14.5592 14.5083 14.5596 14.5078C14.5605 14.5069 14.5614 14.506 14.5623 14.5051C14.5641 14.5033 14.5658 14.5015 14.5674 14.4998C14.5708 14.4965 14.574 14.4933 14.577 14.4904C14.583 14.4846 14.5885 14.4796 14.5933 14.4754C14.6028 14.467 14.6099 14.4616 14.6145 14.4584C14.6239 14.4517 14.6229 14.454 14.6102 14.459C14.5909 14.4666 14.5 14.4987 14.3103 14.4679C13.9077 14.4025 13.0391 14.0472 11.6069 12.5394L10.5193 13.5724ZM8.98565 3.47663C7.97206 2.04305 5.94384 1.80119 4.71766 3.09213L5.80524 4.12516C6.32808 3.57471 7.24851 3.61795 7.76086 4.3426L8.98565 3.47663ZM3.75181 6.92574C3.73038 6.52644 3.90425 6.12654 4.23564 5.77765L3.14806 4.74462C2.61221 5.30877 2.20493 6.09246 2.25397 7.00613L3.75181 6.92574ZM18.4573 19.7375C18.1783 20.0313 17.8864 20.1887 17.6026 20.2167L17.7499 21.7095C18.497 21.6357 19.1016 21.2373 19.5449 20.7705L18.4573 19.7375ZM10.0213 9.01963C10.9889 8.00095 11.0574 6.40678 10.2466 5.26012L9.02185 6.12608C9.44399 6.72315 9.37926 7.51753 8.93372 7.9866L10.0213 9.01963ZM19.5092 15.962C20.33 16.4345 20.4907 17.5968 19.8779 18.2419L20.9655 19.2749C22.2704 17.901 21.8904 15.6019 20.2575 14.662L19.5092 15.962ZM16.1 15.0642C16.4854 14.6584 17.086 14.5672 17.5987 14.8623L18.347 13.5623C17.2485 12.93 15.8861 13.1113 15.0124 14.0312L16.1 15.0642Z"
                                                                                fill="#ffffff"></path>
                                                                        </g>
                                                                    </svg>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 ">
                                                        <div class="flex">
                                                            <input type="checkbox"
                                                                   onclick="updateActive({{ $user->id }}, '{{ __('messages.Активный') }}', '{{ __('messages.Не активный') }}', this)"
                                                                   data-user-id="{{ $user->id }}" {{ $user->active ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex gap-3 items-center justify-center h-full">
                                                            <a href="/users/{{ $user->id }}" type="button"
                                                               class="p-2 rounded-md bg-blue-500 hover:bg-blue-700 flex h-full"
                                                               title="{{ __('messages.Редактировать') }}">
                                                                <svg class="w-5 h-5 " viewBox="0 0 24 24" fill="none"
                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                       stroke-linejoin="round"></g>
                                                                    <g id="SVGRepo_iconCarrier">
                                                                        <path
                                                                            d="M15 6.5L17.5 9M11 20H20M4 20V17.5L16.75 4.75C17.4404 4.05964 18.5596 4.05964 19.25 4.75V4.75C19.9404 5.44036 19.9404 6.55964 19.25 7.25L6.5 20H4Z"
                                                                            stroke="#d1d1d1" stroke-width="2"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round"></path>
                                                                    </g>
                                                                </svg>
                                                            </a>
                                                            <a id="button_del_user" href="javascript:void(0)"
                                                               class="p-2 rounded-md bg-red-500 hover:bg-red-700 flex h-full"
                                                               onclick="deletePlayer({{ $user->id }})"
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
                                                        </div>
                                                    </td>

                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                @if(checkLoadControl())
                                    <div class="hidden rounded-lg bg-gray-50 dark:bg-gray-800" id="settings"
                                         role="tabpanel"
                                         aria-labelledby="settings-tab">

                                        <div id="accordion-collapse" data-accordion="collapse">
                                            <h2 id="accordion-collapse-heading-1">
                                                <button type="button"
                                                        class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                                                        data-accordion-target="#accordion-collapse-body-1"
                                                        aria-expanded="true" aria-controls="accordion-collapse-body-1">
                                                    <span>{{ __('messages.Среднее по команде')}} - {{ $team->name }}</span>
                                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0"
                                                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                         fill="none" viewBox="0 0 10 6">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                              stroke-linejoin="round" stroke-width="2"
                                                              d="M9 5 5 1 1 5"/>
                                                    </svg>
                                                </button>
                                            </h2>
                                            <div id="accordion-collapse-body-1" class="hidden"
                                                 aria-labelledby="accordion-collapse-heading-1">
                                                @if($weeks)
                                                    <div
                                                        class="p-5 border border-t-0 border-gray-200 dark:border-gray-700">
                                                        <div class="mb-6 flex flex-col md:flex-row gap-3">
                                                            <select id="weekSelect" name="week"
                                                                    class="flex w-full md:w-fit bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                @foreach ($weeks as $week)
                                                                    <option value="{{ $week['value'] }}">
                                                                        {{ $week['label'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="flex gap-3">
                                                                <button id="filter_button_week"
                                                                        class="flex w-full md:w-fit  text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                                                        type="button">{{ __('messages.Фильтровать')}}
                                                                </button>
                                                                <button id="clear_storage_button_week" type="button"
                                                                        class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500">
                                                                    <svg class="w-5 h-5" viewBox="0 0 24 24"
                                                                         fill="currentColor"
                                                                         xmlns="http://www.w3.org/2000/svg">
                                                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                        <g id="SVGRepo_tracerCarrier"
                                                                           stroke-linecap="round"
                                                                           stroke-linejoin="round"></g>
                                                                        <g id="SVGRepo_iconCarrier">
                                                                            <path
                                                                                d="M16.8809 10C14.2609 10 12.1309 12.13 12.1309 14.75C12.1309 15.64 12.3809 16.48 12.8209 17.2C13.6409 18.58 15.1509 19.5 16.8809 19.5C18.6109 19.5 20.1209 18.57 20.9409 17.2C21.3809 16.49 21.6309 15.64 21.6309 14.75C21.6309 12.13 19.5109 10 16.8809 10ZM18.6809 16.52C18.5309 16.67 18.3409 16.74 18.1509 16.74C17.9609 16.74 17.7709 16.67 17.6209 16.52L16.9009 15.8L16.1509 16.55C16.0009 16.7 15.8109 16.77 15.6209 16.77C15.4309 16.77 15.2409 16.7 15.0909 16.55C14.8009 16.26 14.8009 15.78 15.0909 15.49L15.8409 14.74L15.1209 14.01C14.8309 13.72 14.8309 13.24 15.1209 12.95C15.4109 12.66 15.8909 12.66 16.1809 12.95L16.9009 13.67L17.6009 12.97C17.8909 12.68 18.3709 12.68 18.6609 12.97C18.9509 13.26 18.9509 13.74 18.6609 14.03L17.9609 14.73L18.6809 15.46C18.9809 15.75 18.9809 16.23 18.6809 16.52Z"
                                                                                fill="currentColor"></path>
                                                                            <path
                                                                                d="M20.5799 4.02V6.24C20.5799 7.05 20.0799 8.06 19.5799 8.57L19.3999 8.73C19.2599 8.86 19.0499 8.89 18.8699 8.83C18.6699 8.76 18.4699 8.71 18.2699 8.66C17.8299 8.55 17.3599 8.5 16.8799 8.5C13.4299 8.5 10.6299 11.3 10.6299 14.75C10.6299 15.89 10.9399 17.01 11.5299 17.97C12.0299 18.81 12.7299 19.51 13.4899 19.98C13.7199 20.13 13.8099 20.45 13.6099 20.63C13.5399 20.69 13.4699 20.74 13.3999 20.79L11.9999 21.7C10.6999 22.51 8.90992 21.6 8.90992 19.98V14.63C8.90992 13.92 8.50992 13.01 8.10992 12.51L4.31992 8.47C3.81992 7.96 3.41992 7.05 3.41992 6.45V4.12C3.41992 2.91 4.31992 2 5.40992 2H18.5899C19.6799 2 20.5799 2.91 20.5799 4.02Z"
                                                                                fill="currentColor"></path>
                                                                        </g>
                                                                    </svg>
                                                                    <span
                                                                        class="sr-only">{{ __('messages.Очистить фильтр')}}</span>
                                                                </button>
                                                            </div>

                                                        </div>
                                                        <div class="overflow-x-auto">
                                                            <div
                                                                class="w-3xl p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900"
                                                                style="width: 600px;height: 350px;">
                                                                <div id="results_filter_data_charts">
                                                                    @include('partials.data_charts', [
                                                                        'teamChars' => $teamChars,
                                                                        'datesForSelect' => $datesForSelect,
                                                                        'resultsCycle' => $resultsCycle,
                                                                    ])
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div
                                                        class="p-5 border border-t-0 border-gray-200 dark:border-gray-700 font-normal text-gray-500">{{ __('messages.Нет данных')}}</div>
                                                @endif
                                            </div>
                                            <h2 id="accordion-collapse-heading-2">
                                                <button type="button"
                                                        class="flex justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                                                        data-accordion-target="#accordion-collapse-body-2"
                                                        aria-expanded="false" aria-controls="accordion-collapse-body-2">
                                                    <span>{{ __('messages.Подробно по каждому игроку')}}</span>
                                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0"
                                                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                         fill="none" viewBox="0 0 10 6">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                              stroke-linejoin="round" stroke-width="2"
                                                              d="M9 5 5 1 1 5"/>
                                                    </svg>
                                                </button>
                                            </h2>
                                            <div id="accordion-collapse-body-2" class="hidden"
                                                 aria-labelledby="accordion-collapse-heading-2">
                                                @if($weeks)
                                                    <div
                                                        class="p-5 border border-t-0 border-gray-200 dark:border-gray-700">
                                                        <div class="mb-6">
                                                            <div
                                                                class="flex flex-col lg:flex-row gap-3 justify-between">
                                                                <div class="flex flex-col md:flex-row gap-3">
                                                                    <meta name="csrf-token"
                                                                          content="{{ csrf_token() }}">
                                                                    <input type="hidden" id="team_id"
                                                                           value="{{ $team->id }}">

                                                                    <select id="weekSelectDetail" name="week_detail"
                                                                            class="flex w-full md:w-fit bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                        @foreach ($weeks as $week)
                                                                            <option value="{{ $week['value'] }}">
                                                                                {{ $week['label'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>

                                                                    <select id="playerSelect" name="player_id"
                                                                            class="flex w-full md:w-fit bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block  p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                        <option selected
                                                                                value="">{{ __('messages.Все игроки')}}</option>
                                                                        @foreach ($usersOfTeam as $user)
                                                                            @if($user->active)
                                                                                <option class="text-gray-200"
                                                                                        value="{{ $user->id }}">
                                                                                    {{ $user->last_name }} {{ $user->name }}
                                                                                </option>
                                                                            @else
                                                                                <option class="text-red-300"
                                                                                        value="{{ $user->id }}"
                                                                                        disabled>
                                                                                    {{ $user->last_name }} {{ $user->name }}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="flex gap-3">
                                                                        <button id="filter_button"
                                                                                class="flex w-full md:w-fit text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                                                                type="button">{{ __('messages.Фильтровать')}}
                                                                        </button>
                                                                        <button id="clear_storage_button" type="button"
                                                                                class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500">
                                                                            <svg class="w-5 h-5" viewBox="0 0 24 24"
                                                                                 fill="currentColor"
                                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                                <g id="SVGRepo_bgCarrier"
                                                                                   stroke-width="0"></g>
                                                                                <g id="SVGRepo_tracerCarrier"
                                                                                   stroke-linecap="round"
                                                                                   stroke-linejoin="round"></g>
                                                                                <g id="SVGRepo_iconCarrier">
                                                                                    <path
                                                                                        d="M16.8809 10C14.2609 10 12.1309 12.13 12.1309 14.75C12.1309 15.64 12.3809 16.48 12.8209 17.2C13.6409 18.58 15.1509 19.5 16.8809 19.5C18.6109 19.5 20.1209 18.57 20.9409 17.2C21.3809 16.49 21.6309 15.64 21.6309 14.75C21.6309 12.13 19.5109 10 16.8809 10ZM18.6809 16.52C18.5309 16.67 18.3409 16.74 18.1509 16.74C17.9609 16.74 17.7709 16.67 17.6209 16.52L16.9009 15.8L16.1509 16.55C16.0009 16.7 15.8109 16.77 15.6209 16.77C15.4309 16.77 15.2409 16.7 15.0909 16.55C14.8009 16.26 14.8009 15.78 15.0909 15.49L15.8409 14.74L15.1209 14.01C14.8309 13.72 14.8309 13.24 15.1209 12.95C15.4109 12.66 15.8909 12.66 16.1809 12.95L16.9009 13.67L17.6009 12.97C17.8909 12.68 18.3709 12.68 18.6609 12.97C18.9509 13.26 18.9509 13.74 18.6609 14.03L17.9609 14.73L18.6809 15.46C18.9809 15.75 18.9809 16.23 18.6809 16.52Z"
                                                                                        fill="currentColor"></path>
                                                                                    <path
                                                                                        d="M20.5799 4.02V6.24C20.5799 7.05 20.0799 8.06 19.5799 8.57L19.3999 8.73C19.2599 8.86 19.0499 8.89 18.8699 8.83C18.6699 8.76 18.4699 8.71 18.2699 8.66C17.8299 8.55 17.3599 8.5 16.8799 8.5C13.4299 8.5 10.6299 11.3 10.6299 14.75C10.6299 15.89 10.9399 17.01 11.5299 17.97C12.0299 18.81 12.7299 19.51 13.4899 19.98C13.7199 20.13 13.8099 20.45 13.6099 20.63C13.5399 20.69 13.4699 20.74 13.3999 20.79L11.9999 21.7C10.6999 22.51 8.90992 21.6 8.90992 19.98V14.63C8.90992 13.92 8.50992 13.01 8.10992 12.51L4.31992 8.47C3.81992 7.96 3.41992 7.05 3.41992 6.45V4.12C3.41992 2.91 4.31992 2 5.40992 2H18.5899C19.6799 2 20.5799 2.91 20.5799 4.02Z"
                                                                                        fill="currentColor"></path>
                                                                                </g>
                                                                            </svg>
                                                                            <span
                                                                                class="sr-only">{{ __('messages.Очистить фильтр')}}</span>
                                                                        </button>
                                                                    </div>

                                                                </div>


                                                                <div>
                                                                    @php
                                                                        $user = Auth::user();
                                                                        $aiSetting = $user->settings->where('slug', 'ai')->first();
                                                                    @endphp

                                                                    @if($aiSetting && $aiSetting->active)

                                                                        <button id="ai-analyze-btn"
                                                                                data-popover-target="popover-AI"
                                                                                type="button"
                                                                                class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br
               focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg
               shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                                            {{ __('messages.AI Анализ') }}
                                                                        </button>

                                                                        <div data-popover id="popover-AI" role="tooltip"
                                                                             class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-xs opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                                                            <div
                                                                                class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                                                                <h3 class="font-semibold text-gray-900 dark:text-white">
                                                                                    {{ __('messages.AI Анализ')}}</h3>
                                                                            </div>
                                                                            <div class="px-3 py-2">
                                                                                <p>{{ __('messages.Этот сервис позволит сформировать анализ и дать рекомендации изходя из выбранных данных, с помощью искусственного интеллекта.')}} </p>
                                                                            </div>
                                                                            <div data-popper-arrow></div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="flex pt-4">
                                                                <div class="flex items-center h-5">
                                                                    <input id="togglePlanned"
                                                                           aria-describedby="helper-checkbox-text"
                                                                           type="checkbox" value=""
                                                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                                           checked
                                                                    >
                                                                </div>
                                                                <div class="ms-2 text-sm">
                                                                    <label for="togglePlanned"
                                                                           class="font-medium text-gray-900 dark:text-gray-300">Планируемый
                                                                        Load Control</label>
                                                                    <p id="helper-checkbox-text"
                                                                       class="text-xs font-normal text-gray-500 dark:text-gray-300">
                                                                        Если в тренировках запланирован уровень нагрузки
                                                                        и восстановления</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="results_AI_data"></div>
                                                        <div id="results_filter_data">
                                                            @include('partials.data_table', [
                                                                'team' => $team,
                                                                'usersOfTeam' => $usersOfTeam,
                                                                'dates' => $dates,
                                                                'results' => $results
                                                            ])
                                                        </div>
                                                    </div>
                                                @else
                                                    <div
                                                        class="p-5 border border-t-0 border-gray-200 dark:border-gray-700 font-normal text-gray-500">{{ __('messages.Нет данных')}}</div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                @endif
                                <div class="hidden rounded-lg bg-gray-50 dark:bg-gray-800" id="test"
                                     role="tabpanel"
                                     aria-labelledby="test-tab">
                                    <div class="p-4">
                                        <form id="filterForm" class="flex flex-col mb-4 flex gap-2 items-center">
                                            <input type="hidden" name="team_code" value="{{ $team->team_code }}">
                                            <label>Выбери месяц:</label>
                                            <input type="month" name="month" value=""
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-fit ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            >
                                        </form>
                                        <div id="calendarLoader" class="flex justify-center py-6 hidden">
                                            {{-- SVG loader --}}
                                            <svg width="50px" fill="#FFFFFFFF" viewBox="0 0 24 24"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="4" cy="12" r="3" opacity="1">
                                                    <animate id="spinner_qYjJ" begin="0;spinner_t4KZ.end-0.25s"
                                                             attributeName="opacity" dur="0.75s" values="1;.2"
                                                             fill="freeze"/>
                                                </circle>
                                                <circle cx="12" cy="12" r="3" opacity=".4">
                                                    <animate begin="spinner_qYjJ.begin+0.15s" attributeName="opacity"
                                                             dur="0.75s" values="1;.2" fill="freeze"/>
                                                </circle>
                                                <circle cx="20" cy="12" r="3" opacity=".3">
                                                    <animate id="spinner_t4KZ" begin="spinner_qYjJ.begin+0.3s"
                                                             attributeName="opacity" dur="0.75s" values="1;.2"
                                                             fill="freeze"/>
                                                </circle>
                                            </svg>
                                        </div>
                                        <div id="calendarContainer" class="overflow-auto"></div>
                                    </div>

                                    <script>
                                        document.querySelector('input[name="month"]').addEventListener('change', function () {
                                            let loader = document.getElementById('calendarLoader');
                                            let container = document.getElementById('calendarContainer');

                                            let formData = new FormData(document.getElementById('filterForm'));
                                            let params = new URLSearchParams(formData).toString();

                                            // Show loader and hide table
                                            loader.classList.remove('hidden');
                                            container.classList.add('hidden');

                                            fetch("{{ route('attendance.calendar') }}?" + params, {
                                                headers: {'X-Requested-With': 'XMLHttpRequest'}
                                            })
                                                .then(res => res.text())
                                                .then(html => {
                                                    container.innerHTML = html;
                                                })
                                                .finally(() => {
                                                    // Hide loader and show table
                                                    loader.classList.add('hidden');
                                                    container.classList.remove('hidden');
                                                });
                                        });
                                    </script>
                                </div>
                            </div>
                        @else
                            <div
                                class=" w-fit mt-3 mb-3 p-4 text-sm text-gray-800 rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-gray-300"
                                role="alert">
                                {{ __('messages.В команде нет игроков') }}
                            </div>
                            <a href="/users"
                               class="block w-fit text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                            >
                                {{ __('messages.Добавить игрока') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="toast-danger"
         class="absolute top-3 right-2 flex opacity-0 -z-10 items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-700"
         role="alert">
        <div
            class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                 viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
            </svg>
        </div>
        <div class="ms-3 text-sm font-normal">{{ __('messages.Игрок удален') }}</div>
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
    <style>
        #resultContent {
            max-height: 1000px;
            overflow: hidden;
            opacity: 1;
            transition: max-height 0.5s ease, opacity 0.5s ease;
        }

        #resultContent.hidden {
            max-height: 0;
            opacity: 0;
            pointer-events: none;
        }
    </style>
    <script>
        const ai = document.getElementById('ai-analyze-btn');
        if (ai) {
            document.getElementById('ai-analyze-btn').addEventListener('click', function () {
                let team_id = document.getElementById('team_id').value;
                let weekSelectDetail = document.getElementById('weekSelectDetail').value;
                let player_id = document.getElementById('playerSelect').value;

                let data = {
                    team_id: team_id,
                    weekSelectDetail: weekSelectDetail,
                    player_id: player_id,
                };

                // Сбросить/очистить блок
                document.getElementById('results_AI_data').innerHTML = '<div class="flex align-items-center gap-3 w-full p-5 my-2.5 bg-gray-700 rounded-lg"><h2  class="mb-0 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Анализируем </h2><svg width="50px" fill="#FFFFFFFF" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><circle cx="4" cy="12" r="3" opacity="1"><animate id="spinner_qYjJ" begin="0;spinner_t4KZ.end-0.25s" attributeName="opacity" dur="0.75s" values="1;.2" fill="freeze"/></circle><circle cx="12" cy="12" r="3" opacity=".4"><animate begin="spinner_qYjJ.begin+0.15s" attributeName="opacity" dur="0.75s" values="1;.2" fill="freeze"/></circle><circle cx="20" cy="12" r="3" opacity=".3"><animate id="spinner_t4KZ" begin="spinner_qYjJ.begin+0.3s" attributeName="opacity" dur="0.75s" values="1;.2" fill="freeze"/></circle></svg></div>';

                fetch('/ai-analyze', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(data)
                })
                    .then(r => r.json())
                    .then(data => {
                        document.getElementById('results_AI_data').innerHTML = '<div class="flex flex-col w-full p-5 my-2.5 bg-gray-700 rounded-lg"><div class="flex w-full mb-3 flex-col gap-3 sm:flex-row sm:justify-between "><h2  class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Результат анализа ИИ</h2><button id="showHideResultContent" type="button" class="py-2.5 px-5 ms-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Скрыть</button></div><div id="resultContent" class="font-normal text-gray-700 dark:text-gray-400">' + data.result + '</div></div>';
                    })
                    .catch(err => {
                        console.log('Ошибка:' + err);
                        document.getElementById('results_AI_data').innerHTML = '<div class="w-full p-5 my-2.5 bg-gray-700 rounded-lg">Ошибка анализа ИИ. Попробуйте повторить. </div>';
                    });
            });
        }
        ;

        document.addEventListener('click', function (event) {
            const button = document.getElementById('showHideResultContent');
            const content = document.getElementById('resultContent');

            if (!button || !content) return;

            if (event.target === button) {
                content.classList.toggle('hidden');

                if (content.classList.contains('hidden')) {
                    button.textContent = 'Показать';
                } else {
                    button.textContent = 'Скрыть';
                }
            }
        });


    </script>
</x-app-layout>




