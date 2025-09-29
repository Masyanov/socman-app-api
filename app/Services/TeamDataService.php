<?php

namespace App\Services;

use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TeamDataService {
    public function getFilteredData(Team $team, ?string $weekSelectDetail, ?string $playerId): array {
        $dateFrom = $dateFrom ?? Carbon::now()->subWeek()->format('Y-m-d');
        $dateTo   = $dateTo   ?? Carbon::now()->format('Y-m-d');
        $weekInput = $weekSelectDetail;

        // Parse year and week number from weekInput and build datesForSelect
        $datesForSelect = [];
        if ( $weekInput && preg_match( '/(\d{4})-W(\d{2})/', $weekInput, $matches ) ) {
            $year = (int) $matches[1];
            $week = (int) $matches[2];

            // Get Monday of that ISO week
            $startOfWeek = Carbon::now()->setISODate( $year, $week )->startOfWeek( Carbon::MONDAY );
            // Build array of dates for that week (Monday..Sunday)
            for ( $i = 0; $i < 7; $i ++ ) {
                $datesForSelect[] = $startOfWeek->copy()->addDays( $i )->toDateString();
            }
        }

        $query = User::where('team_code', $team->team_code)->where('active', true);

        if ($playerId) {
            $query->where('id', $playerId);
        }

        $users = $query->get();

        if ($users->isEmpty()) {
            return [
                'results' => [],
                'dates' => [],
                'users' => [],
            ];
        }

        $userIds = $users->pluck('id')->toArray();

        $answers = DB::table('questions')
                     ->whereIn( DB::raw( 'DATE(questions.created_at)' ), $datesForSelect )
                     ->whereIn('user_id', $userIds)
                     ->get();

        $dates = DB::table('questions')
                   ->selectRaw('DATE(created_at) as date')
                   ->whereIn( DB::raw( 'DATE(questions.created_at)' ), $datesForSelect )
                   ->whereIn('user_id', $userIds)
                   ->distinct()
                   ->pluck('date')
                   ->sort()
                   ->values();

        $results = [];

        if ($playerId) {
            // Если выбран конктретный игрок
            $user = $users->first();
            $userAnswers = $answers->where('user_id', $user->id);

            $userRow = [];
            foreach ($dates as $date) {
                $dayAnswers = $userAnswers->filter(fn($item) => date('Y-m-d', strtotime($item->created_at)) === $date);

                $recovery = (int)($dayAnswers->pluck('recovery')->first() ?? 0);
                $load     = (int)($dayAnswers->pluck('load')->first() ?? 0);
                $pain     = (int)($dayAnswers->pluck('pain')->first() ?? 0);
                $sleep    = (int)($dayAnswers->pluck('sleep')->first() ?? 0);
                $moral    = (int)($dayAnswers->pluck('moral')->first() ?? 0);
                $physical = (int)($dayAnswers->pluck('physical')->first() ?? 0);

                $generalCondition = (($recovery + $sleep + $moral + $physical) - $pain) / 4;

                $userRow[$date] = [
                    'recovery' => $recovery * 10,
                    'load'     => $load * 10,
                    'pain'     => $pain * 10,
                    'sleep'    => $sleep * 10,
                    'moral'    => $moral * 10,
                    'physical' => $physical * 10,
                    'general_condition' => $generalCondition * 10,
                ];
            }

            $results[$user->last_name] = $userRow;
        } else {
            // Данные по каждому игроку
            foreach ($users as $user) {
                $userAnswers = $answers->where('user_id', $user->id);

                $userRow = [];
                foreach ($dates as $date) {
                    $dayAnswers = $userAnswers->filter(fn($item) => date('Y-m-d', strtotime($item->created_at)) === $date);

                    $recovery = (int)($dayAnswers->pluck('recovery')->first() ?? 0);
                    $load     = (int)($dayAnswers->pluck('load')->first() ?? 0);
                    $pain     = (int)($dayAnswers->pluck('pain')->first() ?? 0);
                    $sleep    = (int)($dayAnswers->pluck('sleep')->first() ?? 0);
                    $moral    = (int)($dayAnswers->pluck('moral')->first() ?? 0);
                    $physical = (int)($dayAnswers->pluck('physical')->first() ?? 0);

                    $generalCondition = (($recovery + $sleep + $moral + $physical) - $pain) / 4;

                    $userRow[$date] = [
                        'recovery' => $recovery * 10,
                        'load'     => $load * 10,
                        'pain'     => $pain * 10,
                        'sleep'    => $sleep * 10,
                        'moral'    => $moral * 10,
                        'physical' => $physical * 10,
                        'general_condition' => $generalCondition * 10,
                    ];
                }
                $results[$user->last_name] = $userRow;
            }

            // Средние значения по команде за каждый день
            foreach ($dates as $date) {
                $dayAnswers = $answers->filter(fn($item) => date('Y-m-d', strtotime($item->created_at)) === $date);

                $count = max($dayAnswers->count(), 1);

                $recovery = (float)$dayAnswers->sum('recovery') / $count;
                $load     = (float)$dayAnswers->sum('load') / $count;
                $pain     = (float)$dayAnswers->sum('pain') / $count;
                $sleep    = (float)$dayAnswers->sum('sleep') / $count;
                $moral    = (float)$dayAnswers->sum('moral') / $count;
                $physical = (float)$dayAnswers->sum('physical') / $count;

                $generalCondition = (($recovery + $sleep + $moral + $physical) - $pain) / 4;

                $results['Среднее по каманде'][$date] = [
                    'recovery' => round($recovery * 10, 2),
                    'load'     => round($load * 10, 2),
                    'pain'     => round($pain * 10, 2),
                    'sleep'    => round($sleep * 10, 2),
                    'moral'    => round($moral * 10, 2),
                    'physical' => round($physical * 10, 2),
                    'general_condition' => round($generalCondition * 10, 2),
                ];
            }
        }

        return compact('results', 'dates', 'users');
    }
}
