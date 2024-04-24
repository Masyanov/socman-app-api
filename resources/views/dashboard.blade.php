<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.Дашборд') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex gap-3 p-6 text-gray-900 dark:text-gray-100">
                    @if(Auth::user()->role == 'coach' || Auth::user()->role == 'admin')
                        <div class="flex flex-col items-center rounded-md w-40 p-4 shadow-inner select-none" style="background: rgb(17 24 39);">
                            <div class="font-medium text-base text-gray-800 dark:text-gray-400">{{ __('messages.У вас') }} </div>
                            <div class="font-medium text-5xl text-gray-800 dark:text-gray-200">{{ CountTeam() }}</div>
                            <div class="font-medium text-base text-gray-800 dark:text-gray-400">{{ pluralTeam(CountTeam()) }}</div>
                        </div>
                        <div class="flex flex-col items-center rounded-md w-40 p-4 shadow-inner select-none" style="background: rgb(17 24 39);">
                            <div class="font-medium text-base text-gray-800 dark:text-gray-400">{{ __('messages.У вас') }} </div>
                            <div class="font-medium text-5xl text-gray-800 dark:text-gray-200">{{ CountPlayerOfCoach() }}</div>
                            <div class="font-medium text-base text-gray-800 dark:text-gray-400">{{ pluralPlayers(CountPlayerOfCoach()) }}</div>
                        </div>
                        <div class="flex flex-col items-center rounded-md w-40 p-4 shadow-inner select-none" style="background: rgb(17 24 39);">
                            <div class="font-medium text-base text-gray-800 dark:text-gray-400">{{ __('messages.Проведено') }} </div>
                            <div class="font-medium text-5xl text-gray-800 dark:text-gray-200">{{ allTrainingCount() }}</div>
                            <div class="font-medium text-base text-gray-800 dark:text-gray-400">{{ pluralTrainings(allTrainingCount()) }}</div>
                        </div>

                    @else
                        <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                            {{ __('messages.Ваша команда') }}: {{ yourTeam() }}
                        </div>
                        <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                            @if (Auth::user()->active == 0)
                                Ваш аккаунт не активен. Обратитесь к вашему тренеру, чтобы он вас активировал.
                            @else
                                Ваш аккаунт активен.
                            @endif
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
