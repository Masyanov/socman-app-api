<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\TrainingService;
use App\Models\Training;
use App\Models\Team;
use Carbon\Carbon;

class TrainingServiceTest extends TestCase {
    use RefreshDatabase;

    // Refresh DB before each test

    protected TrainingService $service;
    protected int $userId;
    protected Team $team;

    protected function setUp(): void {
        parent::setUp();

        // Create service instance
        $this->service = new TrainingService();

        // Create fake user and team
        $this->userId = 1; // In test DB you can use just number or factory
        $this->team   = Team::factory()->create( [
            'team_code' => '988-988',
            'name'      => 'Test Team',
        ] );
    }

    /** @test */
    public function it_creates_single_training() {
        $data = [
            'team_code'     => $this->team->team_code,
            'date'          => '2025-09-20',
            'class'         => 'main',
            'addresses'     => 'Test address',
            'start'         => '10:00',
            'finish'        => '11:30',
            'count_players' => 10,
        ];

        $training = $this->service->createTraining( $data, $this->userId );

        $this->assertDatabaseHas( 'trainings', [
            'id'            => $training->id,
            'team_code'     => '988-988',
            'class'         => 'main',
            'addresses'     => 'Test address',
            'count_players' => 10,
        ] );
    }

    /** @test */
    public function it_creates_repeated_trainings() {
        $data = [
            'team_code'             => $this->team->team_code,
            'date'                  => '2025-09-20',
            'start'                 => '10:00',
            'finish'                => '11:30',
            'class'         => 'main',
            'addresses'     => 'Test address',
            'count_players'         => 8,
            'repeat_until_checkbox' => true,
            'repeat_until_date'     => '2025-10-11', // +3 недели
        ];

        $this->service->createTraining( $data, $this->userId );

        // First + 3 repeats = 4 entries total
        $this->assertCount( 4, Training::all() );
    }

    /** @test */
    public function it_updates_training() {
        $training = Training::factory()->create( [
            'team_code'     => $this->team->team_code,
            'user_id'       => $this->userId,
            'count_players' => 5,
        ] );

        $updateData = [
            'count_players' => 15,
            'team_code'     => $this->team->team_code,
            'users'         => [ 2, 3 ]
        ];

        $this->service->updateTraining( $training->id, $updateData );

        $this->assertDatabaseHas( 'trainings', [
            'id'            => $training->id,
            'count_players' => 15,
        ] );

        $this->assertDatabaseHas( 'presence_trainings', [
            'training_id' => $training->id,
            'user_id'     => 2,
        ] );
    }

    /** @test */
    public function it_deletes_training_and_presences() {
        $training = Training::factory()->create( [
            'team_code' => $this->team->team_code,
            'user_id'   => $this->userId,
            'class'         => 'main',
            'addresses'     => 'Test address',
        ] );

        // Add presence
        $this->service->updateTraining( $training->id, [
            'team_code' => $this->team->team_code,
            'users'     => [ 2 ]
        ] );

        $this->assertDatabaseHas( 'presence_trainings', [
            'training_id' => $training->id,
        ] );

        $this->service->deleteTraining( $training->id );

        $this->assertDatabaseMissing( 'trainings', [ 'id' => $training->id ] );
        $this->assertDatabaseMissing( 'presence_trainings', [ 'training_id' => $training->id ] );
    }

    /** @test */
    public function it_returns_trainings_for_calendar() {
        Training::factory()->create( [
            'team_code' => $this->team->team_code,
            'user_id'   => $this->userId,
            'date'      => Carbon::now()->toDateString(),
        ] );

        $result = $this->service->getTrainingsForCalendar(
            Carbon::now()->subDay()->toDateString(),
            Carbon::now()->addDay()->toDateString()
        );

        $this->assertNotEmpty( $result );
        $this->assertArrayHasKey( 'team_name', $result[0] );
    }
}
