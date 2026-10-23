<?php

namespace App\Services\ModuleService\Auth;

use App\Models\Auth\User;
use App\Repositories\ModuleRepository\Auth\AuthRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use RuntimeException;

class AuthService
{

    public function __construct(
        protected AuthRepository $repository,
    )
    {
    }

    public function getAll() : Collection
    {
        return $this->repository->getAll();
    }

    public function create(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                return $this->repository->create($data);
            });
        } catch (Throwable $e) {
            Log::error('Failed to create user: ', [
                'message' => $e->getMessage(),
                'data' => $data
            ]);
            throw new RuntimeException(
                'Failed to create user.',
                previous: $e
            );
        }
    }

    public function findById(int $userId): ?User
    {
        return $this->repository->findById($userId);
    }

    public function updateProfile(int $userId, array $data): User
    {
        try {
            return DB::transaction(function () use ($userId, $data) {
                return $this->repository->update($userId, $data);
            });
        } catch (Throwable $e) {
            Log::error('Failed to update user profile.', [
                'user_id' => $userId,
                'message' => $e->getMessage(),
            ]);

            throw new RuntimeException(
                'Failed to update user profile.',
                previous: $e,
            );
        }
    }

    public function updatePassword(int $userId, string $password): User
    {
        try {
            return DB::transaction(function () use ($userId, $password) {
                return $this->repository->updatePassword(
                    $userId,
                    $password,
                );
            });
        } catch (Throwable $e) {
            Log::error('Failed to update user password.', [
                'user_id' => $userId,
                'message' => $e->getMessage(),
            ]);

            throw new RuntimeException(
                'Failed to update user password.',
                previous: $e,
            );
        }
    }

    public function approve(int $userId, int $verifiedBy): User
    {
        try {
            return DB::transaction(function () use ($userId, $verifiedBy) {
                return $this->repository->approve($userId, $verifiedBy);
            });
        } catch (Throwable $e) {
            Log::error('Failed to approve user.', [
                'user_id' => $userId,
                'verified_by' => $verifiedBy,
                'message' => $e->getMessage(),
            ]);

            throw new RuntimeException(
                'Failed to approve user.',
                previous: $e,
            );
        }
    }

}
