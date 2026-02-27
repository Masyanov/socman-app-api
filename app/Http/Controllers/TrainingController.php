<?php

namespace App\Http\Controllers;

use App\Http\Requests\Training\StoreTrainingRequest;
use App\Http\Requests\Training\UpdateTrainingRequest;
use App\Http\Requests\Training\SettingsTrainingRequest;
use App\Http\Requests\Training\AddressesTrainingRequest;
use App\Models\ClassTraining;
use App\Models\AddressesTraining;
use App\Models\Team;
use App\Services\TrainingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    protected TrainingService $trainingService;

    public function __construct(TrainingService $trainingService)
    {
        $this->trainingService = $trainingService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $teamCode = Auth::user()->team_code;

        $teamActive = Team::where('user_id', $userId)
                          ->where('active', true)
                          ->latest('created_at')
                          ->paginate(10);

        $trainingActive = $this->trainingService->getTrainingsByUser($userId);
        $trainingForPlayer = $this->trainingService->getTrainingsByTeamCode($teamCode);

        $trainingClass = ClassTraining::where('user_id', $userId)->paginate(100);
        $trainingAddresses = AddressesTraining::where('user_id', $userId)->paginate(100);

        return view('trainings.index', compact(
            'teamActive',
            'trainingActive',
            'trainingForPlayer',
            'trainingClass',
            'trainingAddresses'
        ));
    }

    /**
     * Create new classifications
     */
    public function settings(SettingsTrainingRequest $request)
    {
        $userId = Auth::id();

        foreach ($request->classification_names as $name) {
            ClassTraining::create(['user_id' => $userId, 'name' => $name]);
        }

        return redirect()->back()->with('success', 'Классификации успешно сохранены!');
    }

    /**
     * Create new addresses trainings
     */
    public function addressesTrainings(AddressesTrainingRequest $request)
    {
        $userId = Auth::id();

        foreach ($request->addresses_names as $name) {
            AddressesTraining::create(['user_id' => $userId, 'name' => $name]);
        }

        return redirect()->back()->with('success', 'Адреса успешно сохранены!');
    }

    /**
     * Delete address
     */
    public function deleteAddressesTrainings(string $id)
    {
        \Log::debug("Попытка удалить адрес с ID: " . $id);
        $address = AddressesTraining::find($id);
        if (!$address) {
            \Log::warning("Адрес с ID {$id} не найден.");
            return response()->json(['message' => 'Адрес не найдена'], 404);
        }

        $address->delete();

        return response()->json(['success' => 'Адрес успешно удален']);
    }

    /**
     * Delete class training
     */
    public function deleteClassTraining(string $id)
    {
        \Log::debug("Попытка удалить классификацию с ID: " . $id);
        $class = ClassTraining::find($id);
        if (!$class) {
            \Log::warning("Классификация с ID {$id} не найден.");
            return response()->json(['message' => 'Классификация не найдена'], 404);
        }

        $class->delete();

        return response()->json(['success' => 'Классификация успешно удалена']);
    }

    /**
     * Store a newly created training.
     */
    public function store(StoreTrainingRequest $request)
    {
        $data = $request->validated();
        $userId = Auth::id();

        $training = $this->trainingService->createTraining($data, $userId);

        return response()->json([
            'code' => 200,
            'message' => 'Запись успешно создана',
            'data' => $training,
        ]);
    }

    /**
     * Display a specific training.
     */
    public function show(string $id)
    {
        $userId = Auth::id();

        $teamActive = Team::where('user_id', $userId)
                          ->latest('created_at')
                          ->paginate(10);

        $trainingClass = ClassTraining::paginate(100);
        $trainingAddresses = AddressesTraining::paginate(100);

        $training = $this->trainingService->getTrainingByIdAndUser($id, $userId);

        if (!$training) {
            return redirect('/dashboard')->with('error', __('messages.Тренировка не найдена'));
        }

        return view('trainings.training', compact('training', 'teamActive', 'trainingClass', 'trainingAddresses'));
    }

    /**
     * Update the specified training.
     */
    public function update(UpdateTrainingRequest $request, string $id)
    {
        $data = $request->validated();

        $training = $this->trainingService->updateTraining($data['trainingId'], $data);

        if (!$training) {
            return response()->json(['message' => __('messages.Тренировка не найдена')], 404);
        }

        return response()->json([
            'code' => 200,
            'success' => __('messages.Запись успешно обновлена'),
            'data' => $training,
        ]);
    }

    /**
     * Remove the specified training.
     */
    public function destroy(string $id)
    {
        $deleted = $this->trainingService->deleteTraining((int)$id);

        if (!$deleted) {
            return response()->json(['message' => __('messages.Тренировка не найдена')], 404);
        }

        return response()->json(['success' => __('messages.Запись успешно удалена')]);
    }

    /**
     * Calendar data.
     */
    public function calendar(Request $request)
    {
        $result = $this->trainingService->getTrainingsForCalendar($request->input('start'), $request->input('end'));

        return response()->json($result);
    }
}
