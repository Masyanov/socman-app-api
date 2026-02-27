<?php

use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\AIAnalyzeController;
use App\Http\Controllers\AjaxFilterController;
use App\Http\Controllers\AjaxFilterCharsController;
use App\Http\Controllers\AjaxPlayerCondition;
use App\Http\Controllers\AttendanceCalendarController;
use App\Http\Controllers\AchievementSelectionController;
use App\Http\Controllers\AchievementSettingsController;
use App\Http\Controllers\DockerBotController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\LoadControl;
use App\Http\Controllers\LoadControlController;
use App\Http\Controllers\PlayerTestController;
use App\Http\Controllers\PlayerTestImportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionOrderController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TimeForQuestionsController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get( '/', function () {
    return view( 'welcome' );
} );

Route::get( '/oferta', function () {
    return view( 'oferta' );
} );
Route::get( '/policy', function () {
    return view( 'policy' );
} );
Route::get( '/rules', function () {
    return view( 'rules' );
} );

Route::get( 'locale/{locale}', function ( $locale ) {
    Session::put( 'locale', $locale );

    return redirect()->back();
} )->name( 'locale' );

Route::get( '/dashboard', function () {
    return view( 'dashboard' );
} )->middleware( [ 'auth', 'verified' ] )->name( 'dashboard' );

Route::middleware( 'auth' )->group( function () {
    Route::get( '/profile', [ ProfileController::class, 'edit' ] )->name( 'profile.edit' );
    Route::patch( '/profile', [ ProfileController::class, 'update' ] )->name( 'profile.update' );
    Route::delete( '/profile', [ ProfileController::class, 'destroy' ] )->name( 'profile.destroy' );

    Route::get( '/trainings', [ TrainingController::class, 'index' ] )->name( 'trainings.index' );
} );
Route::patch( '/users/{id}/update-active-player', [ UserController::class, 'updateActive' ] )->name( 'users.updateActive' );

Route::group( [ 'middleware' => [ 'auth', 'coach' ] ], function () {
    Route::get( '/users', [ UserController::class, 'index' ] )->name( 'users.index' );
    Route::post( '/users', [ UserController::class, 'store' ] )->name( 'users.store' );
    Route::patch( '/users/{id}', [ UserController::class, 'update' ] )->name( 'users.update' );
    Route::get( '/users/{user}', [ UserController::class, 'show' ] )->name( 'users.show' );
    Route::delete( '/users/{user}', [ UserController::class, 'destroy' ] )->name( 'users.destroy' );

    Route::get( '/teams', [ TeamController::class, 'index' ] )->name( 'teams.index' );
    Route::post( '/teams', [ TeamController::class, 'store' ] )->name( 'teams.store' );
    Route::get( '/teams/{team}', [ TeamController::class, 'show' ] )->name( 'teams.show' );

    Route::post( '/teams/{team}', [ AjaxFilterController::class, 'ajaxFilter' ] )->name( 'ajax.show' );

    Route::post( '/teams/{team}/filter-chars',
        [ AjaxFilterCharsController::class, 'ajaxCharsFilter' ] )->name( 'ajaxchars.show' );

    Route::post( '/ajax/get-player-condition',
        [ AjaxPlayerCondition::class, 'ajaxCondition' ] )->name( 'condition.show' );

    Route::post( 'ai-analyze', [ AIAnalyzeController::class, 'analyze' ] );

    Route::patch( '/teams/{team}', [ TeamController::class, 'update' ] )->name( 'teams.update' );
    Route::delete( '/teams/{team}', [ TeamController::class, 'destroy' ] )->name( 'teams.destroy' );

    Route::get( '/teams/{team}/players', [ TestController::class, 'getPlayersForTeam' ] )->name( 'teams.players' );

    Route::post( '/trainings', [ TrainingController::class, 'store' ] )->name( 'trainings.store' );

    Route::get( '/trainings/{training}', [ TrainingController::class, 'show' ] )->name( 'trainings.show' );
    Route::patch( '/trainings/{training}', [ TrainingController::class, 'update' ] )->name( 'trainings.update' );
    Route::delete( '/trainings/{training}', [ TrainingController::class, 'destroy' ] )->name( 'trainings.destroy' );
    Route::post( '/trainings/settings', [ TrainingController::class, 'settings' ] )->name( 'trainings.settings' );

    Route::post( '/trainings/addresses', [ TrainingController::class, 'addressesTrainings' ] )->name( 'trainings.addresses' );

    Route::delete( '/trainings/addresses/{address}',[ TrainingController::class, 'deleteAddressesTrainings' ] )->name( 'trainings.addresses.destroy' );
    Route::delete( '/trainings/class/{class}', [ TrainingController::class, 'deleteClassTraining' ] )->name( 'class.destroy' );

    Route::get( '/tests', [ TestController::class, 'index' ] )->name( 'tests.index' );
    Route::post( '/tests', [ TestController::class, 'store' ] )->name( 'tests.store' );
    Route::delete( '/tests/{test}', [ TestController::class, 'destroy' ] )->name( 'tests.destroy' );
    Route::get( '/tests/{test}', [ TestController::class, 'show' ] )->name( 'tests.show' );
    Route::patch( '/tests/{test}', [ TestController::class, 'update' ] )->name( 'tests.update' );

    Route::get( '/attendance/calendar',
        [ AttendanceCalendarController::class, 'index' ] )->name( 'attendance.calendar' );

    Route::get( '/calendar',
        [ TrainingController::class, 'calendar' ] )->name( 'calendar' );

    Route::resource('player-tests', PlayerTestController::class);

    Route::get('/admin/tests/import', [PlayerTestImportController::class, 'create'])->name('admin.tests.import.create');
    Route::post('/admin/tests/import', [PlayerTestImportController::class, 'store'])->name('admin.tests.import.store');

    Route::get('/export/testing-form/{teamCode}', [ExportController::class, 'exportTestingForm'])
         ->name('export.testing_form')
         ->where('teamCode', '[a-zA-Z0-9_-]+');

    Route::get('/admin/players_info/{id}', [UserController::class, 'getPlayerInfo'])->name('players.getPlayerInfo');

    Route::get('/achievements', [AchievementSelectionController::class, 'index'])->name('achievements.index');
    Route::post('/achievements', [AchievementSelectionController::class, 'update'])->name('achievements.update');

    // Маршрут для отображения формы выбора типов достижений
    Route::get('/achievements/settings', [AchievementSettingsController::class, 'edit'])
         ->name('achievements.settings.edit');

    // Маршрут для сохранения выбранных типов достижений
    Route::post('/achievements/settings', [AchievementSettingsController::class, 'update'])
         ->name('achievements.settings.update');

} );

