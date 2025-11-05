<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap">
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $player->name }} {{ $player->last_name }}</h2>
                @if ($player->active == 0)
                    <span
                        class="ml-3 bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300 pt-1">{{ __('messages.Не активно') }}</span>
                @else
                    <span
                        class="ml-3  bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 pt-1">{{ __('messages.Активно') }}</span>
                @endif
            </div>
            <div class="flex">
                <a id="button_del_user" href="javascript:void(0)"
                   class="flex h-full"
                   onclick="deleteUser({{ $player->id }})"
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
                <script>
                    function deleteUser($id) {

                        let _url = '/users/' + $id;
                        console.log(_url)
                        let _token = $('input[name~="_token"]').val();

                        if (confirm('Удалить игрока?')) {
                            $.ajax({
                                url: _url,
                                type: 'DELETE',
                                data: {
                                    _token: _token
                                },
                                success: function (response) {
                                    window.location.href = '/users';
                                }
                            });
                        }

                    };
                </script>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 mb-3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <button id="toggle-form-button"
                        class=" block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                        type="button" title="{{ __('messages.Редактировать игрока') }}">
                    {{ __('messages.Редактировать игрока') }} &#9660;
                </button>
                <div id="add-player-form-container" class="mt-3 hidden text-gray-900 dark:text-gray-100">
                    @if(Session::has('success'))
                        <div id="alert-border-3" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-700 dark:border-green-800" role="alert">
                            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <div class="ms-3 text-sm font-medium">
                                {{ Session::get('success') }}
                            </div>
                            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"  data-dismiss-target="#alert-border-3" aria-label="Close">
                                <span class="sr-only">Dismiss</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            </button>
                        </div>
                    @endif
                    <div>
                        <form method="post" action="{{ route('users.update', ['id' => $player->id]) }}" enctype="multipart/form-data"
                              class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            @csrf
                            @method('patch')
                            <div
                                class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    {{ __('messages.Редактировать игрока') }}
                                </h3>
                            </div>
                            <!-- Modal body -->
                            <div class="p-6 space-y-6">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div class="grid grid-cols-3 gap-6">
                                        <input type="hidden" id="player_id"
                                               name="player_id"
                                               value="{{ $player->id }}"/>
                                        <input type="hidden" id="team_code"
                                               name="team_code"
                                               value="{{ $player->team_code }}"/>
                                        <div class="flex flex-col col-span-3 sm:col-span-1">
                                            <label for="avatar" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Фото') }}</label>

                                            @php
                                                $avatarPath = $player->meta->avatar ? "/avatars/{$player->meta->avatar}" : "/images/default-avatar.jpg";
                                            @endphp

                                            <img id="avatarPreview"
                                                 class="w-full h-60 rounded-lg object-cover mb-3 border dark:border-gray-500"
                                                 src="{{ $avatarPath }}"
                                                 alt="{{ $player->last_name }} {{ $player->name }}">

                                            <input class="block w-full text-lg text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                                   name="avatar"
                                                   id="avatar"
                                                   type="file"
                                                   accept="image/*">

                                            <x-input-error :messages="$errors->get('avatar')" class="mt-2"/>
                                        </div>
                                        <script>
                                            document.getElementById('avatar').addEventListener('change', function(event) {
                                                const [file] = this.files;
                                                if (file) {
                                                    const reader = new FileReader();
                                                    reader.onload = function(e) {
                                                        const preview = document.getElementById('avatarPreview');
                                                        preview.src = e.target.result;
                                                        preview.classList.remove('object-contain');
                                                        preview.classList.add('object-cover'); // меняем стиль, если нужно
                                                    };
                                                    reader.readAsDataURL(file);
                                                }
                                            });
                                        </script>
                                        <div class=" flex flex-col gap-4 col-span-3 sm:col-span-2">
                                            <div class="col-span-1 sm:col-span-1">
                                                <label for="last_name"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Фамилия') }}</label>
                                                <input type="text"
                                                       name="last_name"
                                                       id="last_name"
                                                       class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                       required value="{{ $player->last_name }}">
                                            </div>
                                            <div class="col-span-1 sm:col-span-1">
                                                <label for="name"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Имя') }}</label>
                                                <input type="text" name="name"
                                                       id="name"
                                                       class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                       required value="{{ $player->name }}">
                                            </div>

                                            <div class="col-span-1 sm:col-span-1">
                                                <label for="second_name"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Отчество') }}</label>
                                                <input type="text" name="second_name"
                                                       id="second_name"
                                                       class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                       value="{{ $player->second_name }}">
                                            </div>
                                            <div class="col-span-1 sm:col-span-1">
                                                <label for="birthday"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Дата рождения</label>
                                                <input type="date" name="birthday"
                                                       id="birthday"
                                                       class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                       required value="{{ $player->meta->birthday }}">
                                                <x-input-error :messages="$errors->get('birthday')" class="mt-2"/>
                                            </div>


                                            @if(CountTeam() >= 2)
                                                <div class="col-span-1 sm:col-span-1">
                                                    <label for="team" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Команда') }}</label>
                                                    <select id="team" name="team_code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                        <option selected value="{{ $player->team_code }}">
                                                            <div class="px-2">{{ playerTeam($player->team_code) }}</div>
                                                        </option>
                                                        @foreach($teamActive as $team)
                                                            @if($team->team_code != $player->team_code)
                                                                <option value="{{ $team->team_code }}">
                                                                    <span class="pt-2">{{ $team->name }}</span>
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif

                                        </div>

                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="col-span-2 sm:col-span-1">
                                            <label for="position"
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Позиция') }}</label>
                                            <input type="text" name="position"
                                                   id="position"
                                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   value="{{ $player->meta->position ?? 'None'  }}">
                                        </div>
                                        <div class="col-span-2 sm:col-span-1">
                                            <label for="number"
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Номер') }}</label>
                                            <input type="number" name="number"
                                                   id="number"
                                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   value="{{ $player->meta->number ?? 'None'  }}">
                                        </div>
                                        <div class="col-span-2 sm:col-span-1">
                                            <label for="tel"
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Телефон') }}</label>
                                            <input type="tel" name="tel"
                                                   id="tel"
                                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   value="{{ $player->meta->tel ?? 'None'  }}">
                                        </div>
                                        <div class="col-span-2 sm:col-span-1">
                                            <label for="email"
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                            <input type="email" name="email"
                                                   id="email"
                                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   required value="{{ $player->email }}">
                                            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                                        </div>

                                        <div class="col-span-2 sm:col-span-1">
                                            <label for="tel_mother"
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Телефон матери') }}</label>
                                            <input type="tel" name="tel_mother"
                                                   id="tel_mother"
                                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   value="{{ $player->meta->tel_mother ?? 'None'  }}">
                                        </div>
                                        <div class="col-span-2 sm:col-span-1">
                                            <label for="tel_father"
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Телефон отца') }}</label>
                                            <input type="tel" name="tel_father"
                                                   id="tel_father"
                                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   value="{{ $player->meta->tel_father ?? 'None'  }}">
                                        </div>

                                        <div class="col-span-2 sm:col-span-2">
                                            <label for="comment"
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Комментарий') }}</label>
                                            <textarea type="text" name="comment"
                                                      id="comment"
                                                      class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                      value="{{ $player->meta->comment ?? 'None'  }}">{{ $player->meta->comment ?? 'None'  }}</textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Modal footer -->
                            <div
                                class="mt-3 p-3 flex items-center space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">
                                <button type="submit"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    {{ __('messages.Сохранить') }}
                                </button>
                                <div class="flex">
                                    <x-checkbox name="active"
                                                id="active"
                                                :checked="$player->active">
                                        {{ __('messages.Активный') }}
                                    </x-checkbox>
                                    <label
                                        class="ml-2 font-medium text-sm text-gray-700 dark:text-gray-300"
                                        for="active">{{ __('messages.Активный') }}</label>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            @if(checkTestsForPlayer($player->id))
                <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    @include('admin.tests.user')
                </div>
            @else
                <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <p class="text-gray-900 dark:text-gray-100">У этого пользователя пока нет данных по тестам.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>




