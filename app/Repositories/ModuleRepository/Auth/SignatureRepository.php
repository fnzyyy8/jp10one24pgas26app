<?php

namespace App\Repositories\ModuleRepository\Auth;

use App\Models\Auth\Signature;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class SignatureRepository
{
    public function paginateForUser(
        int $userId,
        int $perPage,
        string $search,
        string $sortBy,
        string $sortDirection
    ): LengthAwarePaginator {
        $allowedSortColumns = [
            'name',
            'type',
            'is_default',
            'created_at',
        ];

        if (! in_array($sortBy, $allowedSortColumns, true)) {
            $sortBy = 'created_at';
        }

        if (! in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'desc';
        }

        return Signature::query()
            ->where('user_id', $userId)
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%");
                });
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage)
            ->withQueryString();
    }

    public function clearDefaultForUser(int $userId): void
    {
        Signature::query()
            ->where('user_id', $userId)
            ->where('is_default', true)
            ->update(['is_default' => false]);
    }

    public function create(array $data): Signature
    {
        return Signature::query()->create($data);
    }

    public function findForUserOrFail(
        int $userId,
        int $signatureId
    ): Signature {
        return Signature::query()
            ->where('user_id', $userId)
            ->findOrFail($signatureId);
    }

    public function delete(Signature $signature): void
    {
        $signature->delete();
    }
}