Route::group( [ 'middleware' => [ 'auth','super-admin' ] ], function () {
    Route::patch( '/users/{id}/update-ai', [ UserController::class, 'updateAI' ] )->name( 'users.updateAI' );
    Route::patch( '/users/{id}/update-load_control',
        [ UserController::class, 'updateLoadControl' ] )->name( 'users.updateLoadControl' );

    Route::post('/docker-bot/stop',   [DockerBotController::class, 'stop']);
    Route::post('/docker-bot/remove', [DockerBotController::class, 'remove']);
    Route::post('/docker-bot/restart',  [DockerBotController::class, 'restart']);
    Route::post('/docker-bot/run',    [DockerBotController::class, 'run']);
    Route::get('/docker-bot/status',  [DockerBotController::class, 'status']);
} );

Route::group( [ 'middleware' => [ 'auth', 'coach', 'loadcontrol' ] ], function () {
    Route::get( '/loadcontrol', [ LoadControl::class, 'index' ] )->name( 'loadcontrol.index' );
    Route::patch( '/loadcontrol', [ LoadControl::class, 'update' ] )->name( 'loadcontrol.update' );
    Route::get( '/loadcontrol/filter', [ LoadControl::class, 'filter' ] )->name( 'loadcontrol.filter' );
} );

Route::get( '/time', [ TimeForQuestionsController::class, 'index' ] );

Route::group( [ 'middleware' => [ 'auth', 'coach', 'loadcontrol' ] ], function () {
    Route::get( '/questions', [ LoadControlController::class, 'index' ] )->name( 'questions.index' );
} );

Route::post( '/questions', [ LoadControlController::class, 'store' ] )->name( 'questions.store' );
Route::patch( '/questions', [ LoadControlController::class, 'update' ] )->name( 'questions.update' );
Route::delete( '/questions/{training}', [ LoadControlController::class, 'destroy' ] )->name( 'questions.destroy' );


Route::group( [ 'middleware' => [ 'auth', 'super-admin' ] ], function () {
    Route::get( '/loginAsUser/{id}', function ( $id ) {
        if ( ! session()->has( 'super-admin' ) ) {
            session( [ 'super-admin' => Auth::id() ] );
        }
        Auth::loginUsingId( $id );

        return redirect()->back();
    } );


    Route::get( '/subscriptions', [ SubscriptionController::class, 'index' ] )->name( 'subscriptions.index' );
    Route::patch( '/subscriptions/{id}', [ SubscriptionController::class, 'update' ] )->name( 'subscriptions.update' );
    Route::delete( '/subscriptions/{id}',
        [ SubscriptionController::class, 'destroy' ] )->name( 'subscriptions.destroy' );
} );

Route::group( [ 'middleware' => [ 'auth', 'admin' ] ], function () {
    Route::delete( '/users/{id}/delete-coach',
        [ UserController::class, 'destroyCoach' ] )->name( 'users.destroyCoach' );
    Route::get( '/adminLoginAsUser/{id}', function ( $id ) {
        $admin = Auth::user();
        $trainer = $admin->coaches()->find($id);

        if (!$trainer) {
            abort(403, 'Нет доступа к этому тренеру');
        }

        if (!session()->has('impersonate')) {
            session(['impersonate' => $admin->id]);
        }

        Auth::guard('web')->loginUsingId($id);

        session()->regenerate();

        return redirect()->route('dashboard');
    });
});

Route::get( '/impersonate/leave', function () {
    if ( session()->has( 'impersonate' ) ) {
        $adminId = session( 'impersonate' );
        Auth::guard('web')->loginUsingId( $adminId );
        session()->forget( 'impersonate' );
        session()->regenerate();
    }

    return redirect( '/dashboard' );
} )->name( 'impersonate.leave' );

Route::get( '/go-to-super-admin', function () {
    if ( session()->has( 'super-admin' ) ) {
        // Return back to original admin user
        $adminId = session( 'super-admin' );
        Auth::loginUsingId( 1 );
        session()->forget( 'super-admin' );
    }

    return redirect( '/dashboard' );
} )->name( 'go' );


Route::post( '/subscription-order',
    [ SubscriptionOrderController::class, 'store' ] )->name( 'subscription-order.store' );

require __DIR__ . '/auth.php';
