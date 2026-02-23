<?php 

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public function index(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = User::query();
        if($search !== null && $search !== ''){
            $query->where(function ($q) use ($search):void{
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }    
        
        return $query->orderBy('id')->paginate($perPage);
    }

    public function create(array $data):User
    {
        return User::query()->create($data);
    }

    public function update(User $user, array $data):User
    {
        $user->update($data);
        return $user->fresh();
    }

    public function delete(User $user):void
    {
        $user->delete();
    }
}