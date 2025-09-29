<?php

use App\Http\Controllers\Api\QuestionnaireController;
use App\Http\Controllers\Api\TelegramLoginController;
use App\Http\Controllers\Api\TelegramRegisterController;
use App\Http\Controllers\Api\TelegramTeamController;
use App\Http\Controllers\Api\TelegramTrainingsController;
use App\Http\Controllers\DockerBotController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/ai/analyze', [TeamController::class, 'generate'])->name('ai.analyze');
Route::post('/register', [TelegramRegisterController::class, 'register']);
Route::post('/login', [TelegramLoginController::class, 'login']);

Route::get('/trainings', [TelegramTrainingsController::class, 'trainings']);

Route::get('/trainings-notify', [TelegramTrainingsController::class, 'trainingsNotify']);
Route::get('/after-trainings-notify', [TelegramTrainingsController::class, 'afterTrainingPollNotify']);
Route::post('/trainings-notify/{training_id}', [TelegramTrainingsController::class, 'markSent']);
Route::post('/trainings-after-notify/{training_id}', [TelegramTrainingsController::class, 'markSentAfter']);

Route::post('/telegram/store-token', [TelegramLoginController::class, 'storeToken']);
Route::get('/telegram/all-tokens', [TelegramLoginController::class, 'allTokens']);
Route::get('/telegram/token/{telegram_id}', [TelegramLoginController::class, 'getTokenByTelegramId']);

Route::get('/telegram/get-my-teams/{user_id}', [TelegramTeamController::class, 'getMyTeams']);
Route::get('/telegram/players-who-responded-today/{team_code}', [TelegramTeamController::class, 'playersWhoRespondedToday']);

Route::get('/telegram/training/today-start/{team_code}', [TelegramTrainingsController::class, 'questionReady']);

Route::get('/telegram/question/check-already-answered/{user_id}', [QuestionnaireController::class, 'checkQuestionAlreadyAnswered']);

Route::post('/questionnaire/answers-until-training-poll', [QuestionnaireController::class, 'storeUntilTrainingPoll']);
Route::post('/questionnaire/answers-after-training-poll', [QuestionnaireController::class, 'storeAfterTrainingPoll']);

