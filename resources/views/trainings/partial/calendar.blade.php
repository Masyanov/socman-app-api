<div
    class="w-full relative grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-3 sm:gap-5 p-6 text-gray-900 dark:text-gray-100">
    <section class="col-span-1">
        <div class="flex flex-col">
            <div class="flex justify-between items-center gap-3">
                <div class="bg-primary-600 text-white font-bold rounded-lg p-3 text-center leading-none">
                    <div class="text-xs uppercase" id="dayOfWeek"></div>
                    <div class="text-2xl" id="dayNumber"></div>
                </div>
                <h2 class="text-2xl font-semibold dark:text-white" id="monthYearLabel"></h2>
                <div class="flex space-x-2 text-gray-500 dark:text-gray-400">
                    <button id="prevMonth" aria-label="Previous month" class="hover:text-primary-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button id="nextMonth" aria-label="Next month" class="hover:text-primary-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

        </div>

        <div class="flex justify-between bg-gray-100 dark:bg-gray-800 rounded-xl p-2 mb-6">
            <button id="btnToday" class="bg-primary-600 px-3 py-1 rounded-full text-white text-sm font-medium">{{ __('messages.Сегодня') }}
            </button>
        </div>

        <table class="w-full text-center text-gray-500 dark:text-gray-400 select-none">
            <thead class="border-b border-gray-200 dark:border-gray-700">
            <tr>
                <th class="py-2">{{ __('messages.Пн') }}</th>
                <th>{{ __('messages.Вт') }}</th>
                <th>{{ __('messages.Ср') }}</th>
                <th>{{ __('messages.Чт') }}</th>
                <th>{{ __('messages.Пт') }}</th>
                <th>{{ __('messages.Сб') }}</th>
                <th>{{ __('messages.Вс') }}</th>
            </tr>
            </thead>
            <tbody id="calendarBody" class="text-gray-900 dark:text-white"></tbody>
        </table>

    </section>

    <section class="col-span-2 bg-gray-50 dark:bg-gray-800 rounded-xl sm:p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold dark:text-white">{{ __('messages.Тренировки') }}</h3>
        </div>

        <div id="trainingsList"
             class="flex flex-col gap-3 max-h-[445px] overflow-y-auto text-gray-900 dark:text-gray-100">
            <!-- Здесь появятся тренировки -->
        </div>
    </section>
</div>

@php
    $calendarLocale = match(app()->getLocale()) {
        'en' => 'en-US',
        'es' => 'es-ES',
        default => 'ru-RU',
    };
    $calendarI18n = [
        'days' => [
            __('messages.Пн'), __('messages.Вт'), __('messages.Ср'), __('messages.Чт'),
            __('messages.Пт'), __('messages.Сб'), __('messages.Вс'),
        ],
        'loading' => __('messages.Загрузка...'),
        'noTrainings' => __('messages.Нет тренировок'),
        'loadError' => __('messages.Ошибка загрузки'),
        'conducted' => __('messages.Проведена'),
        'locale' => $calendarLocale,
    ];
