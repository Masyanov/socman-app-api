<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.Мои команды') }}
            </h2>
            <!-- Modal toggle -->
            <button data-modal-target="add_team" data-modal-toggle="add_team"
                    class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                    type="button">
                {{ __('messages.Добавить команду') }}
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
                                {{ __('messages.Добавить новую команду') }}
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
                            <form class="space-y-4" method="POST" action="{{ route('teams.store') }}">

                                @csrf
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
                                <button type="button" id="button_save_team"
                                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    {{ __('messages.Добавить команду') }}</button>
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
                    <div class="grid gap-x-2 gap-y-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        @if(whatInArray($teamActive))
                            @foreach ($teamActive as $key => $team)
                                <div id="team-{{ $team->id }}"
                                     class="flex flex-col justify-between m-2 max-w-sm p-6 bg-white border rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                    <div>
                                        <a href="teams/{{ $team->id }}">
                                            <h5 class=" text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $team->name }} </h5>
                                            <span class=" text-xs" >Игроков: {{ countPlayers($team->team_code) }}</span>
                                            <div class="mb-2">
                                                @if ($team->active == 0)
                                                    <span
                                                        class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">{{ __('messages.Не активно') }}</span>
                                                @else
                                                    <span
                                                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{ __('messages.Активно') }}</span>
                                                @endif
                                            </div>

                                        </a>

                                        <p class="mb-1 text-xs text-gray-700 dark:text-gray-400">{{ __('messages.Код команды') }}
                                            :
                                            <strong>{{ $team->team_code }}</strong></p>
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
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div>{{ __('messages.У вас нет ни одной команды') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>

</script>


