<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\TeamDataService;

class AIAnalyzeController extends Controller {
    public function analyze( Request $request , TeamDataService $teamDataService) {
        // Получаем данные из запроса
        $team_id   = $request->input('team_id');
        $weekSelectDetail = $request->input('weekSelectDetail');
        $player_id = $request->input('player_id');

        $team = Team::where('id',$team_id)->first();

        $data = $teamDataService->getFilteredData($team, $weekSelectDetail, $player_id);


        // Используйте свой Hugging Face access token
        $hf_token = env( 'HUGGINGFACE_API_KEY' );



        function arrayToTextQuery(array $data): string
        {
            $lines = [];
            foreach ($data as $playerName => $dates) {
                $lines[] = "Данные для анализа ($playerName):";
                foreach ($dates as $date => $metrics) {
                    $metricsParts = [];
                    foreach ($metrics as $key => $value) {
                        $metricsParts[] = "{$key}={$value}";
                    }
                    $lines[] = "  {$date}: " . implode(', ', $metricsParts);
                }
            }

            return implode("\n", $lines);
        }

        function strip_code_fences($input) {
            // Удаляет тройные кавычки с опциональным 'html', в начале и в конце строки
            $input = preg_replace('/^```html[\r\n]?/i', '', $input); // убирает ```html в начале
            $input = preg_replace('/^```[\r\n]?/i', '', $input);     // убирает ``` в начале
            $input = preg_replace('/```$/i', '', $input);            // убирает ``` в конце строки
            $input = preg_replace('/```[\r\n]?$/i', '', $input);     // убирает ``` в конце + перевод строки
            $input = trim($input);                                   // Убирает пробелы и переносы строк по краям
            return $input;
        }

        // Формируем промпт для ИИ на основе входных данных
        $content = "Проанализируй оценки субъективно воспринимаемой нагрузки за последние 7 дней. Они должны сначала отражать общую тенденцию по команде с выведением среднего значения по группе игроков которая принимала участие в тренировке по дням, а затем дополнять индивидуальными анализами по каждому игроку. В анализ должны входить разбивка цикла на дни с малой нагрузкой (от 1 до 4 у.е), средней (от 5 до 7 у.е) и большой (от 8 до 10 у.е). Так же они должны учитывать повторяющиеся более двух раз подряд низкие оценки или высокие. Мы должны соблюдать волнообразность нагрузки и тренироваться в эффективном диапазоне. Если игрок ставит всегда среднюю нагрузку это тоже сигнал для тренера и это тоже надо посветить в отчетах. ";
        $structureContent = 'Структура ответа: <div class="bg-gray-700 text-white rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Общее состояние -->
        <div class="bg-gray-800 p-4 rounded-lg">
            <h3 class="text-xl font-semibold mb-2">Общая тенденция по команде</h3>
            <p>Здесь текст </p>
        </div>

        <!-- Физическая готовность -->
        <div class="bg-gray-800 p-4 rounded-lg">
            <h3 class="text-xl font-semibold mb-2">Анализ по циклу</h3>
            <p>Здесь текст </p>
        </div>
    </div>
        <div class="mt-6 bg-gray-800 p-4 rounded-lg">
            <h3 class="text-xl font-semibold mb-2">Индивидуальный анализ отдельных игроков за последние 7 дней</h3>
            <ul>Здесь список</ul>
        </div>
    <!-- Рекомендации -->
    <div class="mt-6 bg-gray-800 p-4 rounded-lg">
        <h3 class="text-xl font-semibold mb-2">Рекомендации тренеру на основе анализа:</h3>
        <ul class="list-disc pl-5">
            пункты
        </ul>
    </div>
</div>';
        $query = ' В Индивидуальном анализе вывести только тех на кого обратить внимание. Ответ Без лишних комментариев от ИИ как сделан анализ. ';
        if ($data['results']) {
            $jsonData = json_encode($data['results'], JSON_UNESCAPED_UNICODE);
            $textSet = arrayToTextQuery($data['results']);
            $content .= $textSet;
        }

        if ($query) {
            $content .= $query;
        }
        if ($structureContent) {
            $content .= $structureContent;
        }

        $response = Http::withHeaders( [
            'Authorization' => 'Bearer ' . $hf_token,
            'Content-Type'  => 'application/json',
        ] )
            ->timeout(60)
                        ->post( 'https://router.huggingface.co/v1/chat/completions', [
                            'messages' => [
                                [
                                    'role'    => 'user',
                                    'content' => $content,
                                ],
                            ],
                            'model'    => 'CohereLabs/c4ai-command-a-03-2025',
                            'stream'   => false,
                        ] );

        if ( $response->ok() ) {
            // Ответ может быть строкой или массивом в зависимости от модели
            $result = $response->json();
            $clean = strip_code_fences($result['choices'][0]['message']['content']);
            $text = $clean ?? 'Ответ не найден';

            return response()->json( [ 'result' => $text ] );
        } else {
            return response()->json( [
                'result' => 'Ошибка Hugging Face: ' . $response->status() . ' — ' . $response->body()
            ], 500 );
        }
    }
}