@endphp
<script>
    window.__calendarI18n = @json($calendarI18n);

    // Формат даты YYYY-MM-DD
    function formatDate(date) {
        const y = date.getFullYear();
        const m = (date.getMonth() + 1).toString().padStart(2, '0');
        const d = date.getDate().toString().padStart(2, '0');
        return `${y}-${m}-${d}`;
    }

    // Дни недели (пн=0, вс=6) — из перевода
    const daysRU = window.__calendarI18n.days;

    // Функция, сдвигающая getDay(), чтобы воскресенье было последним днем (6)
    function getRuDayOfWeek(date) {
        const jsDay = date.getDay(); // 0=Вс, 1=Пн,...6=Сб
        return daysRU[(jsDay + 6) % 7];
    }

    let current = new Date();
    let currentYear = current.getFullYear();
    let currentMonth = current.getMonth();

    // Храним выбранную пользователем дату (по умолчанию сегодня)
    let selectedDate = new Date(current);

    const calendarBody = document.getElementById('calendarBody');
    const dayOfWeekLabel = document.getElementById('dayOfWeek');
    const dayNumberLabel = document.getElementById('dayNumber');
    const monthYearLabel = document.getElementById('monthYearLabel');
    const trainingsList = document.getElementById('trainingsList');

    // Рендер календаря на заданный месяц и год
    function renderCalendar(year, month) {
        calendarBody.innerHTML = '';

        // Заголовок с месяцем и годом (по текущей локали)
        const locale = window.__calendarI18n.locale;
        const monthStr = new Date(year, month).toLocaleString(locale, {month: 'long', year: 'numeric'});
        monthYearLabel.textContent = monthStr.charAt(0).toUpperCase() + monthStr.slice(1);

        // Первый день месяца (число 1)
        const firstDay = new Date(year, month, 1);
        let startDay = firstDay.getDay(); // 0=Вс ... 6=Сб
        startDay = startDay === 0 ? 7 : startDay; // сдвигаем Воскресенье (0) в конец
        // startDay теперь от 1 (Пн) до 7 (Вс) — соответствует порядку в таблице

        const daysInMonth = new Date(year, month + 1, 0).getDate();

        let day = 1;

        for (let week = 0; week < 6; week++) {
            const tr = document.createElement('tr');

            for (let wd = 1; wd <= 7; wd++) {
                const td = document.createElement('td');
                td.classList.add('py-3', 'cursor-pointer', 'select-none');

                if (week === 0 && wd < startDay) {
                    // Пустые ячейки до первого дня месяца
                    td.classList.add('text-gray-400');
                    td.textContent = '';
                } else if (day > daysInMonth) {
                    // Пустые ячейки после окончания месяца
                    td.classList.add('text-gray-400');
                    td.textContent = '';
                } else {
                    td.textContent = day;
                    const cellDate = new Date(year, month, day);

                    // Клик по дате
                    td.addEventListener('click', () => {
                        selectedDate = new Date(cellDate);
                        updateSelectedDateUI();
                        const selStr = formatDate(selectedDate);
                        fetchTrainings(selStr, selStr);
                        renderCalendar(currentYear, currentMonth);
                    });

                    // Подсвечиваем выбранную дату
                    if (formatDate(cellDate) === formatDate(selectedDate)) {
                        td.classList.add('bg-gray-700', 'text-white', 'rounded-full');
                    }

                    day++;
                }
                tr.appendChild(td);
            }
            calendarBody.appendChild(tr);
        }
    }

    // Обновление верхней панели с выбранной датой (день недели и число)
    function updateSelectedDateUI() {
        dayOfWeekLabel.textContent = getRuDayOfWeek(selectedDate);
        dayNumberLabel.textContent = selectedDate.getDate();
    }

    // Загрузка тренировок через ajax (axios)
    function fetchTrainings(start, end) {
        trainingsList.innerHTML = window.__calendarI18n.loading;
        axios.get('/calendar', {params: {start, end}})
            .then(res => {
                if (!res.data.length) {
                    trainingsList.innerHTML = '<p class="text-gray-500 dark:text-gray-400">' + window.__calendarI18n.noTrainings + '</p>';
                    return;
                }
                let html = '';
                res.data.forEach(t => {
                    const dayName = getRuDayOfWeek(new Date(t.date));
                    confirmedHtml = '';
                    if (t.confirmed) {
                        confirmedHtml = ` <div
                        class="inline-flex items-center bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300 absolute left-auto top-0 right-2" style="top:3px">
                            <span class="w-2 h-2 me-1 bg-yellow-500 rounded-full"></span>
                        ` + window.__calendarI18n.conducted + `
                        </div>`;
                    }
                    html += `
                        <a href="/trainings/${t.id}" class="relative p-4 rounded-lg bg-white dark:bg-gray-700 shadow dark:hover:bg-gray-600">
${confirmedHtml}
                            <div class="flex justify-between items-center mb-2">
                                <div class="p-2 px-2.5 bg-indigo-200 text-indigo-600 rounded-full  font-bold">${dayName}</div>
                                <div class="font-semibold dark:text-white">${t.start.slice(0, 5)} – ${t.finish.slice(0, 5)}</div>
                                <div class="text-sm text-gray-400">${t.team_name || ''}</div>
                            </div>
<div class="flex flex-col justify-between items-center sm:flex-row mb-2">
                            <div class="text-gray-700 dark:text-gray-300">${t.class || ''}</div>
                            <div class="text-gray-600 dark:text-gray-400 text-sm mt-1">${t.address || ''}</div>
</div>
                        </a>
                    `;
                });
                trainingsList.innerHTML = html;
            })
            .catch(() => {
                trainingsList.innerHTML = '<p class="text-red-500">' + window.__calendarI18n.loadError + '</p>';
            });
    }

    // Кнопки переключения месяцев
    document.getElementById('prevMonth').addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        // Сменить выделенную дату на первый день нового месяца
        selectedDate = new Date(currentYear, currentMonth, 1);
        updateSelectedDateUI();
        renderCalendar(currentYear, currentMonth);
        const selStr = formatDate(selectedDate);
        fetchTrainings(selStr, selStr);
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        // Сменить выделенную дату на первый день нового месяца
        selectedDate = new Date(currentYear, currentMonth, 1);
        updateSelectedDateUI();
        renderCalendar(currentYear, currentMonth);
        const selStr = formatDate(selectedDate);
        fetchTrainings(selStr, selStr);
    });

    // Кнопка "Сегодня"
    document.getElementById('btnToday').addEventListener('click', () => {
        current = new Date();
        currentYear = current.getFullYear();
        currentMonth = current.getMonth();
        selectedDate = new Date(current);
        updateSelectedDateUI();
        renderCalendar(currentYear, currentMonth);
        const todayStr = formatDate(selectedDate);
        fetchTrainings(todayStr, todayStr);
    });

    // Инициализация при загрузке страницы
    updateSelectedDateUI();
    renderCalendar(currentYear, currentMonth);
    fetchTrainings(formatDate(selectedDate), formatDate(selectedDate));
</script>
