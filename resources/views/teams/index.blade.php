<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.Мои команды') }}
            </h2>
            @if (Auth::user()->active == 1)
                <!-- Modal toggle -->
                <button data-modal-target="add_team" data-modal-toggle="add_team"
                        class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                        type="button">
                    {{ __('messages.Добавить команду') }}
                </button>

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
                                    {{ __('messages.Добавить новую команду') }}
                                </h3>
                                <button type="button"
                                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-hide="add_team">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">{{ __('messages.Закрыть окно') }}</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-4 md:p-5">
                                <form class="space-y-4" method="POST" action="{{ route('teams.store') }}">

                                    @csrf
                                    <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}"/>
                                    <!-- Name -->
                                    <div>
                                        <x-input-label for="team_name" :value="__('messages.Название')"/>
                                        <x-text-input id="team_name" class="block mt-1 w-full" type="text"
                                                      name="team_name"
                                                      :value="old('name')" required autofocus/>
                                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                                    </div>
                                    <!-- Team Code -->
                                    <div class="mt-4" id="code_field">
                                        <x-input-label for="team_code" :value="__('messages.Код команды')"/>
                                        <x-text-input id="team_code" class="block mt-1 w-full team_code" type="text"
                                                      name="team_code" :value="old('team_code')" required
                                                      autocomplete="team_code" placeholder="999-999"/>
                                        <x-input-error :messages="$errors->get('team_code')" class="mt-2"/>
                                    </div>
                                    <!-- Desc -->
                                    <div>
                                        <x-input-label for="desc" :value="__('messages.Описание')"/>
                                        <x-text-input id="desc" class="block mt-1 w-full" type="text" name="desc"
                                                      :value="old('desc')" autocomplete="desc"/>
                                        <x-input-error :messages="$errors->get('desc')" class="mt-2"/>
                                    </div>
                                    <button type="button" id="button_save_team"
                                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        {{ __('messages.Добавить команду') }}</button>
                                    <div id="response"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (Auth::user()->active == 0)
                        <div
                            class="inline-flex items-center bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 mx-1 my-2.5 rounded-full dark:bg-gray-700 dark:text-gray-300">
                            <span class="w-2 h-2 me-1 bg-gray-500 rounded-full"></span>
                            {{ __('messages.Ваш аккаунт не активен. Обратитесь к вашему тренеру, чтобы он вас активировал.') }}
                        </div>
                    @else
                        <div class="grid gap-x-2 gap-y-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                            @if(whatInArray($teams))
                                @foreach ($teams as $key => $team)
                                    <div id="team-{{ $team->id }}"
                                         class="flex relative flex-col justify-between m-2 max-w-sm p-6 bg-white border rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                        <div>
                                            <a href="teams/{{ $team->id }}">
                                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $team->name }} </h5>
                                            </a>

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
                                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $team->desc }}</p>
                                        </div>

                                        <a href="teams/{{ $team->id }}"
                                           class="w-fit inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  dark:hover:bg-blue-700 dark:focus:ring-blue-800
                                       @if ($team->active == 0) dark:bg-gray-600 @else dark:bg-blue-600 @endif
                                       ">
                                            {{ __('messages.Открыть') }}
                                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                                 xmlns="http://www.w3.org/2000/svg"
                                                 fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                            </svg>
                                        </a>
                                        <div class="mb-2">
                                            @if ($team->active == 0)
                                                <div
                                                    class="absolute inline-flex items-center justify-center w-8 h-8 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">{{ countPlayers($team->team_code) }}</div>
                                            @else
                                                <div
                                                    class="absolute inline-flex items-center justify-center w-8 h-8 text-xs font-bold text-white bg-green-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">{{ countPlayers($team->team_code) }}</div>
                                                @if(countNoActivePlayers($team->team_code) != 0)
                                                    <div class="absolute inline-flex items-center justify-center w-8 h-8 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 end-6 dark:border-gray-900">{{ countNoActivePlayers($team->team_code) }}</div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div
                                    class="font-normal text-gray-500">{{ __('messages.У вас нет ни одной команды') }}</div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if(session('success'))
        <div id="teamDel"
             class="absolute top-3 right-2 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-700"
             role="alert">
            <div
                class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                     viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                </svg>
            </div>
            <div class="ms-3 text-sm font-normal">{{ session('success') }}</div>
            <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                    data-dismiss-target="#teamDel" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    <div id="teamCreate"
         class="fixed top-3 right-2 flex opacity-0 -z-10 items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-700"
         role="alert">
        <div
            class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                 viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
            </svg>
            <span class="sr-only">Check icon</span>
        </div>
        <div class="ms-3 text-sm font-normal">{{ __('messages.Команда создана') }}</div>
        <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                data-dismiss-target="#teamCreate" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
</x-app-layout>



