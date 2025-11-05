<?php

namespace App\Imports;

use App\Models\PlayerTest;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Illuminate\Support\Facades\Log;

// Класс DuplicateEntryException больше не нужен, так как мы не будем прерывать импорт.
// Его можно удалить, если он не используется больше нигде.
// class DuplicateEntryException extends \Exception {}

class PlayerTestImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    /**
     * @param array $row Ассоциативный массив, где ключи - это заголовки столбцов из Excel
     *
     * @return \Illuminate\Database\Eloquent\Model|null Возвращает экземпляр модели PlayerTest или null, если строка не должна быть импортирована
     */
    public function model(array $row)
    {
        // Проверяем наличие ID игрока
        if (!isset($row['id']) || empty($row['id'])) {
            Log::warning('Пропущена строка из Excel: отсутствует ID игрока.', $row);
            return null; // Пропускаем строку, если нет ID игрока
        }

        $dateOfTest = $this->transformDate($row['date_of_test'] ?? null);

        // Проверяем корректность даты
        if (is_null($dateOfTest)) {
            Log::warning('Пропущена строка из Excel: неверный или отсутствующий формат даты.', $row);
            return null; // Пропускаем строку, если дата некорректна
        }

        // Проверяем наличие дубликата по player_id и date_of_test
        $existingRecord = PlayerTest::where('player_id', $row['id'])
                                    ->where('date_of_test', $dateOfTest)
                                    ->first();

        if ($existingRecord) {
            // Если запись уже существует, логируем и пропускаем эту строку
            Log::info(sprintf('Пропущена дублирующая запись для игрока с ID %s и датой теста %s. Строка не импортирована.', $row['id'], $dateOfTest), $row);
            return null; // Возвращаем null, чтобы пропустить эту строку
        }

        // Если дубликата нет и все проверки пройдены, создаем новую запись
        return new PlayerTest([
            'player_id'                 => $row['id'],
            'date_of_test'              => $dateOfTest,
            'position'                  => $row['position'] ?? null,
            'status'                    => $row['status'] ?? null,
            'height'                    => $this->cleanNumericValue($row['height'] ?? null),
            'weight'                    => $this->cleanNumericValue($row['weight'] ?? null),
            'body_mass_index'           => $this->cleanNumericValue($row['body_mass_index'] ?? null),
            'push_ups'                  => $this->cleanNumericValue($row['push_ups'] ?? null),
            'pull_ups'                  => $this->cleanNumericValue($row['pull_ups'] ?? null),
            'ten_m'                     => $this->cleanNumericValue($row['ten_m'] ?? null),
            'twenty_m'                  => $this->cleanNumericValue($row['twenty_m'] ?? null),
            'thirty_m'                  => $this->cleanNumericValue($row['thirty_m'] ?? null),
            'long_jump'                 => $this->cleanNumericValue($row['long_jump'] ?? null),
            'vertical_jump_no_hands'    => $this->cleanNumericValue($row['vertical_jump_no_hands'] ?? null),
            'vertical_jump_with_hands'  => $this->cleanNumericValue($row['vertical_jump_with_hands'] ?? null),
            'illinois_test'             => $this->cleanNumericValue($row['illinois_test'] ?? null),
            'pause_one'                 => $this->cleanNumericValue($row['pause_one'] ?? null),
            'pause_two'                 => $this->cleanNumericValue($row['pause_two'] ?? null),
            'pause_three'               => $this->cleanNumericValue($row['pause_three'] ?? null),
            'step'                      => $this->cleanNumericValue($row['step'] ?? null),
            'mpk'                       => $this->cleanNumericValue($row['mpk'] ?? null),
            'level'                     => $row['level'] ?? null,
        ]);
    }

    private function transformDate($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        // Если значение уже является объектом Carbon, форматируем его
        if ($value instanceof Carbon) {
            return $value->format('Y-m-d');
        }

        // Если значение числовое, пытаемся преобразовать его из Excel-формата даты
        if (is_numeric($value)) {
            try {
                // Проверяем, чтобы число было в разумном диапазоне для Excel-даты
                if ($value > 0 && $value < 100000) { // Excel-даты обычно от 1 до 60000+
                    $date = ExcelDate::excelToDateTimeObject($value);
                    return Carbon::instance($date)->format('Y-m-d');
                }
            } catch (\Exception $e) {
                Log::debug("Не удалось преобразовать Excel-дату из числа: " . $e->getMessage(), ['value' => $value]);
            }
        }

        // Пытаемся распарсить строку даты в различных форматах
        try {
            // Формат dd.mm.yyyy
            if (preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $value)) {
                $date = Carbon::createFromFormat('d.m.Y', $value);
                if ($date && $date->format('d.m.Y') === $value) { // Дополнительная проверка на валидность
                    return $date->format('Y-m-d');
                }
            }
            // Формат yyyy-mm-dd
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                $date = Carbon::createFromFormat('Y-m-d', $value);
                if ($date && $date->format('Y-m-d') === $value) { // Дополнительная проверка на валидность
                    return $date->format('Y-m-d');
                }
            }

            // Если выше не подошло, пробуем универсальный парсер Carbon
            $date = Carbon::parse($value);
            return $date->format('Y-m-d');

        } catch (\Exception $e) {
            Log::error("Не удалось распарсить дату из Excel. Проверьте формат. Ошибка: " . $e->getMessage(), ['value' => $value]);
            return null;
        }
        return null; // В случае, если ни один из способов не сработал
    }

    /**
     * Очищает и преобразует числовое значение, всегда возвращая float, если значение числовое.
     *
     * @param mixed $value Входное значение.
     * @return float|int|null Очищенное числовое значение в формате float, или null.
     */
    private function cleanNumericValue($value)
    {
        if (is_null($value) || $value === '') {
            return null;
        }

        $cleanedValue = (string) $value;
        // Заменяем запятую на точку для правильного парсинга дробных чисел в PHP
        $cleanedValue = str_replace(',', '.', $cleanedValue);
        // Удаляем все, кроме цифр, точки и минуса
        $cleanedValue = preg_replace('/[^0-9.-]/', '', $cleanedValue);

        // Если после очистки значение является числом
        if (is_numeric($cleanedValue)) {
            // Всегда приводим к float, чтобы сохранить дробную часть,
            // если она есть, и обеспечить единообразие для полей, которые могут быть дробными.
            return (float) $cleanedValue;
        }

        return null;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
