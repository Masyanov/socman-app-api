<div class="max-w-7xl mx-auto py-8">
    <h2 class="text-xl sm:text-2xl font-bold text-white mb-6">Результаты тестирования игроков</h2>

    <div class="bg-gray-800 p-6 rounded-lg shadow-md border border-gray-700">
        <h3 class="text-xl font-semibold mb-4">Все тесты</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Игрок
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Дата теста
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Позиция
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Статус
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Рост (см)
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Вес (кг)
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        ИМТ
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Отжимания
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Подтягивания
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        10м (с)
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        20м (с)
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        30м (с)
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Прыжок в длину (см)
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Прыжок вверх (без рук, см)
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Прыжок вверх (с руками, см)
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Иллинойс тест (с)
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Пауза 1
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Пауза 2
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Пауза 3
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Степ-тест
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        МПК
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Уровень
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                @forelse ($tests as $test)
                    <tr class="bg-gray-800 hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                            <a href="/users/{{ $test->user->id }}" type="button"
                               class="font-medium text-white dark:text-white">
                            {{ $test->user->name ?? 'N/A' }} {{ $test->user->last_name ?? '' }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            {{ $test->date_of_test ? \Carbon\Carbon::parse($test->date_of_test)->format('d.m.Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->position ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->status ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->height ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->weight ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->body_mass_index ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->push_ups ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->pull_ups ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->ten_m ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->twenty_m ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->thirty_m ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->long_jump ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->vertical_jump_no_hands ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->vertical_jump_with_hands ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->illinois_test ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->pause_one ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->pause_two ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->pause_three ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->step ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->mpk ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $test->level ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="22" class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-center">
                            Нет данных о тестах.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

