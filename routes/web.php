<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AssignmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RelationController;
use App\Http\Controllers\HierarchyController;
use App\Http\Controllers\DepartmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [AuthController::class, 'index'])->name('auth.index');
    Route::post('/', [AuthController::class, 'login'])->name('auth.login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::view('/homepage', 'app.taskscore.index')->name('homepage');

    Route::group(['middleware' => 'itself'], function () {
        Route::get('/account/{user}/settings', [AccountController::class, 'settings'])->name('account.settings');
    });

    Route::group(['middleware' => 'role:superadmin'], function () {
        Route::get('/account/{user}/settings', [AccountController::class, 'settings'])->name('account.settings');
        Route::get('/account/{user}/permissions', [AccountController::class, 'managePermissions'])->name('account.manage-permissions');
        Route::put('/account/{user}/permissions-update', [AccountController::class, 'updatePermissions'])->name('account.update-permissions');
    });

    // Route::group(['as' => 'taskscore.', 'prefix' => 'task-score'], function () {
    Route::group(['as' => 'taskscore.'], function () {
            Route::get('/my-assignments', [AssignmentController::class, 'unresolved'])->name('assignment.unresolved');
            Route::get('/my-resolved-assignments', [AssignmentController::class, 'resolved'])->name('assignment.resolved');
            Route::get('/assignments', [AssignmentController::class, 'create'])->name('assignment.create');
            Route::post('/store-assignment', [AssignmentController::class, 'store'])->name('assignment.store');
            Route::get('/assignment/{assignment}', [AssignmentController::class, 'show'])->name('assignment.show');
            Route::delete('/assignment/{assignment}/delete', [AssignmentController::class, 'delete'])->name('assignment.delete');
            Route::put('/{assignment}/resolve', [AssignmentController::class, 'resolve'])->name('assignment.resolve');
            Route::put('/{assignment}/approve', [AssignmentController::class, 'approve'])->name('assignment.approve');
            Route::post('/{assignment}/reassign', [AssignmentController::class, 'reassign'])->name('assignment.reassign');
    });

    Route::group(['middleware' => 'permission:manage_user'], function () {
        // Route::get('/account/{user}/settings', [AccountController::class, 'settings'])->name('account.settings');
        Route::put('/account/{user}/update', [AccountController::class, 'updateAccount'])->name('account.update');
        Route::put('/account/{user}/change-password', [AccountController::class, 'changePassword'])->name('account.change-password');

        Route::resource('users', UserController::class)->except([
            'show'
        ]);
    });

    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::resource('departments', DepartmentController::class)->only([
        'store',
        'update',
        'destroy',
        'show'
    ])->middleware('permission:manage_department');

    Route::group(['middleware' => 'permission:manage_position'], function () {
        Route::resource('positions', PositionController::class)->only([
            'index',
            'store',
            'update',
            'destroy',
            'show'
        ]);
        Route::get('/hierarchy', [HierarchyController::class, 'index'])->name('hierarchy');

        Route::post('/positions/{position}/authorize', [RelationController::class, 'authorizePosition'])->name('positions.authorize');
        Route::put('/positions/{position}/unauthorize', [RelationController::class, 'unauthorizePosition'])->name('positions.unauthorize');
    });
});
