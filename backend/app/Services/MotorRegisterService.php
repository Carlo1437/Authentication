<?php

namespace App\Services;

use App\Models\motor_register;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MotorRegisterService
{
  

    public function index(?string $search = null, int $perPage = 15):LengthAwarePaginator{

        $query = motor_register::query()->with('user');
        if($search !== null && $search !== ''){
            $query->where(function ($q) use ($search):void{
                $q->where('plate_number', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%");
            });
        }    
        
        return $query->orderBy('id', 'desc')->paginate($perPage);
    }

    public function create(array $data):motor_register
    {
        $data['user_id'] = auth()->id();
        return motor_register::query()->create($data);
    }

    public function update(motor_register $motor_register, array $data):motor_register
    {
        $motor_register->update($data);
        return $motor_register->fresh();
    }

    public function delete(motor_register $motor_register):void{
        $motor_register->delete();
    }
}
