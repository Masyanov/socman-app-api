<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PlayerTestImport;
use App\Imports\DuplicateEntryException; // Важно: импортируем наше кастомное исключение
use Maatwebsite\Excel\Validators\ValidationException; // Убедимся, что это исключение импортировано явно, хотя оно уже ловится

class PlayerTestImportController extends Controller
{
    // Показывает страницу с формой для загрузки
    public function create()
    {
        return view('admin.tests.import'); // Путь к вашему шаблону
    }

    // Обрабатывает загруженный файл
    public function store(Request $request)
    {
        // Валидация файла
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ], [
            'file.required' => 'Пожалуйста, выберите файл для импорта.',
            'file.mimes'    => 'Файл должен быть в формате Excel (xlsx или xls).'
        ]);

        try {
            // Импортируем данные из файла
            Excel::import(new PlayerTestImport, $request->file('file'));

            // Редирект обратно с сообщением об успехе
            return back()->with('success', __('messages.Данные успешно импортированы!'));

        } catch (DuplicateEntryException $e) {
            // Если перехвачено наше исключение, значит найден дубликат
            // Импорт был прерван, выдаем сообщение об ошибке пользователю
            return back()->with('error', $e->getMessage());
        } catch (ValidationException $e) { // Используем явно импортированное исключение
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                // Maatwebsite/Excel может возвращать несколько ошибок для одной строки
                foreach ($failure->errors() as $error) {
                    $errorMessages[] = sprintf("Ошибка в строке %d, колонке '%s': %s (Значение: '%s')",
                        $failure->row(),
                        $failure->attribute(), // Имя колонки, если доступно
                        $error,
                        $failure->values()[$failure->attribute()] ?? 'N/A' // Показываем значение, вызвавшее ошибку
                    );
                }
            }
            // Ограничим количество выводимых ошибок, чтобы не перегружать пользователя
            $displayErrors = array_slice($errorMessages, 0, 5); // Показать, например, первые 5 ошибок
            $moreErrorsCount = count($errorMessages) - count($displayErrors);
            $errorMessageString = implode("<br>", $displayErrors);
            if ($moreErrorsCount > 0) {
                $errorMessageString .= "<br>...и еще {$moreErrorsCount} ошибок.";
            }

            return back()->with('error', 'Обнаружены ошибки валидации в файле Excel:<br>' . $errorMessageString);
        } catch (\Exception $e) {
            // Обработка любых других непредвиденных ошибок, например, проблем с базой данных
            // или других исключений из Maatwebsite/Excel, которые не являются ValidationException
            return back()->with('error', 'Произошла непредвиденная ошибка во время импорта: ' . $e->getMessage());
        }
    }
}
