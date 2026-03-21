<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexMotorRequest;
use App\Http\Requests\StoreMotorRegisterRequest;
use App\Http\Requests\UpdateMotorRegisterRequest;
use Illuminate\Http\Request;
use App\Services\MotorRegisterService;
use Illuminate\Http\JsonResponse;
use App\Models\motor_register;




class MotorRegisterController extends Controller
{
    public function __construct(protected MotorRegisterService $motorRegisterService){}
    public function index(IndexMotorRequest $request):JsonResponse
    {
        $validated = $request->validated();
        $search = $validated['search'] ?? null;
        $perPage = $validated['perPage'] ?? 15;
        $motorRegisters = $this->motorRegisterService->index($search, $perPage);

        return response()->json($motorRegisters);
    }

    public function store(StoreMotorRegisterRequest $request):JsonResponse
    {
        $motor_register = $this->motorRegisterService->create($request->validated());
        return response()->json($motor_register);
    }
    public function show(motor_register $motor_register):JsonResponse
    {
        return response()->json($motor_register);
    }

    public function update(UpdateMotorRegisterRequest $request, motor_register $motor_register):JsonResponse
    {
        $motor_register = $this->motorRegisterService->update($motor_register, $request->validated());
        return response()->json($motor_register);
    }

    public function destroy(motor_register $motor_register):JsonResponse
    {
      $this->motorRegisterService->delete($motor_register);
      return response()->json(null, 204);
    }
   
}
