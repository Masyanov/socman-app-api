<?php

namespace App\Services;

use App\Models\ClassTraining;
use App\Models\AddressesTraining;
use App\Models\Training;
use App\Models\PresenceTraining;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Team;

class TrainingService {
    /**
     * Create a training (single or with weekly repeats)
     *
     * @param  array  $data  Validated data from request
     * @param  int  $userId  User ID
     *
     * @return Training
     */
    public function createTraining( array $data, int $userId ): Training {
        $repeat          = ! empty( $data['repeat_until_checkbox'] );
        $repeatUntilDate = isset( $data['repeat_until_date'] ) ? Carbon::parse( $data['repeat_until_date'] ) : null;
        $startDate       = Carbon::parse( $data['date'] );

        $firstTraining = Training::create( [
            'user_id'       => $userId,
            'count_players' => $data['count_players'] ?? 0,
            'team_code'     => $data['team_code'],
            'date'          => $data['date'],
            'start'         => $data['start'],
            'finish'        => $data['finish'],
            'class'         => $data['class'] ?? null,
            'addresses'     => $data['addresses'] ?? null,
            'desc'          => $data['desc'] ?? null,
            'recovery'      => $data['recovery'] ?? 0,
            'load'          => $data['load'] ?? 0,
            'link_docs'     => $data['link_docs'] ?? null,
            'active'        => $data['active'] ?? true,
        ] );

        Log::debug( 'Training created for team ' . $data['team_code'] );

        if ( $repeat && $repeatUntilDate && $repeatUntilDate->gt( $startDate ) ) {
            $this->createRepeatedTrainings( $userId, $data, $startDate, $repeatUntilDate );
        }

        return $firstTraining;
    }

    /**
     * Create weekly repeated trainings
     */
    protected function createRepeatedTrainings(
        int $userId,
        array $data,
        Carbon $startDate,
        Carbon $repeatUntilDate
    ): void {
        $currentDate = $startDate->copy()->addWeek();

        while ( $currentDate->lte( $repeatUntilDate ) ) {
            Training::create( [
                'user_id'       => $userId,
                'count_players' => $data['count_players'] ?? 0,
                'team_code'     => $data['team_code'],
                'date'          => $currentDate->format( 'Y-m-d' ),
                'start'         => $data['start'],
                'finish'        => $data['finish'],
                'class'         => $data['class'] ?? null,
                'addresses'     => $data['addresses'] ?? null,
                'desc'          => $data['desc'] ?? null,
                'recovery'      => $data['recovery'] ?? 0,
                'load'          => $data['load'] ?? 0,
                'link_docs'     => $data['link_docs'] ?? null,
                'active'        => $data['active'] ?? true,
            ] );
            $currentDate->addWeek();
        }
    }

    /**
     * Update training and its presences
     */
    public function updateTraining( int $trainingId, array $data ): ?Training {
        $training = Training::find( $trainingId );

        if ( ! $training ) {
            return null;
        }

        $training->update( [
            'count_players' => $data['count_players'] ?? $training->count_players,
            'team_code'     => $data['team_code'] ?? $training->team_code,
            'date'          => $data['date'] ?? $training->date,
            'start'         => $data['start'] ?? $training->start,
            'finish'        => $data['finish'] ?? $training->finish,
            'class'         => $data['class'] ?? $training->class,
            'addresses'     => $data['addresses'] ?? $training->addresses,
            'desc'          => $data['desc'] ?? $training->desc,
            'recovery'      => $data['recovery'] ?? $training->recovery,
            'load'          => $data['load'] ?? $training->load,
            'link_docs'     => $data['link_docs'] ?? $training->link_docs,
            'active'        => $data['active'] ?? $training->active,
            'confirmed'     => $data['confirmed'] ?? $training->confirmed,
        ] );

        $this->updatePresence( $trainingId, $data['users'] ?? [], $training->team_code );

        Log::debug( 'Training updated for team ' . $training->team_code );

        return $training;
    }

    /**
     * Update training presences
     */
    protected function updatePresence( int $trainingId, array $userIds, string $teamCode ): void {
        // English: Remove old presences (soft delete if using SoftDeletes, else physical delete)
        PresenceTraining::where( 'training_id', $trainingId )->delete();

        // Batch insert new presences
        if ( ! empty( $userIds ) ) {
            $insertData = [];
            foreach ( $userIds as $userId ) {
                $insertData[] = [
                    'training_id' => $trainingId,
                    'user_id'     => $userId,
                    'team_code'   => $teamCode,
                ];
            }
            DB::table( 'presence_trainings' )->insert( $insertData );
        }
    }

    /**
     * Delete training and its presences physically (handling SoftDeletes)
     *
     * @param  int  $trainingId
     *
     * @return bool
     */
    public function deleteTraining( int $trainingId ): bool {
        // English: Start DB transaction to guarantee atomicity
        return DB::transaction( function () use ( $trainingId ) {
            $training = Training::find( $trainingId );
            if ( ! $training ) {
                return false;
            }

            // English: Log presences before deleting for debugging
            Log::debug( 'Presences before delete', [
                'rows' => $training->presences()->withTrashed()->get()->toArray()
            ] );

            // English: Physically remove all (even soft-deleted) presences for this training
            $training->presences()->withTrashed()->forceDelete();

            // English: Soft-delete the training itself (or use forceDelete if Training model also needs hard delete)
            $training->delete();

            return true;
        } );
    }

    /**
     * Get user's trainings with pagination
     */
    public function getTrainingsByUser( int $userId, int $perPage = 120 ) {
        return Training::where( 'user_id', $userId )
                       ->latest( 'date' )
                       ->paginate( $perPage );
    }

    /**
     * Get trainings by team_code with pagination
     */
    public function getTrainingsByTeamCode( string $teamCode, int $perPage = 120 ) {
        return Training::where( 'team_code', $teamCode )
                       ->latest( 'date' )
                       ->paginate( $perPage );
    }

    /**
     * Get single training by ID and user ID
     */
    public function getTrainingByIdAndUser( $id, int $userId ): ?Training {
        return Training::where( 'id', $id )
                       ->where( 'user_id', $userId )
                       ->first();
    }

    /**
     * Get trainings for calendar in given period
     */
    public function getTrainingsForCalendar( ?string $start, ?string $end ): array {
        $query = Training::query();

        if ( $start && $end ) {
            $query->whereBetween( 'date', [ $start, $end ] );
        } elseif ( $start ) {
            $query->where( 'date', $start );
        }

        $trainings = $query->get();

        $result = [];

        foreach ( $trainings as $t ) {
            $team    = Team::where( 'team_code', $t->team_code )->first();
            $class   = ClassTraining::where( 'id', $t->class )->first();
            $address = AddressesTraining::where( 'id', $t->addresses )->first();

            $result[] = [
                'id'            => $t->id,
                'address'       => $address->name ?? null,
                'class'         => $class->name ?? null,
                'team_name'     => $team->name ?? null,
                'count_players' => $t->count_players ?? null,
                'confirmed'     => $t->confirmed,
                'date'          => $t->date,
                'start'         => $t->start,
                'finish'        => $t->finish,
                'desc'          => $t->desc,
                'load'          => $t->load,
                'recovery'      => $t->recovery,
            ];
        }

        return $result;
    }
}
