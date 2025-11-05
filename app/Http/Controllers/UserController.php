<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Player;
use App\Models\PlayerTest;
use App\Models\Team;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Получить всех пользователей/команды
    public function index(Request $request)
    {
        return UserResource::collection($this->userService->listUsers($request->user()->id));
    }

    // Создать пользователя
    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->create($request->validated());
        return new UserResource($user);
    }

    // Показать пользователя
    public function show($id)
    {
        $userId = Auth::user()->id;
        $user = $this->userService->get($id);
        $allTeams = Team::query()
                     ->where( 'user_id', $userId )
                     ->latest( 'created_at' )
                     ->paginate( 10 );

        return view('users.user', [
            'player'     => $user,
            'teamActive' => $allTeams,
            'teamCount'  => $allTeams->count(),
        ]);

    }

    // Обновить пользователя
    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->userService->update($id, $request->validated(), $request->file('avatar'));
        return redirect()->back()->with('success', 'Сохранено');
    }

    // Удалить пользователя
    public function destroy($id)
    {
        $this->userService->delete($id);
        return response()->json(['success' => 'Запись успешно удалена']);
    }

    // Обновить активность (через AJAX)
    public function updateActive(Request $request, $id)
    {
        $active = $this->userService->setActive($id, $request->boolean('active'));
        return response()->json(['success' => true, 'active' => $active]);
    }

    public function getPlayerInfo( $id ) {

        $infoThisPlayer = User::where( 'id', $id )->first();

        $yourTeam = Team::where( 'team_code', $infoThisPlayer->team_code )->first();

        $arrayAll     = [];
        $birthday = \Carbon\Carbon::parse($infoThisPlayer->meta->birthday)->format('d.m.Y');
        $infoOfPlayer = [
            'avatar'        => $infoThisPlayer->meta->avatar,
            'full_name'        => $infoThisPlayer->name .' '. $infoThisPlayer->last_name,
            'team'             => $yourTeam->name,
            'date_of_birth'    => $birthday,
            'positionOfPlayer' => $infoThisPlayer->meta->position,
        ];
        $datas = PlayerTest::where('player_id', $id)->get();
        $datasLast = PlayerTest::where('player_id', $id)->first();

        $lastDataOfPlayer = [
            'weight'                   => $datasLast->weight,
            'height'                   => $datasLast->height,
            'body_mass_index'          => $datasLast->body_mass_index,
            'push_ups'                 => $datasLast->push_ups,
            'pull_ups'                 => $datasLast->pull_ups,
            'ten_m'                    => $datasLast->ten_m,
            'twenty_m'                 => $datasLast->twenty_m,
            'thirty_m'                 => $datasLast->thirty_m,
            'long_jump'                => $datasLast->long_jump,
            'vertical_jump_no_hands'   => $datasLast->vertical_jump_no_hands,
            'vertical_jump_with_hands' => $datasLast->vertical_jump_with_hands,
            'illinois_test'            => $datasLast->illinois_test,
            'pause_one'                => $datasLast->pause_one,
            'pause_two'                => $datasLast->pause_two,
            'pause_three'              => $datasLast->pause_three,
            'step'                     => $datasLast->step,
            'mpk'                      => $datasLast->mpk,
        ];

        $dataOfPlayer = [];

        foreach ( $datas as $item ) {
            $formattedDate = \Carbon\Carbon::parse($item->date_of_test)->format('d.m.Y');
            $dataOfPlayer[] = [
                'date'                     => $formattedDate,
                'weight'                   => $item->weight,
                'height'                   => $item->height,
                'body_mass_index'          => $item->body_mass_index,
                'push_ups'                 => $item->push_ups,
                'pull_ups'                 => $item->pull_ups,
                'ten_m'                    => $item->ten_m,
                'twenty_m'                 => $item->twenty_m,
                'thirty_m'                 => $item->thirty_m,
                'long_jump'                => $item->long_jump,
                'vertical_jump_no_hands'   => $item->vertical_jump_no_hands,
                'vertical_jump_with_hands' => $item->vertical_jump_with_hands,
                'illinois_test'            => $item->illinois_test,
                'pause_one'                => $item->pause_one,
                'pause_two'                => $item->pause_two,
                'pause_three'              => $item->pause_three,
                'step'                     => $item->step,
                'mpk'                      => $item->mpk,
            ];
        }
        $arrayAll[] = [ 'infoOfPlayer' => $infoOfPlayer, 'dataOfPlayer' => $dataOfPlayer, 'lastDataOfPlayer' => $lastDataOfPlayer ];

        return response()->json( $arrayAll );
    }
}
