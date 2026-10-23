<?php

namespace App\Repositories\ModuleRepository\Auth;

use App\Models\Auth\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    public function __construct(protected User $model)
    {
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function findById(int $userId): ?User
    {
        return $this->model
            ->newQuery()
            ->find($userId);
    }

    public function update(int $userId, array $data): User
    {
        $user = $this->model
            ->newQuery()
            ->findOrFail($userId);

        $user->update($data);

        return $user->refresh();
    }

    public function updatePassword(int $userId, string $password): User
    {
        $user = $this->model
            ->newQuery()
            ->findOrFail($userId);

        $user->password = Hash::make($password);
        $user->save();

        return $user;
    }

    public function approve(int $userId, int $verifiedBy): User
    {
        $user = $this->model
            ->newQuery()
            ->findOrFail($userId);

        $user->update([
            'verified_by' => $verifiedBy,
            'verified_at' => now(),
        ]);

        return $user->refresh();

    }

}
