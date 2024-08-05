<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RelationController;
use App\Http\Controllers\TasklistController;
use App\Http\Controllers\HierarchyController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TimeExtensionController;

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
    Route::get('/login', [AuthController::class, 'index'])->name('auth.index');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/', [DashboardController::class, 'index'])->name('homepage');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead']);

    Route::group(['middleware' => 'role:superadmin'], function () {
        Route::get('/account/{user}/settings', [AccountController::class, 'settings'])->name('account.settings');
        Route::get('/account/{user}/permissions', [AccountController::class, 'managePermissions'])->name('account.manage-permissions');
        Route::put('/account/{user}/permissions-update', [AccountController::class, 'updatePermissions'])->name('account.update-permissions');
    });

    // Route::group(['as' => 'taskscore.', 'prefix' => 'task-score'], function () {
    Route::group(['as' => 'taskscore.'], function () {
        Route::get('/my-assignments', [AssignmentController::class, 'myAssignment'])->name('assignment.my-assignments');
        Route::get('/subordinate-assignments', [AssignmentController::class, 'subordinateAssignment'])->name('assignment.subordinate-assignments');
        Route::get('/tasklists', [TasklistController::class, 'index'])->name('assignment.tasklists');
        Route::post('/store-assignment', [AssignmentController::class, 'store'])->name('assignment.store');

        Route::group(['middleware' => 'involved'], function () {
            Route::get('/assignment/{assignment}', [AssignmentController::class, 'show'])->name('assignment.show');
            Route::put('/{assignment}/update-assignment', [AssignmentController::class, 'update'])->name('assignment.update');
            Route::delete('/assignment/{assignment}/delete', [AssignmentController::class, 'delete'])->name('assignment.delete');
            Route::put('/{assignment}/close', [AssignmentController::class, 'close'])->name('assignment.close');
            Route::put('/{assignment}/open', [AssignmentController::class, 'open'])->name('assignment.open');
        });

        Route::post('/{task}/resolve', [AssignmentController::class, 'resolve'])->name('assignment.resolve');

        Route::put('/{submission}/submission-approval', [SubmissionController::class, 'approve'])->name('assignment.approve-submission');
        Route::put('/{submission}/submission-rejection', [SubmissionController::class, 'reject'])->name('assignment.reject-submission');
        Route::delete('/{submission}/submission-rollback', [SubmissionController::class, 'rollback'])->name('assignment.rollback-submission');

        Route::post('/{timeExtension}/time-extension-request', [TimeExtensionController::class, 'store'])->name('assignment.time-extension-request');
        Route::put('/{timeExtension}/time-extension-reject', [TimeExtensionController::class, 'reject'])->name('assignment.time-extension-reject');
        Route::put('/{timeExtension}/time-extension-approve', [TimeExtensionController::class, 'approve'])->name('assignment.time-extension-approve');
    });

    Route::group(['middleware' => 'permission:manage_user'], function () {
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
