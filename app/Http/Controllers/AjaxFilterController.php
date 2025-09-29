<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Team;
use App\Models\Training;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AjaxFilterController extends Controller {
    public function ajaxFilter( Request $request, Team $team ) {
        $today         = Carbon::now();
        $formattedDate = $today->format( 'Y-m-d' );

        // Number of weeks to look back (e.g., 52 = year)
        $weeksCount = 52;
        $weeks      = [];
        $start      = Carbon::now()->startOfWeek( Carbon::MONDAY );

        // Build weeks array based on presence of questions
        for ( $i = 0; $i < $weeksCount; $i ++ ) {
            $weekStart = $start->copy()->subWeeks( $i ); // Start of week (Monday)
            $weekEnd   = $weekStart->copy()->endOfWeek( Carbon::SUNDAY ); // End of week (Sunday)

            // Check if there are records in this period
            $count = DB::table( 'questions' )
                       ->where( 'team_code', $team->team_code )
                       ->whereBetween( 'created_at', [ $weekStart->toDateString(), $weekEnd->toDateString() ] )
                       ->count();

            if ( $count > 0 ) {
                $year    = $weekStart->format( 'Y' );
                $weekNum = $weekStart->format( 'W' ); // ISO week number

                // Form value and label
                $weeks[] = [
                    'value' => "{$year}-W{$weekNum}",
                    'label' => "{$weekStart->format('d.m.Y')} - {$weekEnd->format('d.m.Y')}",
                ];
            }
        }

        // Determine week_detail: prefer non-empty request input, otherwise cookie, otherwise default
        $cookieName    = 'week_detail';
        $setWeekCookie = false;

        // Get cookie value (may be null)
        $cookieWeekValue = $request->cookie( $cookieName );
        $cookieWeekValue = ( $cookieWeekValue === null || $cookieWeekValue === '' ) ? null : $cookieWeekValue;

        if ( $request->filled( 'week_detail' ) ) {
            // Use request parameter if it is present and not empty
            $weekInput = $request->input( 'week_detail' );
        } elseif ( $cookieWeekValue !== null ) {
            // Fallback to cookie if present and not empty
            $weekInput = $cookieWeekValue;
        } else {
            // Final fallback: first available week (if any)
            $weekInput = $weeks[0]['value'] ?? null;
            // Mark to set cookie in response so browser will remember this selection
            if ( $weekInput !== null ) {
                $setWeekCookie = true;
            }
        }

        // Determine player_id similarly (prefer request > cookie > default '')
        $playerCookieName  = 'player_id';
        $cookiePlayerValue = $request->cookie( $playerCookieName );
        $cookiePlayerValue = ( $cookiePlayerValue === null || $cookiePlayerValue === '' ) ? null : $cookiePlayerValue;

        if ( $request->filled( 'player_id' ) ) {
            $playerId = $request->input( 'player_id' );
        } elseif ( $cookiePlayerValue !== null ) {
            $playerId = $cookiePlayerValue;
        } else {
            $playerId = '';
            // Not setting cookie for player_id automatically; change if you want same behavior
        }

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

        $user = Auth::user();
        if ( ! $user ) {
            abort( 403, 'Unauthorized' );
        }

        $team = Team::where( 'id', $team->id )->where( 'user_id', $user->id )->firstOrFail();

        $team_code = $team->team_code;

        // Get active users of the team
        $usersOfTeamQuery = User::query()
                                ->where( 'team_code', $team_code )
                                ->where( 'active', 1 )
                                ->latest( 'created_at' );

        if ( $playerId ) {
            $usersOfTeamQuery->where( 'id', $playerId );
        }

        $usersOfTeamLoadControl = $usersOfTeamQuery->get();

        $userIds = $usersOfTeamLoadControl->pluck( 'id' )->toArray();

        // Query answers (questions) filtered by dates and users
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
                          ->whereIn( DB::raw( 'DATE(questions.created_at)' ), $datesForSelect )
                          ->whereIn( 'user_id', $userIds );

        $answers = $answersQuery->get();

        // Dates: questions with active users and required dates
        $datesQuery = DB::table( 'questions' )
                        ->join( 'users', 'questions.user_id', '=', 'users.id' )
                        ->where( 'questions.team_code', $team_code )
                        ->where( 'users.active', 1 )
                        ->whereIn( DB::raw( 'DATE(questions.created_at)' ), $datesForSelect );

        if ( $playerId ) {
            $datesQuery->where( 'user_id', $playerId );
        } else {
            $datesQuery->whereIn( 'user_id', $userIds );
        }

        $dates = $datesQuery->get();

        // Build array for trainings whereIn
        $datesArr = $dates->pluck( 'created_at' )->map( function ( $date ) {
            return date( 'Y-m-d', strtotime( $date ) );
        } )->unique()->toArray();

        // Get planned load/recovery from trainings
        $trainings = Training::query()
                             ->where( 'team_code', $team_code )
                             ->whereIn( 'date', $datesForSelect )
                             ->get()
                             ->groupBy( 'date' );


        $results = [];

        foreach ( $usersOfTeamLoadControl as $user ) {
            $userAnswers = $answers->where( 'user_id', $user->id );

            // Group answers by date (Y-m-d)
            $answersPerDate = $userAnswers
                ->groupBy( function ( $item ) {
                    return date( 'Y-m-d', strtotime( $item->created_at ) );
                } )
                ->map( function ( $items ) {
                    return [
                        'recovery' => $items->avg( 'recovery' ),
                        'load'     => $items->avg( 'load' ),
                        'pain'     => $items->avg( 'pain' ),
                        'sleep'    => $items->avg( 'sleep' ),
                        'moral'    => $items->avg( 'moral' ),
                        'physical' => $items->avg( 'physical' ),
                    ];
                } );

            $userRow = [];

            // Iterate over week dates
            foreach ( $datesForSelect as $date ) {
                $data = $answersPerDate->get( $date, [
                    'recovery' => null,
                    'load'     => null,
                    'pain'     => 0,
                    'sleep'    => null,
                    'moral'    => null,
                    'physical' => null,
                ] );

                $generalCondition = (
                                        ( (float) $data['recovery'] +
                                          (float) $data['sleep'] +
                                          (float) $data['moral'] +
                                          (float) $data['physical'] )
                                        - (float) $data['pain']
                                    ) / 4;

                $plannedLoad     = '';
                $plannedRecovery = '';
                if ( $trainings->has( $date ) && $trainings[ $date ]->count() > 0 ) {
                    $plan            = $trainings[ $date ]->first();
                    $plannedLoad     = $plan->load;
                    $plannedRecovery = $plan->recovery;
                } else {
                    $plannedLoad     = '';
                    $plannedRecovery = '';
                }

                $userRow[ $date ] = [
                    'recovery'          => is_null( $data['recovery'] ) ? '' : round( $data['recovery'] * 10 ),
                    'load'              => is_null( $data['load'] ) ? '' : round( $data['load'] * 10 ),
                    'general-condition' => round( $generalCondition * 10 ),
                    'load_planned'      => $plannedLoad,
                    'recovery_planned'  => $plannedRecovery,
                ];
            }

            $results[ $user->id ] = $userRow;
        }

        // Render HTML
        $html = view( 'partials.data_table',
            compact( 'team', 'usersOfTeamLoadControl', 'datesForSelect', 'results' ) )->render();

        // If needed, attach cookie to response so browser will save week_detail
        if ( $setWeekCookie && $weekInput !== null ) {
            // Set cookie for 30 days (minutes)
            $minutes = 60 * 24 * 30;

            return response( $html )->cookie( $cookieName, $weekInput, $minutes, '/' );
        }

        // Otherwise return simple response
        return response( $html );
    }
}
