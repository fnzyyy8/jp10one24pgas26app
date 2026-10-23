<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ModuleService\Auth\SignatureService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SignatureController extends Controller
{
    public function __construct(
        private readonly SignatureService $service
    ) {}

    public function index(Request $request): Response
    {
        $filters = $request->validate([
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'search' => ['nullable', 'string', 'max:255'],
            'sort_by' => [
                'nullable',
                'string',
                'in:name,type,is_default,created_at',
            ],
            'sort_direction' => [
                'nullable',
                'string',
                'in:asc,desc',
            ],
        ]);

        $userId = (int) $request->user()->id;

        $signatures = $this->service->paginateForUser($userId, [
            'per_page' => $filters['per_page'] ?? 10,
            'search' => $filters['search'] ?? '',
            'sort_by' => $filters['sort_by'] ?? 'created_at',
            'sort_direction' => $filters['sort_direction'] ?? 'desc',
        ]);

        $signatures->setCollection(
            $signatures->getCollection()->map(
                fn ($signature) => [
                    'id' => $signature->id,
                    'name' => $signature->name,
                    'type' => $signature->type,
                    'is_default' => (bool) $signature->is_default,
                    'image_url' => route('signatures.image', [
                        'signature' => $signature->id,
                    ]),
                    'original_filename' => $signature->original_filename,
                    'created_at' => $signature->created_at?->toISOString(),
                ]
            )
        );

        return Inertia::render('Signature/SignaturePage', [
            'signatures' => $signatures,
            'filters' => [
                'search' => $filters['search'] ?? '',
                'per_page' => $filters['per_page'] ?? 10,
                'sort_by' => $filters['sort_by'] ?? 'created_at',
                'sort_direction' => $filters['sort_direction'] ?? 'desc',
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => [
                'required',
                'in:approval,verification,authorization,other',
            ],
            'is_default' => ['nullable', 'boolean'],
            'file' => [
                'required',
                'file',
                'mimes:png,jpg,jpeg,webp',
                'max:2048',
            ],
        ]);

        $this->service->createForUser(
            (int) $request->user()->id,
            $validated,
            $request->file('file')
        );

        return back()->with('success', 'Signature uploaded successfully.');
    }


    public function image(Request $request, int $signature): BinaryFileResponse
    {
        $signatureRecord = $this->service->findForUser(
            (int) $request->user()->id,
            $signature
        );

        $disk = Storage::disk('local');
        $filePath = $signatureRecord->signature_path;

        abort_unless(
            $disk->exists($filePath),
            404,
            'Signature image file not found.'
        );

        $mimeType = $signatureRecord->mime_type;

        abort_unless(
            in_array($mimeType, [
                'image/png',
                'image/jpeg',
                'image/webp',
            ], true),
            415,
            'Unsupported signature image type.'
        );

        return response()->file($disk->path($filePath), [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'private, no-store, max-age=0',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function destroy(Request $request, int $signature)
    {
        $this->service->deleteForUser(
            (int) $request->user()->id,
            $signature
        );

        return back()->with('success', 'Signature deleted successfully.');
    }
}
