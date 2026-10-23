<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Engineering\ItemDetailController;
use App\Http\Controllers\Engineering\PriceListController;
use App\Http\Controllers\Engineering\UnitPrice\UnitPriceController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\ProjectControl\BoqController;
use App\Http\Controllers\ProjectControl\PlanController;
use App\Http\Controllers\ProjectControl\PlanDetailController;
use App\Http\Controllers\Engineering\UnitPrice\RecordPriceController;
use App\Http\Controllers\ProjectControl\ProgressController;
use App\Http\Controllers\ManPower\WorkScopeController;
use App\Http\Controllers\ManPower\WorkerController;
use App\Http\Controllers\ManPower\WorkerCertificateController;
use App\Http\Controllers\UserManagement\UserManagementController;
use App\Http\Controllers\Auth\SignatureController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate')->name('login.authenticate');
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'create')->name('register.create');
    Route::post('/logout', 'logout')->name('logout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'show'])->name('home');

    Route::controller(AuthController::class)
        ->prefix('profile')
        ->name('profile.')
        ->group(function () {
            Route::get('/', 'profile')->name('show');
            Route::put('/password', 'updatePassword')
                ->name('password.update');
        });


    Route::prefix('signatures')
        ->name('signatures.')
        ->controller(SignatureController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{signature}/image', 'image')->name('image');
            Route::delete('/{signature}', 'destroy')->name('destroy');
        });


    Route::prefix('/man-power')->group(function () {
        Route::controller(WorkScopeController::class)->prefix('/work-scope')->name('work-scope.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'create')->name('create');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'delete')->name('delete');
        });

        Route::controller(WorkerController::class)->prefix('/worker')->name('worker.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'create')->name('create');

            Route::patch('/{id}/follow-up', 'followUp')
                ->name('follow-up');

            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::post('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'delete')->name('delete');
        });

        Route::prefix('worker/{worker}/certificates')
            ->name('worker.certificates.')
            ->controller(WorkerCertificateController::class)
            ->group(function () {
                Route::post('/', 'store')->name('store');

                Route::delete('/{certificateId}', 'delete')
                    ->name('delete');
            });

    });

    Route::controller(ProjectController::class)->prefix('/projects')->group(function () {
        Route::get("/", 'index')->name('projects');
        Route::post("/", 'create')->name('projects.create');
        Route::put("/{id}", 'update')->name('projects.update');
        Route::delete("/{id}", 'delete')->name('delete');
    });

    Route::prefix('/project-control')->group(function () {
        Route::controller(BoqController::class)->prefix('/boq')->group(function () {
            Route::get("/", 'index')->name('boq');
            Route::post("/", 'create')->name('boq.create');
            Route::put("/{id}", 'update')->name('boq.update');
            Route::delete("/{id}", 'delete')->name('delete');

            Route::controller(PlanController::class)->prefix('/{boq}/plan')->name('plan.')->group(function () {
                Route::get("/", 'index')->name('index');
                Route::get('/update-plan', 'updatePlan')->name('updatePlan');
                Route::post("/sync", 'sync')->name('sync');
                Route::put("/{plan}", 'update')->name('update');

                Route::controller(PlanDetailController::class)->prefix('/plan-detail')->name('detail.')->group(function () {
                    Route::get("/{plan}", 'index')->name('index');
                    Route::post('/{plan}', 'create')->name('create');
                    Route::delete("/{id}", 'delete')->name('delete');
                });
            });

            Route::controller(ProgressController::class)->prefix('/{boq}/progress')->name('progress.')->group(function () {
                Route::get("/", 'index')->name('index');
            });
        });
    });

    Route::prefix('/engineering')->group(function () {
        Route::controller(PriceListController::class)->group(function () {

            Route::controller(ItemDetailController::class)->prefix('/item-details')->group(function () {
                Route::get("/", 'index')->name('item-details.index');
                Route::post("/", 'create')->name('item-details.create');
                Route::put("/{id}", 'update')->name('item-details.update');
                Route::delete("/{id}", 'delete')->name('item-details.delete');
            });

            Route::get("/", 'index')->name('price-list.index');
            Route::post("/", 'create')->name('price-list.create');
            Route::put("/{id}", 'update')->name('price-list.update');
            Route::delete("/{id}", 'delete')->name('delete');

            Route::prefix('/price-list')->group(function () {
                Route::get("/{id}", 'show')->name('price-list.show');

                Route::controller(UnitPriceController::class)->prefix('/{priceList}/unit-price')->name('unit-price')->group(function () {
                    Route::get("/", 'index')->name('.index');
                    Route::post("/sync", 'sync')->name('.sync');
                });

                Route::controller(RecordPriceController::class)->prefix('/{priceListId}/record-price')->name('record.price.')->group(function () {
                    Route::get("/{id}", 'index')->name('index');
                    Route::post("/", 'create')->name('create');
                    Route::delete("/{id}", 'delete')->name('delete');
                });
            });

        });
    });

    Route::middleware(['role:super_admin,admin'])->group(function () {
        Route::controller(UserManagementController::class)->prefix('/user-management')->group(function () {
            Route::get("/", 'index')->name('user-management.index');
            Route::patch('/{id}/approve', 'approve')->name('user-management.approve');
        });
    });
});

