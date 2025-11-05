<?php

namespace App\Exports;

use App\Models\User; // Убедитесь, что это ваша реальная модель пользователя
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TestingFormExport implements FromCollection, WithHeadings, WithMapping
{
    protected string $teamCode; // Изменили тип на string и имя на teamCode

    /**
     * @param string $teamCode Код команды, для которой формируется бланк
     */
    public function __construct(string $teamCode) // Изменили тип на string
    {
        $this->teamCode = $teamCode;
    }

    /**
     * Возвращает коллекцию игроков только для указанной команды (по team_code).
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Выбираем игроков (пользователей), которые принадлежат к нужной команде по team_code
        return User::where('team_code', $this->teamCode)->get();
    }

    /**
     * Определяет заголовки для всех колонок в Excel файле.
     * @return array
     */
    public function headings(): array
    {
        return [
            // Основные данные игрока
            // Возможно, вы захотите здесь 'Team Code' вместо 'Team ID',
            // но я оставил 'Team ID', как было в вашем запросе,
            // а ниже в map() я покажу, как можно выводить team_code
            'Team ID',
            'id',
            'Player Name',

            // Пустые колонки для заполнения
            'date_of_test',
            'position',
            'status',
            'height',
            'weight',
            'body_mass_index',
            'push_ups',
            'pull_ups',
            'ten_m',
            'twenty_m',
            'thirty_m',
            'long_jump',
            'vertical_jump_no_hands',
            'vertical_jump_with_hands',
            'illinois_test',
            'pause_one',
            'pause_two',
            'pause_three',
            'step',
            'mpk',
            'level',
        ];
    }

    /**
     * Заполняет данные для каждой строки.
     * @param mixed $player Модель User
     * @return array
     */
    public function map($player): array
    {
        return [
            $player->team_code,
            $player->id,
            $player->name . ' ' . $player->last_name,

            // Остальные 21 колонка остаются пустыми для ручного ввода
            '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',
        ];
    }
}
