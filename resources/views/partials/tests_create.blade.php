<div class="container">
    <h2 class="mb-3">Добавить результаты тестирования</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tests.store') }}" method="POST" enctype="multipart/form-data" class="flex gap-2 flex-wrap">
        @csrf
        <div class="grid grid-cols-6 gap-2">
            <div class="flex w-full h-full">
                <select id="teamCodeSelect" name="team_code" style="width: inherit"
                        class="flex h-fit align-items-end md:w-fit bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @foreach ($teams as $team)
                        @if($team->active)
                            <option class="text-gray-200"
                                    value="{{ $team->team_code }}">
                                {{ $team->name }}
                            </option>
                        @else
                            <option class="text-red-300"
                                    value="{{ $team->team_code }}"
                                    disabled>
                                {{ $team->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="flex w-full h-full align-content-end">
                <select id="playerSelect" name="player_id" style="width: inherit"
                        class="flex w-full h-fit align-items-end md:w-fit bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option disabled selected>Выберите команду</option>
                </select>
            </div>
            <div class="w-full">
                <div class="relative max-w-sm flex w-full align-items-end">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input id="datepicker-autohide" name="date_of_test" datepicker datepicker-autohide type="text"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           placeholder="Select date"
                           style="width: inherit">
                </div>
            </div>
        </div>
        <div class="grid grid-cols-9 gap-2">
            <div>
                <x-input-label for="height" :value="__('messages.Рост')"/>
                <x-text-input id="height" class="flex mt-1 w-full" type="number" name="height"/>
                <x-input-error :messages="$errors->get('height')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="weight" :value="__('messages.Вес')"/>
                <x-text-input id="weight" class="flex mt-1 w-full" type="number" name="weight"/>
                <x-input-error :messages="$errors->get('weight')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="body_mass_index" :value="__('messages.Индекс массы')"/>
                <x-text-input id="body_mass_index" class="flex mt-1 w-full" type="number" name="body_mass_index"/>
                <x-input-error :messages="$errors->get('body_mass_index')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="push_ups" :value="__('messages.Отжимания')"/>
                <x-text-input id="push_ups" class="flex mt-1 w-full" type="number" name="push_ups"/>
                <x-input-error :messages="$errors->get('push_ups')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="pull_ups" :value="__('messages.Подтягивания')"/>
                <x-text-input id="pull_ups" class="flex mt-1 w-full" type="number" name="pull_ups"/>
                <x-input-error :messages="$errors->get('pull_ups')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="ten_m" :value="__('messages.10 метров')"/>
                <x-text-input id="ten_m" class="flex mt-1 w-full" type="number" name="ten_m"/>
                <x-input-error :messages="$errors->get('ten_m')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="twenty_m" :value="__('messages.20 метров')"/>
                <x-text-input id="twenty_m" class="flex mt-1 w-full" type="number" name="twenty_m"/>
                <x-input-error :messages="$errors->get('twenty_m')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="thirty_m" :value="__('messages.30 метров')"/>
                <x-text-input id="thirty_m" class="flex mt-1 w-full" type="number" name="thirty_m"/>
                <x-input-error :messages="$errors->get('thirty_m')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="long_jump" :value="__('messages.Прыжок в длинну')"/>
                <x-text-input id="long_jump" class="flex mt-1 w-full" type="number" name="long_jump"/>
                <x-input-error :messages="$errors->get('long_jump')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="vertical_jump_no_hands" :value="__('messages.Вверх без рук')"/>
                <x-text-input id="vertical_jump_no_hands" class="flex mt-1 w-full" type="number"
                              name="vertical_jump_no_hands"/>
                <x-input-error :messages="$errors->get('vertical_jump_no_hands')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="vertical_jump_with_hands" :value="__('messages.Вверх с руками')"/>
                <x-text-input id="vertical_jump_with_hands" class="flex mt-1 w-full" type="number"
                              name="vertical_jump_with_hands"/>
                <x-input-error :messages="$errors->get('vertical_jump_with_hands')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="illinois_test" :value="__('messages.Иллинойс')"/>
                <x-text-input id="illinois_test" class="flex mt-1 w-full" type="number" name="illinois_test"/>
                <x-input-error :messages="$errors->get('illinois_test')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="pause_one" :value="__('messages.6 по 30м 1')"/>
                <x-text-input id="pause_one" class="flex mt-1 w-full" type="number" name="pause_one"/>
                <x-input-error :messages="$errors->get('pause_one')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="pause_two" :value="__('messages.6 по 30м 2')"/>
                <x-text-input id="pause_two" class="flex mt-1 w-full" type="number" name="pause_two"/>
                <x-input-error :messages="$errors->get('pause_two')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="pause_three" :value="__('messages.6 по 30м 3')"/>
                <x-text-input id="pause_three" class="flex mt-1 w-full" type="number" name="pause_three"/>
                <x-input-error :messages="$errors->get('pause_three')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="step" :value="__('messages.Ступень')"/>
                <x-text-input id="step" class="flex mt-1 w-full" type="number" name="step"/>
                <x-input-error :messages="$errors->get('step')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="mpk" :value="__('messages.МПК')"/>
                <x-text-input id="mpk" class="flex mt-1 w-full" type="number" name="mpk"/>
                <x-input-error :messages="$errors->get('mpk')" class="mt-2"/>
            </div>

            <div>
                <x-input-label for="level" :value="__('messages.Уровень')"/>
                <x-text-input id="level" class="flex mt-1 w-full" type="text" name="level"/>
                <x-input-error :messages="$errors->get('level')" class="mt-2"/>
            </div>
            <button type="submit"
                    class="mt-3 w-fit text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                {{ __('messages.Сохранить') }}
            </button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        $('#teamCodeSelect').change(function () {
            var teamId = $(this).val();
            var playerSelect = $('#playerSelect');
            playerSelect.empty();

            if (teamId) {
                $.ajax({
                    url: '{{ url('/teams') }}/' + teamId + '/players',
                    type: 'GET',
                    dataType: 'json',
                    success: function (players) {
                        if (players.length > 0) {
                            $.each(players, function (index, player) {
                                playerSelect.append(
                                    $('<option>', {
                                        value: player.id,
                                        text: player.last_name + ' ' + player.name
                                    })
                                );
                            });
                        } else {
                            playerSelect.append($('<option>', {
                                text: 'No active players',
                                disabled: true
                            }));
                        }
                    },
                    error: function () {
                        playerSelect.append($('<option>', {
                            text: 'Error loading players',
                            disabled: true
                        }));
                    }
                });
            } else {
                playerSelect.append($('<option>', {
                    text: 'Select a team first',
                    disabled: true
                }));
            }
        });

        // Триггерим change при загрузке формы, чтобы сразу загрузить игроков выбранной команды
        $('#teamCodeSelect').trigger('change');
    });
</script>
