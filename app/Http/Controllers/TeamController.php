<?php

namespace App\Http\Controllers;

use App\Models\AchievementType;
use App\Models\PlayerTest;
use App\Models\PresenceTraining;
use App\Models\Question;
use App\Models\Team;
use App\Models\Training;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\HuggingFaceService;
use Illuminate\Support\Facades\Http;

class TeamController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request ) {
        $userId = Auth::user()->id;

        $teams = Team::query()
                     ->where( 'user_id', $userId )
                     ->latest( 'created_at' )
                     ->paginate( 10 );

        $teamActive = Team::query()
                          ->where( 'active', true )
                          ->where( 'user_id', $userId )
                          ->latest( 'created_at' )
                          ->paginate( 10 );

        $tests = PlayerTest::with( 'user' )->orderBy( 'date_of_test', 'desc' )->get();

        if ( $request->ajax() ) {
            return view( 'teams.index',
                [ 'teamActive' => $teamActive, 'teams' => $teams, 'tests' => $tests ] )->render();
        }

        $allAchievementTypes = AchievementType::all();
            $coachSelectedAchievementTypeIds = Auth::user()->achievementTypes->pluck('id')->toArray();



        return view( 'teams.index', compact( 'teamActive', 'allAchievementTypes', 'coachSelectedAchievementTypeIds', 'teams', 'tests' ) );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Request $request ) {
        $userId = Auth::user()->id;

        $validated = $request->validate( [
            'team_name' => [ 'required', 'string', 'max:1500' ],
            'team_code' => [ 'required', 'max:7', 'unique:teams,team_code' ],
            'desc'      => [ 'nullable' ],
            'active'    => [ 'nullable', 'boolean' ],
        ] );

        $team = Team::query()->create( [
            'user_id'   => $userId,
            'name'      => $validated['team_name'],
            'team_code' => $validated['team_code'],
            'desc'      => $validated['desc'],
            'active'    => true,
        ] );

        return response()->json( [ 'code' => 200, 'message' => 'Запись успешно создана', 'data' => $team ], 200 );
    }

    /**
     * Display the specified resource.
     */
    public function show( Request $request, Team $team ) {
        $today         = Carbon::now();
        $formattedDate = $today->format( 'Y-m-d' );

        // 1. Определяем date_from
        if ( $request->input( 'date_from' ) ) {
            $startDate = $request->input( 'date_from' );
        } elseif ( $request->cookie( 'date_from' ) ) {
            $startDate = $request->cookie( 'date_from' );
        } elseif ( $request->cookies->get( 'date_from' ) ) {
            $startDate = $request->cookies->get( 'date_from' );
        } elseif ( isset( $_COOKIE['date_from'] ) ) {
            $startDate = $_COOKIE['date_from'];
        } else {
            $startDate = $formattedDate;
        }

        // 2. Определяем date_to
        if ( $request->input( 'date_to' ) ) {
            $endDate = $request->input( 'date_to' );
        } elseif ( $request->cookie( 'date_to' ) ) {
            $endDate = $request->cookie( 'date_to' );
        } elseif ( $request->cookies->get( 'date_to' ) ) {
            $endDate = $request->cookies->get( 'date_to' );
        } elseif ( isset( $_COOKIE['date_to'] ) ) {
            $endDate = $_COOKIE['date_to'];
        } else {
            $endDate = Carbon::now()->subWeek()->format( 'Y-m-d' );
        }

        // 3. Определяем player_id
        if ( $request->input( 'player_id' ) ) {
            $playerId = $request->input( 'player_id' );
        } elseif ( $request->cookie( 'player_id' ) ) {
            $playerId = $request->cookie( 'player_id' );
        } elseif ( $request->cookies->get( 'player_id' ) ) {
            $playerId = $request->cookies->get( 'player_id' );
        } elseif ( isset( $_COOKIE['player_id'] ) ) {
            $playerId = $_COOKIE['player_id'];
        } else {
            $playerId = '';
        }

        $userId = Auth::user()->id;

        $team = Team::where( 'id', $team->id )->where( 'user_id', $userId )->first();

        $usersOfTeam = User::query()
                           ->where( 'team_code', $team->team_code )
                           ->latest( 'created_at' )
                           ->get();

        $usersOfTeamLoadControlQuery = User::query()
                                           ->where( 'team_code', $team->team_code )
                                           ->where( 'active', 1 )
                                           ->latest( 'created_at' )
                                           ->where( 'active', true );

        if ( $playerId ) {
            // Filter only one player
            $usersOfTeamLoadControlQuery->where( 'id', $playerId );
        }

        $usersOfTeamLoadControl = $usersOfTeamLoadControlQuery->get();

        // Query answers with user_id filter
        $answersQuery = DB::table( 'questions' )
                          ->select(
                              'user_id',
                              'created_at',
                              'recovery',
                              'load',
                              'pain',
                              'local',
                              'sleep',
                              'sleep_time',
                              'moral',
                              'physical',
                              'presence_checkNum',
                              'cause'
                          )
                          ->whereBetween( 'created_at', [ $startDate, $endDate ] );

        if ( $playerId ) {
            $answersQuery->where( 'user_id', $playerId );
        } else {
            $userIds = $usersOfTeamLoadControl->pluck( 'id' )->toArray();
            $answersQuery->whereIn( 'user_id', $userIds );
        }
        $answers = $answersQuery->get();

        // Dates block
        $dates = DB::table( 'questions' )
                   ->selectRaw( 'DATE(created_at) as date' )
                   ->whereBetween( 'created_at', [ $startDate, $endDate ] );

        if ( $playerId ) {
            $dates->where( 'user_id', $playerId );
        } else {
            $userIds = $usersOfTeamLoadControl->pluck( 'id' )->toArray();
            $dates->whereIn( 'user_id', $userIds );
        }
        $dates = $dates->distinct()->pluck( 'date' )->sort()->values();

        // --- Получаем плановые значения load и recovery из тренировки ---
        $userIds   = $usersOfTeamLoadControl->pluck( 'id' )->toArray();
        $datesArr  = $dates->toArray();
        $trainings = \App\Models\Training::query()
                                         ->where( 'team_code', $team->team_code )
                                         ->whereIn( 'date', $datesArr )
                                         ->get()
                                         ->groupBy( [ 'team_code', 'date' ] );

        // Формируем структуру данных
        $results = [];

        foreach ( $usersOfTeamLoadControl as $user ) {
            $userAnswers = $answers->where( 'user_id', $user->id );

            // Calculate daily averages
            $answersPerDate = $userAnswers
                ->groupBy( function ( $item ) {
                    // Group by date only (ignore time)
                    return date( 'Y-m-d', strtotime( $item->created_at ) );
                } )
                ->map( function ( $items ) {
                    // Average all necessary fields
                    return [
                        'recovery' => $items->avg( 'recovery' ),
                        'load'     => $items->avg( 'load' ),
                        'pain'     => $items->avg( 'pain' ),
                        'sleep'    => $items->avg( 'sleep' ),
                        'moral'    => $items->avg( 'moral' ),
                        'physical' => $items->avg( 'physical' ),
                        // add more fields here if required
                    ];
                } );

            $userRow = [];

            foreach ( $dates as $date ) {
                $data = $answersPerDate->get( $date, [
                    'recovery' => null,
                    'load'     => null,
                    'pain'     => 0,
                    'sleep'    => null,
                    'moral'    => null,
                    'physical' => null,
                ] );

                // If no data, there will be nulls; you can handle as you like

                $generalCondition = ( (
                                          (float) $data['recovery'] +
                                          (float) $data['sleep'] +
                                          (float) $data['moral'] +
                                          (float) $data['physical']
                                      ) - (float) $data['pain'] ) / 4;

                // --- Вставляем плановые значения тренировки (если есть) ---
                $plannedLoad     = '';
                $plannedRecovery = '';
                if ( isset( $trainings[ $team->team_code ][ $date ] ) && $trainings[ $team->team_code ][ $date ]->count() > 0 ) {
                    // Take first training of the day (or aggregate if needed)
                    $plan            = $trainings[ $team->team_code ][ $date ]->first();
                    $plannedLoad     = $plan->load;
                    $plannedRecovery = $plan->recovery;
                }
                // -----------------------------------------------------------

                $userRow[ $date ] = [
                    'recovery'          => is_null( $data['recovery'] ) ? '' : round( $data['recovery'] * 10 ),
                    'load'              => is_null( $data['load'] ) ? '' : round( $data['load'] * 10 ),
                    'general-condition' => round( $generalCondition * 10 ),
                    'load_planned'      => $plannedLoad,      // Planned load
                    'recovery_planned'  => $plannedRecovery,  // Planned recovery
                ];
            }

            $results[ $user->id ] = $userRow;
        }

        // Weeks block
        $weeksCount = 52;
        $weeks      = [];
        $start      = Carbon::now()->startOfWeek( Carbon::MONDAY );

        for ( $i = 0; $i < $weeksCount; $i ++ ) {
            $weekStart = $start->copy()->subWeeks( $i ); // Start of the week (Monday)
            $weekEnd   = $weekStart->copy()->endOfWeek( Carbon::SUNDAY ); // End of the week (Sunday)

            // Check if there is any data for this period
            $count = DB::table( 'questions' )
                       ->where( 'team_code', $team->team_code )
                       ->whereBetween( 'created_at', [ $weekStart->toDateString(), $weekEnd->toDateString() ] )
                       ->count();

            if ( $count > 0 ) {
                $year    = $weekStart->format( 'Y' );
                $weekNum = $weekStart->format( 'W' ); // ISO week number

                // Add value and display text
                $weeks[] = [
                    'value' => "{$year}-W{$weekNum}",
                    'label' => "{$weekStart->format('d.m.Y')} - {$weekEnd->format('d.m.Y')}",
                ];
            }
        }

        // week selector (like player_id)
        if ( $request->input( 'week' ) ) {
            $weekInput = $request->input( 'week' );
        } elseif ( $request->cookie( 'week' ) ) {
            $weekInput = $request->cookie( 'week' );
        } elseif ( $request->cookies->get( 'week' ) ) {
            $weekInput = $request->cookies->get( 'week' );
        } elseif ( isset( $_COOKIE['week'] ) ) {
            $weekInput = $_COOKIE['week'];
        } else {
            $weekInput = $weeks[0]['value'] ?? 0;
        }
        // Parse year and week number
        if ( preg_match( '/(\d{4})-W(\d{2})/', $weekInput, $matches ) ) {
            $year = $matches[1];
            $week = $matches[2];

            // Get Monday of selected week
            $startOfWeek    = Carbon::now()->setISODate( $year, $week )->startOfWeek( Carbon::MONDAY );
            $datesForSelect = [];
            for ( $i = 0; $i < 7; $i ++ ) {
                $datesForSelect[] = $startOfWeek->copy()->addDays( $i )->toDateString();
            }
        } else {
            $datesForSelect = [];
        }

        $team_code = $team->team_code;

        // Get records only for needed team_code and date (created_at) from date array
        $records = DB::table( 'questions' )
                     ->join( 'users', 'questions.user_id', '=', 'users.id' )
                     ->where( 'questions.team_code', $team_code )
                     ->where( 'users.active', 1 )
                     ->whereIn( DB::raw( 'DATE(questions.created_at)' ), $datesForSelect )
                     ->select(
                         DB::raw( 'DATE(questions.created_at) as created_at' ),
                         'questions.recovery',
                         'questions.load'
                     )
                     ->get();

        $recoveryAverages = [];
        $loadAverages     = [];

        // Group collection for convenience
        $grouped = $records->groupBy( 'created_at' );

        foreach ( $datesForSelect as $date ) {
            if ( $grouped->has( $date ) ) {
                $group       = $grouped[ $date ];
                $avgRecovery = round( $group->avg( 'recovery' ), 2 );
                $avgLoad     = round( $group->avg( 'load' ), 2 );
            } else {
                $avgRecovery = null; // or 0, depending on desired logic
                $avgLoad     = null;
            }

            $recoveryAverages[] = $avgRecovery;
            $loadAverages[]     = $avgLoad;
        }

        $resultsCycle = [
            'labels'   => [ 'MD-7', 'MD-6', 'MD-5', 'MD-4', 'MD-3', 'MD-2', 'MD-1' ],
            'dates'    => $datesForSelect,
            'load'     => $loadAverages,
            'recovery' => $recoveryAverages,
        ];

        $teamChars = 2;

        $tests = PlayerTest::whereHas( 'user', function ( $query ) use ( $team ) {
            $query->where( 'team_code', $team->team_code );
        } )
                           ->with( 'user' )
                           ->orderBy( 'date_of_test', 'desc' )
                           ->get();

        // 1. Получаем все тесты для данной команды
        // Используем 'with' для жадной загрузки связанного пользователя, чтобы получить его имя.
        // Сортируем по дате теста в порядке возрастания, чтобы потом было удобно выбрать последние.
        $allTeamTests = PlayerTest::whereHas( 'user', function ( $query ) use ( $team ) {
            // Предполагаем, что users.team_code содержит код команды
            // и PlayerTest связан с User через player_id, который является foreign key к users.id
            $query->where( 'team_code', $team->team_code );
        } )
                                  ->with( 'user' )
                                  ->orderBy( 'date_of_test',
                                      'desc' )
                                  ->get();

        // 2. Определяем последние N (например, 3) уникальные даты тестирования по всей команде
        // Сначала собираем все даты, убираем дубликаты, сортируем по убыванию и берем N последние.
        $recentTestDates = $allTeamTests->pluck( 'date_of_test' )
                                        ->unique()
                                        ->sort()
                                        ->take( 3 )
                                        ->values();

        // Преобразуем даты в формат 'YYYY-MM-DD', который используется в коде импорта и удобен для JS
        $formattedRecentTestDates = $recentTestDates->map( function ( $date ) {
            return ( new Carbon( $date ) )->format( 'd.m.Y' );
        } );

        $playerData = [];
        foreach ( $allTeamTests as $test ) {

            // Убедитесь, что у User есть поле 'name'. Если нет, используйте 'id' или другое поле.
            $playerName = nameLastname($test->player_id) ?? 'Игрок ID: ' . $test->player_id;
            $testDate   = ( new Carbon( $test->date_of_test ) )->format( 'd.m.Y' );

            if ( ! isset( $playerData[ $playerName ] ) ) {
                $playerData[ $playerName ] = [];
            }

            // Сохраняем значения метрик для текущего игрока и даты.
            // Если для одного игрока есть несколько тестов в один день, эта логика возьмет последний.
            $playerData[ $playerName ][ $testDate ] = [
                'push_ups'                 => (float) $test->push_ups,
                'pull_ups'                 => (float) $test->pull_ups,
                // Добавьте сюда другие поля из PlayerTest, которые вы хотите отобразить на графиках
                'ten_m'                    => (float) $test->ten_m,
                'twenty_m'                 => (float) $test->twenty_m,
                'thirty_m'                 => (float) $test->thirty_m,
                'long_jump'                => (float) $test->long_jump,
                'vertical_jump_no_hands'   => (float) $test->vertical_jump_no_hands,
                'vertical_jump_with_hands' => (float) $test->vertical_jump_with_hands,
                'illinois_test'            => (float) $test->illinois_test,
                // Продолжите для всех числовых метрик
                'height'                   => (float) $test->height,
                'weight'                   => (float) $test->weight,
                'body_mass_index'          => (float) $test->body_mass_index,
                'pause_one'                => (float) $test->pause_one,
                'pause_two'                => (float) $test->pause_two,
                'pause_three'              => (float) $test->pause_three,
                'step'                     => (float) $test->step,
                'mpk'                      => (float) $test->mpk,
            ];
        }
        // 4. Формируем финальную структуру данных, подходящую для JavaScript библиотеки графиков (например, Chart.js)
        $chartData = [
            'labels'  => array_keys( $playerData ), // Имена игроков будут метками по оси X
            'dates'   => $formattedRecentTestDates->toArray(), // Даты для отображения
            'metrics' => [
                'push_ups'                 => [
                    'title'    => 'Отжимания',
                    'category' => 'Силовые (кол-во)',
                    'unit'     => 'кол-во',
                    'datasets' => [],
                ],
                'pull_ups'                 => [
                    'title'    => 'Подтягивания',
                    'category' => 'Силовые (кол-во)',
                    'unit'     => 'кол-во',
                    'datasets' => [],
                ],
                // Добавьте другие метрики и их категории/единицы измерения
                'ten_m'                    => [
                    'title'    => 'Бег 10 м',
                    'category' => 'Скоростные (t)',
                    'unit'     => 'с',
                    'datasets' => [],
                ],
                'twenty_m'                 => [
                    'title'    => 'Бег 20 м',
                    'category' => 'Скоростные (t)',
                    'unit'     => 'с',
                    'datasets' => [],
                ],
                'thirty_m'                 => [
                    'title'    => 'Бег 30 м',
                    'category' => 'Скоростные (t)',
                    'unit'     => 'с',
                    'datasets' => [],
                ],
                'long_jump'                => [
                    'title'    => 'Прыжок в длину',
                    'category' => 'Скоростно-силовые (см)',
                    'unit'     => 'см',
                    'datasets' => [],
                ],
                'vertical_jump_no_hands'   => [
                    'title'    => 'Прыжок вверх (без рук)',
                    'category' => 'Скоростно-силовые (см)',
                    'unit'     => 'см',
                    'datasets' => [],
                ],
                'vertical_jump_with_hands' => [
                    'title'    => 'Прыжок вверх (с руками)',
                    'category' => 'Скоростно-силовые (см)',
                    'unit'     => 'см',
                    'datasets' => [],
                ],
                'illinois_test'            => [
                    'title'    => 'Тест Иллинойса',
                    'category' => 'Ловкость (t)',
                    'unit'     => 'с',
                    'datasets' => [],
                ],
                'height'                   => [
                    'title'    => 'Рост',
                    'category' => 'Антропометрия (см/кг)',
                    'unit'     => 'см',
                    'datasets' => [],
                ],
                'weight'                   => [
                    'title'    => 'Вес',
                    'category' => 'Антропометрия (см/кг)',
                    'unit'     => 'кг',
                    'datasets' => [],
                ],
                'body_mass_index'          => [
                    'title'    => 'Индекс массы тела',
                    'category' => 'Антропометрия (см/кг)',
                    'unit'     => '',
                    'datasets' => [],
                ],
                'pause_one'                => [
                    'title'    => 'Пауза 1',
                    'category' => 'Скоростная выносливость (t)',
                    'unit'     => 'мс',
                    'datasets' => [],
                ],
                'pause_two'                => [
                    'title'    => 'Пауза 2',
                    'category' => 'Скоростная выносливость (t)',
                    'unit'     => 'мс',
                    'datasets' => [],
                ],
                'pause_three'              => [
                    'title'    => 'Пауза 3',
                    'category' => 'Скоростная выносливость (t)',
                    'unit'     => 'мс',
                    'datasets' => [],
                ],
                'step'                     => [
                    'title'    => 'Шаг',
                    'category' => 'Скоростная выносливость (t)',
                    'unit'     => 'мс',
                    'datasets' => [],
                ],
                'mpk'                      => [
                    'title'    => 'МПК',
                    'category' => 'Скоростная выносливость (t)',
                    'unit'     => 'мл/кг/мин',
                    'datasets' => [],
                ],
            ],
        ];

        // Создаем наборы данных (datasets) для каждой из N дат для каждой метрики
        foreach ( $chartData['metrics'] as $metricKey => &$metricConfig ) {
            foreach ( $formattedRecentTestDates as $date ) {
                $dataset = [
                    'label' => $date, // Метка для этого набора данных будет датой
                    'data'  => [],
                ];

                foreach ( $chartData['labels'] as $playerName ) {
                    // Получаем значение для текущего игрока, текущей даты и текущей метрики
                    // Если данных нет для данной даты/игрока, используем null,
                    // что позволит графической библиотеке корректно отобразить отсутствие данных.
                    $value             = $playerData[ $playerName ][ $date ][ $metricKey ] ?? null;
                    $dataset['data'][] = $value;
                }
                $metricConfig['datasets'][] = $dataset;
            }
        }
        unset( $metricConfig ); // Разрушаем ссылку, чтобы избежать непредвиденных изменений

        // Группируем метрики по категориям для удобного вывода на фронтенде
        $categorizedMetrics = [];
        foreach ( $chartData['metrics'] as $metricKey => $metric ) {
            $category = $metric['category'];
            if ( ! isset( $categorizedMetrics[ $category ] ) ) {
                $categorizedMetrics[ $category ] = [
                    'title'   => $category,
                    'metrics' => [],
                ];
            }
            $categorizedMetrics[ $category ]['metrics'][ $metricKey ] = $metric;
        }

        return view( 'teams.team',
            compact(
                'team',
                'datesForSelect',
                'usersOfTeam',
                'usersOfTeamLoadControl',
                'dates',
                'results',
                'teamChars',
                'weeks',
                'resultsCycle',
                'tests',
                'chartData',
                'categorizedMetrics',
                'team',
            )
        );
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Team $team ) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public
    function update(
        Request $request,
        Team $team
    ) {

        $team->update( [
            'name'   => $request->team_name,
            'desc'   => $request->desc,
            'active' => $request->active,
        ] );

        return response()->json( [ 'code' => 200, 'success' => 'Запись успешно создана', 'data' => $team ], 200 );
    }

    /**
     * Remove the specified resource from storage.
     */
    public
    function destroy(
        Team $team
    ) {
        $teamCode           = $team->team_code;
        $allPlayersThisTeam = User::where( 'team_code', $teamCode )->get();

        // при удалении команды удаляем все тренировки этой команды
        Training::where( 'team_code', $teamCode )->delete();

        // при удалении команды удаляем всю статистику присутствия на тренировках этой команды
        PresenceTraining::where( 'team_code', $teamCode )->delete();

        // при удалении команды все игроки этой команды деактивируются
        foreach ( $allPlayersThisTeam as $player ) {
            $player->update( [
                'active'    => 0,
                'team_code' => '000-000',
            ] );
        }

        $team->delete();

        return redirect()->route( 'teams.index' )->with( 'success', __( 'messages.Команда удалена' ) );

    }
}
