<div class="relative overflow-x-auto mb-6 shadow-md sm:rounded-lg">

    <h2 class="flex justify-between items-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight py-4">
        {{ __('messages.Управление Telegram-ботом') }}
    </h2>
    <div id="bot-status-block" class="mb-6 flex items-center gap-2 text-sm">
        <div id="bot-status-spinner" class="hidden">
            <svg class="animate-spin h-5 w-5 text-blue-500" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2" class="opacity-25"/>
                <path d="M4 12a8 8 0 018-8" fill="none" stroke="currentColor" stroke-width="2" class="opacity-75"/>
            </svg>
        </div>
        <div id="bot-status" class="text-gray-600"></div>
    </div>
    <div class="flex gap-4 flex-wrap mb-6">
        <button onclick="sendBotAction('stop', this)"
                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded transition">
            {{ __('messages.Остановить') }}
        </button>
        <button onclick="sendBotAction('remove', this)"
                class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded transition">
            {{ __('messages.Удалить') }}
        </button>
        <button onclick="sendBotAction('restart', this)"
                class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded transition">
            {{ __('messages.Пересобрать') }}
        </button>
        <button onclick="sendBotAction('run', this)"
                class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded transition">
            {{ __('messages.Запустить') }}
        </button>
    </div>

</div>
<script>
    @php
        $botI18n = [
            'executing' => __('messages.Выполняется...'),
            'unauthorized' => __('messages.Вы не авторизованы'),
            'error' => __('messages.Ошибка'),
            'statusUnknown' => __('messages.Статус неизвестен'),
            'statusError' => __('messages.Ошибка получения статуса'),
        ];
    @endphp
    window.__botI18n = @json($botI18n);
    window.showBotStatus = function (html, color = "gray") {
        const statusDiv = document.getElementById('bot-status');
        statusDiv.innerHTML = html;
        statusDiv.className = `text-${color}-600`;
    }
    window.showBotSpinner = function (show) {
        document.getElementById('bot-status-spinner').classList.toggle("hidden", !show);
    }

    window.sendBotAction = function (action, btn) {
        showBotStatus(window.__botI18n.executing, "blue");
        showBotSpinner(true);
        btn.disabled = true;
        fetch(`/docker-bot/${action}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || '',
                'Accept': 'application/json'
            }
        })
            .then(res => {
                if (res.status === 419) throw new Error("CSRF token mismatch");
                if (res.status === 401) throw new Error(window.__botI18n.unauthorized);
                return res.json();
            })
            .then(data => {
                const err = window.__botI18n.error;
                if (data.status === true || data.status === "true") {
                    showBotStatus(`<span class="inline-block align-middle mr-1">&#9989;</span>  <b>OK</b><br>${(data.output || '').replace(/\n/g, '<br>')}`, "green");
                } else {
                    showBotStatus(`<span class="inline-block align-middle mr-1">&#10060;</span> <b>${err}</b><br>${(data.output || '').replace(/\n/g, '<br>')}`, "red");
                }
            })
            .catch(e => {
                showBotStatus(`<span class="inline-block align-middle mr-1">&#9888;&#65039;</span> <b>${window.__botI18n.error}</b>: ${e.message}`, "red");
            })
            .finally(() => {
                btn.disabled = false;
                showBotSpinner(false);
                getBotStatus();
            });
    }

    window.getBotStatus = function () {
        showBotSpinner(true);
        fetch('/docker-bot/status', {
            headers: {'Accept': 'application/json'}
        })
            .then(res => res.json())
            .then(data => {
                let color = "gray", icon = "";
                if (data.state === "running") {
                    color = "green";
                    icon = "&#9989;";
                } else if (data.state === "exited") {
                    color = "red";
                    icon = "&#10060;";
                } else if (data.status === false) {
                    color = "red";
                    icon = "&#9888;&#65039;";
                }
                showBotStatus((icon ? `<span class="inline-block align-middle mr-1">${icon}</span>` : "") + (data.output || window.__botI18n.statusUnknown), color);
            })
            .catch(() => showBotStatus(window.__botI18n.statusError, "red"))
            .finally(() => showBotSpinner(false));
    }

    document.addEventListener('DOMContentLoaded', () => {
        getBotStatus();
    });
