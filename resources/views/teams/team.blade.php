<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">
            <div class="flex flex-col sm:flex-row items-center justify-between w-full">
                <div class="flex mb-2">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $team->name }}</h2>
                    @if ($team->active == 0)
                        <span
                            class="ml-3 bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300 pt-1">{{ __('messages.Не активно') }}</span>
                    @else
                        <span
                            class="ml-3 bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 pt-1">{{ __('messages.Активно') }}</span>
                    @endif
                </div>
                <div class="flex gap-3 mb-2">
                    @if($team->desc)
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-tight pt-3 pb-3 sm:pl-0">{{ __('messages.Описание')}}
                            : {{ $team->desc }}</p>
                    @endif

                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-tight sm:pb-3 sm:p-3">{{ __('messages.Код команды') }}
                        : {{ $team->team_code }}</p>
                    <span class="text-sm text-gray-500 dark:text-gray-400 leading-tight sm:pb-3 sm:p-3">{{ __('messages.Игроков') }}: {{ countPlayers($team->team_code) }}</span>
                </div>
                <!-- Modal toggle -->
                <div class="flex">
                    <button data-modal-target="add_team" data-modal-toggle="add_team"
                            class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                            type="button">
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
                    <button id="button_del_team" type="button"
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
                                    <x-input-label for="name" :value="__('messages.Название')"/>
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                                  :value="$team->name" required autofocus autocomplete="name"/>
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

    <button id="btn_team_success" data-modal-target="add_team_success" data-modal-toggle="add_team_success" class="hidden" type="button"></button>
    <div id="add_team_success" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div id="alert-border-3" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div class="ms-3 text-sm font-medium">
                {{ __('messages.Сохранено') }}
            </div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"  data-dismiss-target="#alert-border-3" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
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
                                            data-tabs-target="#profile" type="button" role="tab" aria-controls="profile"
                                            aria-selected="false">
                                        {{ __('messages.Игроки') }}
                                    </button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                        id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                                        aria-controls="dashboard" aria-selected="false">
                                        {{ __('messages.Планирование') }}
                                    </button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                        id="settings-tab" data-tabs-target="#settings" type="button" role="tab"
                                        aria-controls="settings" aria-selected="false">
                                        {{ __('messages.Результаты') }}
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div id="default-tab-content">
                            <div class="hidden rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel"
                                 aria-labelledby="profile-tab">

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
                                                {{ __('messages.Позиция') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                {{ __('messages.Номер') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                {{ __('messages.Телефон') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($usersOfTeam as $user)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                <td scope="row"
                                                    class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                                    @if($user->meta->avatar)
                                                        <a data-fancybox data-src="/avatars/{{ $user->meta->avatar }}">
                                                            <img class="w-10 h-10 rounded-full object-cover"
                                                                 src="/avatars/{{ $user->meta->avatar }}"
                                                                 alt="{{ $user->last_name }} {{ $user->name }}">
                                                        </a>
                                                    @else
                                                        <img class="w-10 h-10 rounded-full object-cover" src="/images/default-avatar.jpg"
                                                             alt="{{ $user->last_name }} {{ $user->name }}">
                                                    @endif
                                                    <div class="ps-3">
                                                        <a href="/users/{{ $user->id }}" type="button"
                                                           class="font-medium text-white dark:text-white">
                                                            <div
                                                                class="text-base font-semibold">{{ $user->last_name }} {{ $user->name }}</div>
                                                        </a>
                                                        <div class="font-normal text-gray-500">{{ $user->email }}
                                                            @if ($user->active == 0)
                                                                <span
                                                                    class="ml-3 bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300 pt-1">{{ __('messages.Не активно') }}</span>
                                                            @else
                                                                <span
                                                                    class="ml-3  bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 pt-1">{{ __('messages.Активно') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $user->meta->position ?? 'None'  }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $user->meta->number ?? 'None'  }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex gap-3 items-center justify-center h-full min-w-max">
                                                        {{ $user->meta->tel ?? 'None'  }}
                                                        @if($user->meta->tel != 'None' && $user->meta->tel != NULL)
                                                            <a href="tel:{{ $user->meta->tel }}"
                                                               class="p-1 rounded-md bg-green-500 hover:bg-green-700 flex h-full">
                                                                <svg class="w-3 h-3 " viewBox="0 0 24 24" fill="none"
                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
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
                                                <td class="px-6 py-4">
                                                    <div class="flex gap-3 items-center justify-center h-full">
                                                        <a href="/users/{{ $user->id }}" type="button"
                                                           class="p-2 rounded-md bg-blue-500 hover:bg-blue-700 flex h-full">
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
                                                           onclick="deleteUser({{ $user->id }})"
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
                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard"
                                 role="tabpanel" aria-labelledby="dashboard-tab">
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $team->team_code }} This is some
                                    placeholder content the
                                    <strong class="font-medium text-gray-800 dark:text-white">Dashboard tab's associated
                                        content</strong>. Clicking another tab will toggle the visibility of this one
                                    for the next. The tab JavaScript swaps classes to control the content visibility and
                                    styling.</p>
                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel"
                                 aria-labelledby="settings-tab">
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $team->team_code }} This is some
                                    placeholder content the
                                    <strong class="font-medium text-gray-800 dark:text-white">Settings tab's associated
                                        content</strong>. Clicking another tab will toggle the visibility of this one
                                    for the next. The tab JavaScript swaps classes to control the content visibility and
                                    styling.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>

</script>


