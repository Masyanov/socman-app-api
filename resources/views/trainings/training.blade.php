<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            <div class="flex flex-col sm:flex-row items-center justify-between w-full">
                <div class="flex mb-2 relative">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('messages.Тренировка') }}
                        : {{ dateFormatDM($training->date) }}</h2>
                    @if ($training->active == 0)
                        <div
                            class="absolute rounded-full py-1 px-1 text-xs font-medium content-[''] leading-none grid place-items-center top-[6%] right-[1%] translate-x-12 -translate-y-1/4 bg-red-500 text-white min-w-[24px] min-h-[24px] bg-gradient-to-tr from-gray-400 to-gray-600 border-2 border-white shadow-lg shadow-black/20">
                            <svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor"
                                aria-hidden="true" class="w-4 h-4 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M4.5 12.75l6 6 9-13.5">
                                </path>
                            </svg>
                        </div>
                    @else
                        <div
                            class="absolute rounded-full py-1 px-1 text-xs font-medium content-[''] leading-none grid place-items-center top-[6%] right-[1%] translate-x-12 -translate-y-1/4 bg-red-500 text-white min-w-[24px] min-h-[24px] bg-gradient-to-tr from-green-400 to-green-600 border-2 border-white shadow-lg shadow-black/20">
                            <svg
                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor"
                                aria-hidden="true" class="w-4 h-4 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M4.5 12.75l6 6 9-13.5">
                                </path>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="flex gap-3 mb-2">
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-tight sm:pb-3 sm:p-3">{{ __('messages.Команда') }}
                        : {{ playerTeam($training->team_code) }}
                    </p>
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400 leading-tight sm:pb-3 sm:p-3">
                    @if(presenceCheck($training->id) != 0)
                        <div class="flex gap-2 text-gray-500">
                            <div>{{ __('messages.Явка') }}:</div>
                            <div class="font-bold">{{ presence($training->id) }}</div>
                        </div>
                    @endif
                </div>

                <!-- Modal toggle -->
                <input type="hidden" id="id" name="id" value="{{ $training->id }}"/>
                <div class="flex">
                    <button id="button_del_training" type="button"
                            class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16"
                                    stroke="#d1d1d1" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </g>
                        </svg>
                        <span class="sr-only">{{ __('messages.Удалить') }}</span>
                    </button>
                </div>
            </div>

        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex gap-3 p-6 text-gray-900 dark:text-gray-100">
                    <form method="PATCH">
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                            @csrf
                            <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}"/>
                            <input type="hidden" id="training_id" name="training_id" value="{{ $training->id }}"/>
                            <input type="hidden" id="count_players_udate" name="count_players"
                                   value="{{ countPlayers($training->team_code) }}"/>
                            <!-- Name -->
                            <div class="col-span-1">
                                <div class="grid grid-cols-1 gap-3">
                                    <div class="grid grid-cols-2 gap-3">
                                        @if(CountTeam() >= 2)
                                            <div class="col-span-1 sm:col-span-1">
                                                <label for="team_code_training"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Команда') }}</label>
                                                <select id="team_code_training" name="team_code"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                    <option selected value="{{ $training->team_code }}"
                                                            data-count-players="{{ countPlayers($training->team_code) }}">
                                                        <span class="pt-2">{{ playerTeam($training->team_code) }}</span>
                                                    </option>
                                                    @foreach($teamActive as $key => $team)
                                                        @if($team->team_code != $training->team_code)
                                                            <option value="{{ $team->team_code }}"
                                                                    data-count-players="{{ countPlayers($team->team_code) }}">
                                                                <span class="pt-2">{{ $team->name }}</span>
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        @else
                                            @foreach($teamActive as $key => $team)
                                                <input type="hidden" id="team_code_training" name="team_code"
                                                       value="{{ $training->team_code }}"/>
                                            @endforeach
                                        @endif

                                        <div
                                            class="  @if(CountTeam() >= 2) col-span-1 sm:col-span-1 @else col-span-2 sm:col-span-2 @endif">
                                            <label for="class"
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Классификация') }}</label>
                                            <select id="class" name="class"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option selected value="{{ $training->class }}">
                                                    <span class="pt-2">{{ nameClass($training->class) }}</span>
                                                </option>
                                                @foreach($trainingClass as $key => $class)
                                                    @if($class->id != $training->class)
                                                        <option value="{{ $class->id }}">
                                                            <span class="pt-2">{{ $class->name }}</span>
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-span-1 sm:col-span-1">
                                        <label for="date"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            {{ __('messages.Дата') }}
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                     xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                     viewBox="0 0 20 20">
                                                    <path
                                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                </svg>
                                            </div>
                                            <input type="date"
                                                   name="date" id="date"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   placeholder="Select date" required value="{{ $training->date }}">
                                        </div>
                                    </div>
                                    <div class="col-span-1 sm:col-span-1">
                                        <div class="grid grid-cols-2 gap-3">
                                            <div class="col-1">
                                                <label for="start"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ __('messages.Время начала') }}
                                                </label>
                                                <div class="flex">
                                                    <input type="text" id="start" name="start"
                                                           class="time rounded-none rounded-s-lg bg-gray-50 border text-gray-900 leading-none focus:ring-blue-500 focus:border-blue-500 block flex-1 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                           required value="{{ $training->start }}">
                                                    <div
                                                        class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-s-0 border-s-0 border-gray-300 rounded-e-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                                             aria-hidden="true"
                                                             xmlns="http://www.w3.org/2000/svg"
                                                             fill="currentColor" viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd"
                                                                  d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                                                  clip-rule="evenodd"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <label for="finish"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ __('messages.Время завершения') }}
                                                </label>
                                                <div class="flex">
                                                    <input type="text" id="finish" name="finish"
                                                           class="time rounded-none rounded-s-lg bg-gray-50 border text-gray-900 leading-none focus:ring-blue-500 focus:border-blue-500 block flex-1 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                           required value="{{ $training->finish }}">
                                                    <div
                                                        class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-s-0 border-s-0 border-gray-300 rounded-e-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                                             aria-hidden="true"
                                                             xmlns="http://www.w3.org/2000/svg"
                                                             fill="currentColor" viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd"
                                                                  d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                                                  clip-rule="evenodd"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-2">
                                                <label for="desc"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Описание') }}</label>
                                                <textarea type="text" name="desc"
                                                          id="desc"
                                                          class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                >{{ $training->desc }}</textarea>
                                                <x-input-error :messages="$errors->get('desc')" class="mt-2"/>
                                            </div>
                                            <div class="col-span-2">
                                                <label for="link_docs"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Ссылка на документ') }}</label>
                                                <input type="text" name="link_docs"
                                                       id="link_docs"
                                                       value="{{ $training->link_docs }}"
                                                       class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                >
                                            </div>
                                            <div>
                                                <label for="addresses"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Классификация') }}</label>
                                                <select id="addresses" name="addresses"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                    <option selected value="{{ $training->addresses }}">
                                                        <span
                                                            class="pt-2">{{ nameAddress($training->addresses) }}</span>
                                                    </option>
                                                    @foreach($trainingAddresses as $key => $addres)
                                                        @if($addres->id != $training->addresses)
                                                            <option value="{{ $addres->id }}">
                                                                <span class="pt-2">{{ $addres->name }}</span>
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    @if(checkLoadControl())
                                        <div class="col-span-1 sm:col-span-1">
                                            <div id="load_control"
                                                 class="flex flex-col items-center rounded-md p-4 shadow-inner select-none"
                                                 style="background: rgb(17 24 39);">
                                                <h3 class="text-xl mb-3 font-semibold text-gray-900 dark:text-white">
                                                    LOAD
                                                    CONTROL</h3>
                                                <div class="grid grid-cols-2 gap-3 sm:grid-cols-2">
                                                    <div class="col-span-1">
                                                        <label for="recovery"
                                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Восстановление') }}</label>
                                                        <input type="number" name="recovery"
                                                               id="recovery"
                                                               max="100"
                                                               min="0"
                                                               value="{{ $training->recovery }}"
                                                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        >
                                                    </div>
                                                    <div class="col-span-1">
                                                        <label for="load"
                                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Нагрузка') }}</label>
                                                        <input type="number" name="load"
                                                               id="load"
                                                               max="100"
                                                               min="0"
                                                               value="{{ $training->load }}"
                                                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>


                            </div>
                            <div class="col-1 col-span-1 sm:col-span-2 px-5">
                                <div class="flex justify-between gap-3">
                                    <h2 class="pl-3 mb-3 font-semibold text-xl text-gray-700 dark:text-gray-300 leading-tight">{{ __('messages.Отметить присутствующих') }}</h2>
                                    <div
                                        class="w-fit flex items-center px-2 border border-gray-200 rounded dark:border-gray-700">
                                        <input id="check_all" type="checkbox" value="" name="check_all"
                                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="bordered-checkbox-2"
                                               class="w-full py-1 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('messages.Выбрать всех') }}</label>
                                    </div>
                                </div>
                                <div class="flex flex-column flex-wrap py-3">
                                    @foreach (PlayerOfTeam($training->team_code) as $player)
                                        <div class="flex items-center w-6/6 sm:w-3/6 ">
                                            <label class="relative flex items-center p-1 rounded-full cursor-pointer"
                                                   for="ripple-on-{{ $player->id }}"
                                                   data-ripple-dark="true">
                                                <input id="ripple-on-{{ $player->id }}" type="checkbox" name="players[]"
                                                       value="{{ $player->id }}"
                                                       @foreach(presenceOfTraining($training->id) as $trainingPlayer)
                                                           @if($trainingPlayer->training_id == $training->id && $player->id == $trainingPlayer->user_id)
                                                               checked
                                                       @endif
                                                       @endforeach
                                                       class="chk ids before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-md border border-blue-gray-200 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-gray-900 checked:bg-gray-900 checked:before:bg-gray-900 hover:before:opacity-10"
                                                >
                                                <span
                                                    class="absolute text-white transition-opacity opacity-0 pointer-events-none top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 peer-checked:opacity-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                     viewBox="0 0 20 20" fill="currentColor"
                                                     stroke="currentColor" stroke-width="1">
                                                  <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                            </label>
                                            <label class="mt-px font-light text-gray-700 cursor-pointer select-none"
                                                   for="ripple-on-{{ $player->id }}">
                                                <dev scope="row"
                                                     class="flex items-center px-4 py-1 text-gray-900 whitespace-nowrap dark:text-white">

                                                    <div class="ps-3">
                                                        <a href="/users/{{ $player->id }}" type="button"
                                                           class="font-medium text-white dark:text-white">
                                                            <div
                                                                class="flex gap-3 text-base font-semibold @if ($player->active == 0) dark:text-gray-400 @endif">
                                                                @if($player->meta && $player->meta->number)
                                                                    <div
                                                                        class="text-gray-500">{{ $player->meta->number }}</div>
                                                                @endif
                                                                <div>{{ $player->last_name }} {{ $player->name }}</div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </dev>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-3 w-6/6 sm:w-2/6 py-3">
                            <div class="flex">
                                <x-checkbox name="active"
                                            id="active"
                                            :checked="$training->active">
                                    {{ __('messages.Активный') }}
                                </x-checkbox>
                                <label
                                    class="ml-2 font-medium text-sm text-gray-700 dark:text-gray-300"
                                    for="active">{{ __('messages.Активный') }}</label>
                            </div>
                            <div class="flex">
                                <x-checkbox name="confirmed"
                                            id="confirmed"
                                            :checked="$training->confirmed">
                                    {{ __('messages.Проведена') }}
                                </x-checkbox>
                                <label
                                    class="ml-2 font-medium text-sm text-gray-700 dark:text-gray-300"
                                    for="confirmed">
                                    {{ __('messages.Проведена') }}
                                </label>
                            </div>
                            <div class="flex">
                                <div id="alert-2"
                                     class="flex items-center p-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-700 dark:text-red-400 transition-opacity duration-300 ease-out opacity-0 hidden"
                                     role="alert">
                                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <span class="sr-only">Info</span>
                                    <div class="ms-3 text-sm font-medium">
                                        {{ __('messages.Чтобы подтвердить проведение тренировки отметьте 3 или более игроков!') }}
                                    </div>
                                    <button type="button"
                                            class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                                            data-dismiss-target="#alert-2" aria-label="Close">
                                        <span class="sr-only">Close</span>
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                             fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 col-span-1 sm:col-span-1">
                            <button type="button" id="update_training"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                {{ __('messages.Сохранить') }}
                            </button>
                        </div>
                        <div id="response"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="trainingCreate"
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
        <div class="ms-3 text-sm font-normal">{{ __('messages.Тренировка сохранена') }}</div>
        <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                data-dismiss-target="#trainingCreate" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
</x-app-layout>


