<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap">
            <div class="flex">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $team->name }}</h2>
            @if ($team->active == 0)
                <span class="ml-3 bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300 pt-1">{{ __('messages.Не активно') }}</span>
            @else
                <span class="ml-3  bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 pt-1">{{ __('messages.Активно') }}</span>
            @endif
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 leading-tight pt-3 pb-3 sm:pl-0">{{ __('messages.Описание')}}
                : {{ $team->desc }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 leading-tight pb-6 sm:pb-3 sm:p-3">{{ __('messages.Код команды') }}
                : {{ $team->team_code }}</p>
            <!-- Modal toggle -->
            <div class="flex">
                <button data-modal-target="add_team" data-modal-toggle="add_team"
                        class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                        type="button">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 6.5L17.5 9M11 20H20M4 20V17.5L16.75 4.75C17.4404 4.05964 18.5596 4.05964 19.25 4.75V4.75C19.9404 5.44036 19.9404 6.55964 19.25 7.25L6.5 20H4Z" stroke="#d1d1d1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    <span class="sr-only">{{ __('messages.Редактировать команду') }}</span>
                </button>
                <button id="button_del_team" type="button" class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16" stroke="#d1d1d1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    <span class="sr-only">{{ __('messages.Удалить') }}</span>
                </button>
            </div>


            <!-- Main modal -->
            <div id="add_team" tabindex="-1" aria-hidden="true"
                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
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
                                <!-- Team Code -->
                                <div class="mt-4" id="code_field">
                                    <x-input-label for="team_code" :value="__('messages.Код команды')"/>
                                    <x-text-input id="team_code" class="block mt-1 w-full team_code" type="text"
                                                  name="team_code" :value="$team->team_code" required
                                                  autocomplete="team_code" placeholder="999-999"/>
                                    <x-input-error :messages="$errors->get('team_code')" class="mt-2"/>
                                </div>
                                <!-- Desc -->
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

                                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                                <td scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                                    <img class="w-10 h-10 rounded-full" src="/docs/images/people/profile-picture-1.jpg" alt="Jese image">
                                                    <div class="ps-3">
                                                        <div class="text-base font-semibold">{{ $user->last_name }} {{ $user->name }}</div>
                                                        <div class="font-normal text-gray-500">{{ $user->email }} </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $user->meta->position ?? 'None'  }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $user->meta->number ?? 'None'  }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ $user->meta->tel ?? 'None'  }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <a href="#" type="button" data-modal-target="editUserModal" data-modal-show="editUserModal" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 6.5L17.5 9M11 20H20M4 20V17.5L16.75 4.75C17.4404 4.05964 18.5596 4.05964 19.25 4.75V4.75C19.9404 5.44036 19.9404 6.55964 19.25 7.25L6.5 20H4Z" stroke="#d1d1d1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                                    </a>

                                                    <button id="button_del_team" type="button" class="ml-2 text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16" stroke="#d1d1d1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                                        <span class="sr-only">{{ __('messages.Удалить') }}</span>
                                                    </button>
                                                </td>

                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                    <!-- Edit user modal -->
                                    <div id="editUserModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative w-full max-w-2xl max-h-full">
                                            <!-- Modal content -->
                                            <form class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                <!-- Modal header -->
                                                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                        Edit user
                                                    </h3>
                                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editUserModal">
                                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="p-6 space-y-6">
                                                    <div class="grid grid-cols-6 gap-6">
                                                        <div class="col-span-6 sm:col-span-3">
                                                            <label for="first-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                                                            <input type="text" name="first-name" id="first-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Bonnie" required="">
                                                        </div>
                                                        <div class="col-span-6 sm:col-span-3">
                                                            <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                                                            <input type="text" name="last-name" id="last-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Green" required="">
                                                        </div>
                                                        <div class="col-span-6 sm:col-span-3">
                                                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                                            <input type="email" name="email" id="email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="example@company.com" required="">
                                                        </div>
                                                        <div class="col-span-6 sm:col-span-3">
                                                            <label for="phone-number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone Number</label>
                                                            <input type="number" name="phone-number" id="phone-number" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="e.g. +(12)3456 789" required="">
                                                        </div>
                                                        <div class="col-span-6 sm:col-span-3">
                                                            <label for="department" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department</label>
                                                            <input type="text" name="department" id="department" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Development" required="">
                                                        </div>
                                                        <div class="col-span-6 sm:col-span-3">
                                                            <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company</label>
                                                            <input type="number" name="company" id="company" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="123456" required="">
                                                        </div>
                                                        <div class="col-span-6 sm:col-span-3">
                                                            <label for="current-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current Password</label>
                                                            <input type="password" name="current-password" id="current-password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="••••••••" required="">
                                                        </div>
                                                        <div class="col-span-6 sm:col-span-3">
                                                            <label for="new-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New Password</label>
                                                            <input type="password" name="new-password" id="new-password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="••••••••" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div class="flex items-center p-6 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">
                                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save all</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

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


