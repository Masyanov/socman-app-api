<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.Тренировки') }}
            </h2>
            <!-- Modal toggle -->
            <button data-modal-target="add_team" data-modal-toggle="add_team"
                    class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                    type="button">
                {{ __('messages.Добавить тренировку') }}
            </button>

            <!-- Main modal -->
            <div id="add_team" tabindex="-1" aria-hidden="true"
                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ __('messages.Добавить новую тренировку') }}
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
                            <div class="space-y-4" method="POST" action="{{ route('trainings.store') }}">

                                @csrf
                                <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}"/>
                                <!-- Name -->
                                <div class="grid grid-cols-2 gap-3">
                                    @if(CountTeam() >= 2)
                                        <div class="col-span-1 sm:col-span-1">
                                            <label for="team_code"
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Команда') }}</label>
                                            <select id="team_code" name="team_code"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                @foreach($teamActive as $key => $team)
                                                    <option @if($key == 0) selected
                                                            @endif value="{{ $team->team_code }}">
                                                        <span class="pt-2">{{ $team->name }}</span>
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @else
                                        @foreach($teamActive as $key => $team)
                                            <input type="hidden" id="team_code" name="team_code"
                                                   value="{{ $team->team_code }}"/>
                                        @endforeach
                                    @endif
                                    <div class="col-span-1 sm:col-span-1">
                                        <label for="class"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Классификация') }}</label>
                                        <select id="class" name="class"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            @foreach($trainingClass as $key => $class)
                                                <option @if($key == 0) selected @endif value="{{ $class->id }}">
                                                    <span class="pt-2">{{ $class->name }}</span>
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-1">
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
                                        <input datepicker datepicker-autohide datepicker-format="yyyy-mm-dd" type="text"
                                               name="date" id="date"
                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               placeholder="Select date" required>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="col-1">
                                        <label for="start"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            {{ __('messages.Время начала') }}
                                        </label>
                                        <div class="flex">
                                            <input type="time" id="start" name="start"
                                                   class="rounded-none rounded-s-lg bg-gray-50 border text-gray-900 leading-none focus:ring-blue-500 focus:border-blue-500 block flex-1 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   required>
                                            <span
                                                    class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-s-0 border-s-0 border-gray-300 rounded-e-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd"
                                                          d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>


                                    <div class="col-1">
                                        <label for="finish"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            {{ __('messages.Время завершения') }}
                                        </label>
                                        <div class="flex">
                                            <input type="time" id="finish" name="finish"
                                                   class="rounded-none rounded-s-lg bg-gray-50 border text-gray-900 leading-none focus:ring-blue-500 focus:border-blue-500 block flex-1 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   required>
                                            <span
                                                    class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-s-0 border-s-0 border-gray-300 rounded-e-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd"
                                                          d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                                <div class="flex flex-col items-center rounded-md p-4 shadow-inner select-none"
                                     style="background: rgb(17 24 39);">
                                    <h3 class="text-xl mb-3 font-semibold text-gray-900 dark:text-white">LOAD
                                        CONTROL</h3>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="col-span-2 sm:col-span-1">
                                            <label for="recovery"
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Восстановление') }}</label>
                                            <input type="number" name="recovery"
                                                   id="recovery"
                                                   max="100"
                                                   min="1"
                                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            >
                                        </div>
                                        <div class="col-span-2 sm:col-span-1">
                                            <label for="load"
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Нагрузка') }}</label>
                                            <input type="number" name="load"
                                                   id="load"
                                                   max="100"
                                                   min="1"
                                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label for="desc"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Описание') }}</label>
                                    <textarea type="text" name="desc"
                                              id="desc"
                                              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    ></textarea>
                                    <x-input-error :messages="$errors->get('desc')" class="mt-2"/>
                                </div>
                                <div class="col-span-1 sm:col-span-1">
                                    <label for="link_docs"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Ссылка на документ') }}</label>
                                    <input type="text" name="link_docs"
                                           id="link_docs"
                                           class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    >
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="col-span-2 sm:col-span-1">
                                        <x-checkbox name="active"
                                                    id="active"
                                                    checked>
                                            {{ __('messages.Активный') }}
                                        </x-checkbox>
                                        <label
                                                class="ml-2 font-medium text-sm text-gray-700 dark:text-gray-300"
                                                for="active">{{ __('messages.Активный') }}</label>
                                    </div>
                                </div>
                                <button type="button" id="button_save_training"
                                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    {{ __('messages.Добавить тренировку') }}</button>
                                <div id="response"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <button id="btn_team_success" data-modal-target="add_team_success"
                        data-modal-toggle="add_team_success"
                        class="hidden" type="button"></button>
                <div id="add_team_success" tabindex="-1" aria-hidden="true"
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
                            {{ __('messages.Тренировка создана') }}
                        </div>
                        <button type="button"
                                class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                                data-dismiss-target="#alert-border-3" aria-label="Close">
                            <span class="sr-only">Dismiss</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-4 gap-3 p-6 text-gray-900 dark:text-gray-100">

                    @if(trainingToday() == false)
                            <div class="col-span-1 sm:col-span-1">
                                <div class="flex flex-col h-full relative bg-white dark:bg-gray-900 shadow-lg rounded-lg p-6 border-2 border-green-900">
                                    <span class="mb-3">{{ __('messages.На сегодня тренировок не запланировано') }}</span>
                                    <button type="button" data-modal-target="add_team" data-modal-toggle="add_team" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                                        {{ __('messages.Запланировать') }}
                                    </button>
                                </div>
                            </div>
                    @endif
                    @foreach($trainingActive as $training)
                        <a href="/trainings/{{ $training->id }}" class="col-span-1 sm:col-span-1">

                            <div class="h-full relative bg-white dark:bg-gray-900 shadow-lg rounded-lg p-6 @if($training->date == date('Y-m-d')) border-2 border-green-900 @endif">
                                @if($training->date == date('Y-m-d'))
                                <span class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300 absolute -translate-y-1/2 translate-x-1/1 left-auto top-0 -right-1">
                                    <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                    {{ __('messages.Сегодня') }}
                                </span>
                                @endif
                                <div class="flex justify-between gap-3">
                                    <div class=" text-gray-500 text-sm font-bold">
                                        {{ dateFormatDM($training->date) }}
                                    </div>
                                    <div class=" text-gray-500 text-sm font-bold">
                                        {{ timeTo($training->start,$training->finish) }} <span>мин.</span>
                                    </div>
                                    <div class=" text-gray-500 text-sm font-bold">
                                        {{ timeFormatHI($training->start) }}
                                    </div>
                                </div>
                                <div class="flex mb-3 items-center space-x-4">

                                    <div class="p-2 px-2.5 bg-indigo-200 text-indigo-600 rounded-full  font-bold">
                                        {{ dayOfDate($training->date) }}
                                    </div>
                                    <div>

                                        <div class="text-gray-600 text-sm">{{ nameClass($training->class) }}</div>
                                        <div class="text-gray-300 text-2xl font-semibold">
                                            {{ playerTeam($training->team_code) }}
                                            <div class="flex gap-3">
                                                @if($training->recovery)
                                                    <span class="text-green-500 text-sm font-medium flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                         fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M5 15l7-7 7 7"/>
                                                    </svg>
                                                    {{ $training->recovery }}
                                                </span>
                                                @endif
                                                @if($training->load)
                                                    <span class="text-red-500 text-sm font-medium flex items-center ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                         fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M5 15l7-7 7 7"/>
                                                    </svg>
                                                    {{ $training->load }}
                                                </span>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                    <!-- component -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
