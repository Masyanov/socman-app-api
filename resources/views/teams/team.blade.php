<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $team->name }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 leading-tight pt-3 pb-3 sm:pl-0">{{ __('messages.Описание')}}
                : {{ $team->desc }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 leading-tight pb-6 sm:pb-3 sm:p-3">{{ __('messages.Код команды') }}
                : {{ $team->team_code }}</p>
            <!-- Modal toggle -->
            <button data-modal-target="add_team" data-modal-toggle="add_team"
                    class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                    type="button">
                {{ __('messages.Редактировать команду') }}
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
                            <form class="space-y-4" method="PUT">

                                @csrf
                                <input type="hidden" id="id" name="id" value="{{ $team->id }}"/>
                                <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}"/>
                                <!-- Name -->
                                <div>
                                    <x-input-label for="name" :value="__('messages.Название')"/>
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                                  :value="old('name')" required autofocus autocomplete="name"/>
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
                                <div class="flex">
                                    <x-checkbox name="active" id="active" checked>
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
                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel"
                                 aria-labelledby="profile-tab">
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $team->team_code }} This is some placeholder content the
                                    <strong class="font-medium text-gray-800 dark:text-white">Profile tab's associated
                                        content</strong>. Clicking another tab will toggle the visibility of this one
                                    for the next. The tab JavaScript swaps classes to control the content visibility and
                                    styling.</p>
                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard"
                                 role="tabpanel" aria-labelledby="dashboard-tab">
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $team->team_code }} This is some placeholder content the
                                    <strong class="font-medium text-gray-800 dark:text-white">Dashboard tab's associated
                                        content</strong>. Clicking another tab will toggle the visibility of this one
                                    for the next. The tab JavaScript swaps classes to control the content visibility and
                                    styling.</p>
                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel"
                                 aria-labelledby="settings-tab">
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $team->team_code }} This is some placeholder content the
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