</script>
<div class="relative overflow-x-auto mb-6 shadow-md sm:rounded-lg">
    <h2 class="flex justify-between items-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight py-4">
        {{ __('messages.Тренеры') }}
    </h2>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">
                {{ __('messages.Имя') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('messages.Реф-ссылка') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('messages.Роль') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('messages.Команды тренера') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('messages.Ссылка для входа') }}
            </th>
            <th scope="col" class="px-6 py-3">
                AI
            </th>
            <th scope="col" class="px-6 py-3">
                LC
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('messages.Активность') }}
            </th>
            <th scope="col" class="px-6 py-3">
                {{ __('messages.Удалить') }}
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach(allMainUsers() as $coach)
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row"
                    class="flex gap-1 px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <div>{{ $coach->name }} {{ $coach->last_name }}</div>
                    @if($coach->active)
                        <div id="changeAvailable{{ $coach->id }}">
                            <div
                                class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                <div class="w-2 h-2 me-1 bg-green-500 rounded-full"></div>
                                {{ __('messages.Активный') }}
                            </div>
                        </div>
                    @else
                        <div id="changeAvailable{{ $coach->id }}">
                            <div
                                class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                <div class="w-2 h-2 me-1 bg-red-500 rounded-full"></div>
                                {{ __('messages.Не активный') }}
                            </div>
                        </div>
                    @endif
                </th>
                <th scope="row"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    @php $referralSetting = $coach->settings->firstWhere('slug', 'referral_code');  @endphp

                    @if($referralSetting)
                        <div class="w-32 max-w-[16rem]">
                            <div class="relative">
                                <label for="npm-install-copy-button" class="sr-only">Label</label>
                                <input id="npm-install-copy-button" type="text"
                                       class="col-span-6 bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       value="{{ $referralSetting->value }}"
                                       disabled readonly>
                                <button data-copy-to-clipboard-target="npm-install-copy-button"
                                        data-tooltip-target="tooltip-copy-npm-install-copy-button"
                                        class="absolute end-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg p-2 inline-flex items-center justify-center">
            <span id="default-icon">
                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                     viewBox="0 0 18 20">
                    <path
                        d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                </svg>
            </span>
                                    <span id="success-icon" class="hidden">
                <svg class="w-3.5 h-3.5 text-blue-700 dark:text-blue-500" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
            </span>
                                </button>
                                <div id="tooltip-copy-npm-install-copy-button" role="tooltip"
                                     class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                    <span id="default-tooltip-message">{{ __('messages.Скопировать') }}</span>
                                    <span id="success-tooltip-message" class="hidden">{{ __('messages.Скопировано!') }}</span>
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </div>
                        </div>
                    @else
                        Реф нету
                    @endif
                </th>
                <th scope="row"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{  $coach->role }}
                </th>
                <th scope="row"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    @if(whatInArray(teamsOfCoach($coach->id)))
                        @foreach (teamsOfCoach($coach->id) as $key => $team)
                            {{ $team->name }} - {{ $team->team_code }}<br>
                        @endforeach
                    @else
                        <div>{{ __('messages.Команд нет') }}</div>
                    @endif
                </th>
                <td class="px-6 py-4">
                    <a href="/loginAsUser/{{ $coach->id }}"
                       class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __('messages.Войти под этим пользователем') }}</a>
                </td>
                <th scope="row"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <div class="flex">
                        @php
                            $aiSetting = $coach->settings->where('slug', 'ai')->first();
                        @endphp
                        <input type="checkbox"
                               onclick="updateActiveAI({{ $coach->id }}, this)"
                               data-user-id="{{ $coach->id }}" {{ ($aiSetting && $aiSetting->active) ? 'checked' : '' }}>
                    </div>
                </th>
                <th scope="row"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <div class="flex">
                        <input type="checkbox"
                               onclick="updateActiveLoadControl({{ $coach->id }}, this)"
                               data-user-id="{{ $coach->id }}" {{ $coach->load_control ? 'checked' : '' }}>
                    </div>
                </th>
                <th scope="row"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="flex">
                        <input type="checkbox"
                               onclick="updateActive({{ $coach->id }}, '{{ __('messages.Активный') }}', '{{ __('messages.Не активный') }}', this)"
                               data-user-id="{{ $coach->id }}" {{ $coach->active ? 'checked' : '' }}>
                    </div>
                </th>
                <th scope="row"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <a id="button_del_user" href="javascript:void(0)"
                       class="p-2 rounded-md bg-red-500 hover:bg-red-700 flex w-fit h-full"
                       onclick="deleteUser({{ $coach->id }})"
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
                </th>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <h2 class="flex justify-between items-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight py-4">
        Подписки
    </h2>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">ID</th>
            <th scope="col" class="px-6 py-3">{{ __('messages.Пользователь') }}</th>
            <th scope="col" class="px-6 py-3">{{ __('messages.Подписка') }}</th>
            <th scope="col" class="px-6 py-3">{{ __('messages.Начало') }}</th>
            <th scope="col" class="px-6 py-3">{{ __('messages.Окончание') }}</th>
            <th scope="col" class="px-6 py-3">{{ __('messages.Оплачено') }}</th>
            <th scope="col" class="px-6 py-3">{{ __('messages.Действия') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach (subscriptions() as $s)
            <tr>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $s->id }}</td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $s->user->name }} {{ $s->user->last_name }}</td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $s->subscription }}</td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $s->start_date }}</td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $s->end_date }}</td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    @if($s->is_paid)
                        <span class="badge bg-success">{{ __('messages.Да') }}</span>
                    @else
                        <span class="badge bg-secondary">{{ __('messages.Нет') }}</span>
                    @endif
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <a href=""
                       class="btn btn-sm btn-primary">{{ __('messages.Изменить') }}</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
