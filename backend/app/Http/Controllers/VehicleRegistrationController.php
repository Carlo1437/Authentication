<?php

namespace App\Http\Controllers;
use App\Services\VehicleRegistrationService;
use App\Http\Requests\IndexVehicleRegistrationRequest;
use App\Http\Requests\StoreVehicleRegistrationRequest;
use App\Http\Requests\UpdateVehicleRegistrationRequest;
use App\Models\VehicleRegistration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleRegistrationController extends Controller
{
    public function __construct(protected VehicleRegistrationService $vehicleRegistrationService){}
    
        public function index(IndexVehicleRegistrationRequest $request): JsonResponse
    {
      
          $validated = $request->validated();
          $search = $validated['search'] ?? null;
          $perPage = $validated['perPage'] ?? 10;
          $vehicleRegistrations = $this->vehicleRegistrationService->index($search, $perPage);

          return response()->json($vehicleRegistrations);
        
    }

    public function store(StoreVehicleRegistrationRequest $request): JsonResponse
    {
       $vehicleRegistration = $this->vehicleRegistrationService->create($request->validated());
       return response()->json($vehicleRegistration);
    }

    public function show(VehicleRegistration $vehicleRegistration): JsonResponse
    {
       return response()->json($vehicleRegistration);
    }

    public function update(UpdateVehicleRegistrationRequest $request, VehicleRegistration $vehicleRegistration): JsonResponse
    {
       $vehicleRegistration = $this->vehicleRegistrationService->update($vehicleRegistration, $request->validated());
       return response()->json($vehicleRegistration);
    }

    public function destroy(VehicleRegistration $vehicleRegistration): JsonResponse
    {
        $this->vehicleRegistrationService->delete($vehicleRegistration);
       return response()->json(null, 204);
    }    
}
