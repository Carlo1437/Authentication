<?php

namespace App\Services;

use App\Models\MotorRepo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MotorRepoService
{
 
    public function index(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = MotorRepo::query();

        if ($search !== null && $search !== '') {
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('id', 'desc')->paginate($perPage);
    }

   
    public function create(array $data): MotorRepo
    {
        $data['image'] = $this->handleImageUpload($data['image'] ?? null);

        return MotorRepo::query()->create($data);
    }

   
    public function update(MotorRepo $motorRepo, array $data): MotorRepo
    {
        if (isset($data['image'])) {
            $data['image'] = $this->handleImageUpload($data['image'], $motorRepo->image);
        }

        $motorRepo->update($data);

        return $motorRepo->fresh();
    }

    
    public function delete(MotorRepo $motorRepo): void
    {
        if ($motorRepo->image) {
            Storage::disk('public')->delete($motorRepo->image);
        }

        $motorRepo->delete();
    }

   
    private function handleImageUpload(mixed $file, ?string $oldImagePath = null): ?string
    {
        if (!$file instanceof UploadedFile) {
            return $oldImagePath;
        }

        if ($oldImagePath) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return $file->store('motor_repos', 'public');
    }
}
