<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;

use App\Models\ClassTraining;
use App\Models\PresenceTraining;
use App\Models\Question;
use App\Models\SettingLoadcontrol;
use App\Models\SettingUser;
use App\Models\Team;
use App\Models\TelegramToken;
use App\Models\Training;
use App\Models\User;
use App\Models\UserMeta;
use App\Services\TrainingService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Http;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Facades\Log;


use App\Services\UserService;

class UserController extends Controller {

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $userId = Auth::user()->id;

        $teamActive = Team::query()
                          ->where( 'user_id', $userId )
                          ->where( 'active', true )
                          ->orderBy( 'created_at', 'desc' )
                          ->paginate( 100 );

        return view( 'users.index', compact( 'teamActive' ) );
    }

    public function store(StoreUserRequest $request) {

        $data = $request->validated();

        $user = $this->userService->createUser( $data );
        event( new Registered( $user ) );

        return response()->json( [ 'code' => 200, 'message' => 'Запись успешно создана', 'data' => $user ], 200 );
    }

    /**
     * Display the specified resource.
     */
    public function show( string $id ) {
        $player = User::where( 'id', $id )->first();

        $userId = Auth::user()->id;

        $teamActive = Team::query()
                          ->where( 'user_id', $userId )
                          ->paginate( 100 );

        return view( 'users.user', compact( 'player', 'teamActive' ) );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( string $id ) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request ) {
        $active = $request->boolean( 'active' );

        $user      = User::findOrFail( $request->player_id );
        $userEmail = $user->email;

        // Валидация email, если изменился
        if ( $request->email !== $userEmail ) {
            $request->validate( [
                'email' => [ 'required', 'string', 'email', 'max:255', 'unique:' . User::class ],
            ] );
        }

        $request->validate( [
            'avatar' => 'nullable|image',
        ] );

        $userMeta = UserMeta::where( 'user_id', $request->player_id )->first();

        $avatarName = $userMeta ? $userMeta->avatar : null;

        if ( $request->hasFile( 'avatar' ) ) {
            $avatarName = time() . '.' . strtolower( $request->file( 'avatar' )->getClientOriginalExtension() );
            $request->file( 'avatar' )->move( public_path( 'avatars' ), $avatarName );

            $imagePath  = public_path( 'avatars/' . $avatarName );
            $sizeBefore = filesize( $imagePath );
            \Log::info( "Image size before optimization: {$sizeBefore} bytes" );

            try {
                $optimizerChain = OptimizerChainFactory::create();
                $optimizerChain->optimize( $imagePath );

                $sizeAfter = filesize( $imagePath );
                \Log::info( "Image size after optimization: {$sizeAfter} bytes" );
                \Log::info( 'Image optimized successfully: ' . $avatarName );
            } catch ( \Exception $e ) {
                \Log::error( 'Image optimization failed: ' . $e->getMessage() );
            }
        }

        $user->update( [
            'name'        => $request->name,
            'second_name' => $request->second_name,
            'last_name'   => $request->last_name,
            'team_code'   => $request->team_code,
            'email'       => $request->email,
            'active'      => $active,
        ] );

        // Обновляем или создаём UserMeta
        if ( $userMeta ) {
            $userMeta->update( [
                'tel'        => $request->tel,
                'birthday'   => $request->birthday,
                'position'   => $request->position,
                'number'     => $request->number,
                'tel_mother' => $request->tel_mother,
                'tel_father' => $request->tel_father,
                'comment'    => $request->comment,
                'avatar'     => $avatarName,
            ] );
        } else {
            UserMeta::create( [
                'user_id'    => $user->id,
                'tel'        => $request->tel,
                'birthday'   => $request->birthday,
                'position'   => $request->position,
                'number'     => $request->number,
                'tel_mother' => $request->tel_mother,
                'tel_father' => $request->tel_father,
                'comment'    => $request->comment,
                'avatar'     => $avatarName,
            ] );
        }

        return back()->with( 'success', __( 'Сохранено' ) );
    }


    public function updateActive( Request $request, $id ) {
        // Find user by ID
        $user = User::findOrFail( $id );

        $oldActive    = $user->active;
        $user->active = $request->input( 'active' );

        // Log the attempt to change status
        Log::info( "Attempting to update user active status", [
            'user_id'    => $user->id,
            'old_active' => $oldActive,
            'new_active' => $user->active,
            'admin_id'   => auth()->id(), // if you have authentication
        ] );

        // Check if the value has changed
        if ( $user->isDirty( 'active' ) ) {
            $user->save();

            // Log the status change
            Log::info( "User active status updated", [
                'user_id' => $user->id,
                'active'  => $user->active,
            ] );

            $meta  = TelegramToken::where( 'user_id', $user->id )->first();
            $tg_id = $meta?->telegram_id;

            if ( $tg_id ) {
                $botToken     = config( 'services.telegram.bot_token' );
                $message      = '';
                $reply_markup = [];

                if ( $user->active ) {
                    // Activated
                    $message      = "Вы активированы!✅";
                    $reply_markup = [
                        'keyboard'        => [
                            [ [ 'text' => 'Показать тренировки' ], [ 'text' => 'Выйти' ] ]
                        ],
                        'resize_keyboard' => true
                    ];
                } else {
                    // Deactivated
                    $message      = "Ваш статус был изменён: вы теперь деактивирован❌.";
                    $reply_markup = [
                        'keyboard'        => [
                            [ [ 'text' => 'Выйти' ] ]
                        ],
                        'resize_keyboard' => true
                    ];
                }

                // Send message to Telegram
                $response = Http::post( "https://api.telegram.org/bot{$botToken}/sendMessage", [
                    'chat_id'      => $tg_id,
                    'text'         => $message,
                    'reply_markup' => json_encode( $reply_markup ),
                ] );

                // Log telegram message sending
                Log::info( "Sent Telegram message to user", [
                    'user_id'         => $user->id,
                    'telegram_id'     => $tg_id,
                    'message'         => $message,
                    'response_status' => $response->status(),
                    'response_body'   => $response->body(),
                ] );

                // Log an error if Telegram does not respond OK
                if ( ! $response->ok() ) {
                    Log::error( "Error sending message to Telegram", [
                        'user_id'       => $user->id,
                        'telegram_id'   => $tg_id,
                        'response_body' => $response->body(),
                    ] );
                }
            }
        } else {
            // Log case when active status was not changed
            Log::info( "User active status was not changed", [
                'user_id'        => $user->id,
                'current_active' => $user->active,
            ] );
        }

        return response()->json( [ 'success' => true, 'active' => $user->active ] );
    }


    public function updateLoadControl( Request $request, $id ) {
        $user               = User::findOrFail( $id );
        $user->load_control = $request->input( 'load_control' );
        $user->save();

        return response()->json( [ 'success' => true, 'load_control' => $user->load_control ] );
    }

    public function updateAI( Request $request, $id ) {
        $user = User::findOrFail( $id );

        // Найти настройку с slug = 'ai'
        $setting = $user->settings()->where( 'slug', 'ai' )->first();

        if ( ! $setting ) {
            // Если настройка отсутствует — создать
            $setting = $user->settings()->create( [
                'slug'   => 'ai',
                'value'  => 'none',
                'active' => $request->ai,
            ] );
        } else {
            // Если есть — обновить
            $setting->active = $request->ai;
            $setting->value  = 'none';
            $setting->save();
        }

        return response()->json( [ 'success' => true, 'ai' => $setting->active ] );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {
        PresenceTraining::where( 'user_id', $id )->delete();
        UserMeta::where( 'user_id', $id )->delete();
        SettingLoadcontrol::where( 'user_id', $id )->delete();
        Team::where( 'user_id', $id )->delete();
        Training::where( 'user_id', $id )->delete();
        Question::where( 'user_id', $id )->delete();
        User::where( 'id', $id )->delete();
        SettingUser::where( 'user_id', $id )->delete();

        return response()->json( [ 'success' => 'Запись успешно удалена' ] );
    }

    public function destroyCoach( string $id ) {
        PresenceTraining::where( 'user_id', $id )->delete();
        UserMeta::where( 'user_id', $id )->delete();
        SettingLoadcontrol::where( 'user_id', $id )->delete();
        Team::where( 'user_id', $id )->delete();
        Training::where( 'user_id', $id )->delete();
        User::where( 'id', $id )->delete();
        ClassTraining::where( 'user_id', $id )->delete();
        SettingUser::where( 'user_id', $id )->delete();

        return response()->json( [ 'success' => 'Запись успешно удалена' ] );
    }
}
