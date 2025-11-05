<?php
// app/Http/Controllers/ExportController.php

namespace App\Http\Controllers;

use App\Exports\TestingFormExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * Обрабатывает экспорт бланка для конкретной команды по team_code.
     * @param string $teamCode
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportTestingForm(string $teamCode) // Изменили тип на string и имя на $teamCode
    {
        // Формируем имя файла, например, "testing_blank_team_XYZ123.xlsx"
        $fileName = 'testing_blank_team_' . $teamCode . '.xlsx';

        // Создаем новый экземпляр экспорта, передавая ему teamCode
        return Excel::download(new TestingFormExport($teamCode), $fileName);
    }
}
