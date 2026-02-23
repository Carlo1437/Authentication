<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct
    (protected UserService $userService){}
    public function index(IndexUserRequest $request): JsonResponse
    {
      
          $validated = $request->validated();
          $search = $validated['search'] ?? null;
          $perPage = $validated['perPage'] ?? 10;
          $users = $this->userService->index($search, $perPage);

          return response()->json($users);
        
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
       $user = $this->userService->update($user, $request->validated());
       return response()->json($user);
    }

     public function store(StoreUserRequest $request): JsonResponse
    {
       $user = $this->userService->create($request->validated());
       return response()->json($user);
    }

    public function show(User $user): JsonResponse
    {
       return response()->json($user);
        
    }

    public function destroy(User $user): JsonResponse
    {
        $this->userService->delete($user);
       return response()->json(null, 204);
        
    }
}
