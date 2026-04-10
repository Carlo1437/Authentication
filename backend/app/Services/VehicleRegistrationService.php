<?php

namespace App\Services;

use App\Models\VehicleRegistration;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class VehicleRegistrationService
{
    public function index(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = VehicleRegistration::query();

        if ($search !== null && $search !== '') {
            $query->where(function ($q) use ($search): void {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email_address', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('vehicle_type', 'like', "%{$search}%")
                    ->orWhere('plate_number', 'like', "%{$search}%")
                    ->orWhere('registration_date', 'like', "%{$search}%")
                    ->orWhere('engine_number', 'like', "%{$search}%")
                    ->orWhere('chassis_number', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('id', 'desc')->paginate($perPage);
    }

    public function create(array $data): VehicleRegistration
    {
        $data['document'] = $this->handleDocumentUpload($data['document'] ?? null);

        return VehicleRegistration::query()->create($data);
    }

    public function update(VehicleRegistration $vehicleRegistration, array $data): VehicleRegistration
    {
        if (isset($data['document'])) {
            $data['document'] = $this->handleDocumentUpload($data['document'], $vehicleRegistration->document);
        }

        $vehicleRegistration->update($data);

        return $vehicleRegistration->fresh();
    }

    public function delete(VehicleRegistration $vehicleRegistration): void
    {
        if ($vehicleRegistration->document) {
            Storage::disk('public')->delete($vehicleRegistration->document);
        }

        $vehicleRegistration->delete();
    }

    private function handleDocumentUpload(mixed $file, ?string $oldDocumentPath = null): ?string
    {
        if (!$file instanceof UploadedFile) {
            return $oldDocumentPath;
        }

        if ($oldDocumentPath) {
            Storage::disk('public')->delete($oldDocumentPath);
        }

        return $file->store('vehicle_registrations', 'public');
    }
}
