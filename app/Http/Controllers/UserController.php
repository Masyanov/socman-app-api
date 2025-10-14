<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

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
        $user = $this->userService->get($id);
        return new UserResource($user);
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
}
