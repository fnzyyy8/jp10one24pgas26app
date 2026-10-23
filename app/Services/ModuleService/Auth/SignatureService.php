<?php

namespace App\Services\ModuleService\Auth;

use App\Models\Auth\Signature;
use App\Repositories\ModuleRepository\Auth\SignatureRepository;
use App\Services\SharedService\LocalStorageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Throwable;

class SignatureService
{
    private LocalStorageService $storage;

    public function __construct(
        private readonly SignatureRepository $signatureRepository
    ) {
        $this->storage = new LocalStorageService('local');
    }

    public function paginateForUser(
        int $userId,
        array $filters
    ): LengthAwarePaginator {
        return $this->signatureRepository->paginateForUser(
            $userId,
            (int) ($filters['per_page'] ?? 10),
            (string) ($filters['search'] ?? ''),
            (string) ($filters['sort_by'] ?? 'created_at'),
            (string) ($filters['sort_direction'] ?? 'desc')
        );
    }

    public function createForUser(
        int $userId,
        array $data,
        UploadedFile $file
    ): Signature {
        $filePath = $this->storage->upload(
            $file,
            "signatures/{$userId}"
        );

        try {
            return DB::transaction(function () use (
                $userId,
                $data,
                $file,
                $filePath
            ): Signature {
                $isDefault = (bool) ($data['is_default'] ?? false);

                if ($isDefault) {
                    $this->signatureRepository
                        ->clearDefaultForUser($userId);
                }

                return $this->signatureRepository->create([
                    'user_id' => $userId,
                    'name' => $data['name'],
                    'type' => $data['type'],
                    'signature_path' => $filePath,
                    'original_filename' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'is_default' => $isDefault,
                ]);
            });
        } catch (Throwable $exception) {
            $this->storage->delete($filePath);

            throw $exception;
        }
    }

    public function findForUser(
        int $userId,
        int $signatureId
    ): Signature {
        return $this->signatureRepository->findForUserOrFail(
            $userId,
            $signatureId
        );
    }

    public function deleteForUser(
        int $userId,
        int $signatureId
    ): void {
        $signature = $this->findForUser($userId, $signatureId);

        DB::transaction(function () use ($signature): void {
            $this->signatureRepository->delete($signature);
        });

        $this->storage->delete($signature->signature_path);
    }
}
