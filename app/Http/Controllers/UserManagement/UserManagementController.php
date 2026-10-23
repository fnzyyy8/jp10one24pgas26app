<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserManagement\UserManagementResource;
use App\Services\ModuleService\Auth\AuthService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserManagementController extends Controller
{
    public function __construct(
        protected AuthService $authService
    )
    {
    }

    public function index()
    {
        $users = $this->authService->getAll();


        return Inertia::render('UserManagement/UserManagementPage', [
            'users' => UserManagementResource::collection($users)->resolve(),
        ]);
    }

    public function update()
    {

    }

    public function approve(Request $request, int $id)
    {
        abort_unless(
            in_array($request->user()->role, ['super_admin', 'admin'], true),
            403,
            'Anda tidak memiliki izin untuk menyetujui akun.',
        );

        $user = $this->authService->findById($id);

        abort_if($user === null, 404, 'Pengguna tidak ditemukan.');

        abort_if(
            $user->role === 'super_admin',
            403,
            'Akun super admin tidak memerlukan approval.',
        );

        $this->authService->approve(
            $user->id,
            (int) $request->user()->id,
        );

        return back()->with('success', 'Pengguna berhasil disetujui.');
    }
}
