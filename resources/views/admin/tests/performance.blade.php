<div class="max-w-screen-xl mx-auto">
    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900 dark:text-white mb-6">Общие показатели
        команды {{ $team->name ?? $team->team_code }}</h1>

    @php
        // Перемещаем определение цветов сюда, чтобы они всегда были доступны
        $collapseIdCounter = 0; // Для уникальных ID коллапсов
        $dateColors = [
            'rgba(75, 192, 192, 0.8)',   // Голубой
            'rgba(153, 102, 255, 0.8)',  // Фиолетовый
            'rgba(255, 159, 64, 0.8)',   // Оранжевый
            'rgba(255, 99, 132, 0.8)',   // Красный
            'rgba(54, 162, 235, 0.8)',   // Синий
            'rgba(201, 203, 207, 0.8)'   // Серый
        ];
        $dateBorderColors = [
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(201, 203, 207, 1)'
        ];
    @endphp

    @if($chartData && !empty($chartData['labels']))

        <div id="accordion-flush-parent" data-accordion="collapse"
             data-active-classes="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white"
             data-inactive-classes="text-gray-500 dark:text-gray-400">
            @foreach($categorizedMetrics as $categoryTitle => $categoryData)
                @php $collapseIdCounter++; @endphp
                <h2 id="accordion-flush-heading-{{ $collapseIdCounter }}">
                    <button type="button"
                            class="border-b-2 bg-gray-700 flex items-center justify-between w-full py-5 px-5 font-medium rtl:text-right text-gray-500 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-500 gap-3"
                            data-accordion-target="#accordion-flush-body-{{ $collapseIdCounter }}"
                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                            aria-controls="accordion-flush-body-{{ $collapseIdCounter }}">
                        <span class="flex items-center">
                            {{ $categoryTitle }}
                        </span>
                        {{-- Убедитесь, что эта иконка fa-chevron-down/right корректно отображается,
                            если используется Font Awesome, и она будет управляться JS ниже. --}}
                        <i class="fas fa-chevron-{{ $loop->first ? 'down' : 'right' }} w-3 h-3 me-2 shrink-0 text-gray-500 dark:text-gray-400"></i>
                    </button>
                </h2>
                <div id="accordion-flush-body-{{ $collapseIdCounter }}"
                     class="{{ $loop->first ? '' : 'hidden' }} py-5 px-5 bg-gray-900"
                     aria-labelledby="accordion-flush-heading-{{ $collapseIdCounter }}">
                    <div class="py-2"> {{-- padding для внутреннего контента --}}
                        @foreach($categoryData['metrics'] as $metricKey => $metric)
                            @if(!empty($metric['datasets']))
                                <h5 class="text-xl font-semibold text-blue-600 dark:text-blue-500 mb-2">{{ $metric['title'] }}</h5>
                                <p class="text-gray-500 dark:text-gray-400 mb-4">Сравнение
                                    по {{ strtolower($metric['title']) }}.</p>
                                <div class="w-full h-60 lg:h-96 mb-6"> {{-- Адаптивная высота для графиков --}}
                                    <canvas id="{{ $metricKey }}Chart"></canvas>
                                </div>
                                @if(!$loop->last)
                                    <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700"> {{-- Tailwind-аналог hr --}}
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

    @else
        <div
            class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
            role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Информация</span>
            <div>
                <span class="font-medium">Внимание!</span> Для этой команды пока нет данных по тестам, или проверьте
                правильность `team_code`.
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Flowbite инициализирует свои компоненты, включая аккордеоны,
        // но для кастомных иконок нам понадобится свой JS.
        // initFlowbite(); // Если вы вызываете initFlowbite() глобально, здесь это не нужно.

        const chartData = @json($chartData);
        // Теперь $dateColors и $dateBorderColors всегда определены
        const dateColors = @json($dateColors);
        const dateBorderColors = @json($dateBorderColors);

        if (chartData && chartData.labels.length > 0) {
            const dynamicDateColors = {};
            const dynamicDateBorderColors = {};
            if (chartData.dates) {
                chartData.dates.forEach((date, index) => {
                    dynamicDateColors[date] = dateColors[index % dateColors.length];
                    dynamicDateBorderColors[date] = dateBorderColors[index % dateBorderColors.length];
                });
            }

            for (const metricKey in chartData.metrics) {
                if (chartData.metrics.hasOwnProperty(metricKey)) {
                    const metric = chartData.metrics[metricKey];
                    const ctx = document.getElementById(`${metricKey}Chart`);

                    if (ctx) {
                        new Chart(ctx.getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: chartData.labels,
                                datasets: metric.datasets.map(dataset => ({
                                    label: dataset.label,
                                    data: dataset.data,
                                    backgroundColor: dynamicDateColors[dataset.label],
                                    borderColor: dynamicDateBorderColors[dataset.label],
                                    borderWidth: 1
                                }))
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: `${metric.title}: Сравнение по датам`,
                                        font: {
                                            size: 16
                                        },
                                        color: document.documentElement.classList.contains('dark') ? '#f3f4f6' : '#1f2937' // Адаптация цвета для темной темы
                                    },
                                    legend: {
                                        position: 'top',
                                        labels: {
                                            color: document.documentElement.classList.contains('dark') ? '#d1d5db' : '#374151' // Адаптация цвета для темной темы
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: `${metric.title} ${metric.unit ? '(' + metric.unit + ')' : ''}`,
                                            color: document.documentElement.classList.contains('dark') ? '#d1d5db' : '#374151' // Адаптация цвета для темной темы
                                        },
                                        ticks: {
                                            color: document.documentElement.classList.contains('dark') ? '#d1d5db' : '#374151'
                                        },
                                        grid: {
                                            color: document.documentElement.classList.contains('dark') ? 'rgba(75,85,99,0.5)' : 'rgba(209,213,219,0.5)'
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Игроки',
                                            color: document.documentElement.classList.contains('dark') ? '#d1d5db' : '#374151' // Адаптация цвета для темной темы
                                        },
                                        ticks: {
                                            color: document.documentElement.classList.contains('dark') ? '#d1d5db' : '#374151'
                                        },
                                        grid: {
                                            color: document.documentElement.classList.contains('dark') ? 'rgba(75,85,99,0.5)' : 'rgba(209,213,219,0.5)'
                                        }
                                    }
                                }
                            }
                        });
                    }
                }
            }
        }

        // --- Логика для изменения иконок аккордеона Flowbite ---
        function updateAccordionIcon(button) {
            const icon = button.querySelector('.fas');
            if (icon) {
                const isExpanded = button.getAttribute('aria-expanded') === 'true';
                if (isExpanded) {
                    icon.classList.remove('fa-chevron-right');
                    icon.classList.add('fa-chevron-down');
                } else {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-right');
                }
            }
        }

        document.querySelectorAll('[data-accordion-target]').forEach(button => {
            // Изначально обновляем иконку только если аккордеон открыт по умолчанию
            if (button.getAttribute('aria-expanded') === 'true') {
                updateAccordionIcon(button);
            }

            button.addEventListener('click', function () {
                setTimeout(() => updateAccordionIcon(this), 0);
            });
        });
    });
</script>
