<?php

use Illuminate\Support\Facades\Route;

Route::get('', function () {
    if (session()->has('id')) {
        return redirect('/admin/dashboard');
    } else {
        return redirect('/admin');
    }
});


// Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'index']);
Route::get('/admin', [App\Http\Controllers\Auth\LoginController::class, 'index']);
Route::get('/admin/login', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
Route::post('/admin/auth/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);



Route::group(['prefix' => 'admin', 'middleware' => ['auth','CheckSession']], function () {

      // Dashboard
    Route::get('dashboard/list', function () {return redirect('admin/dashboard');});
    Route::get('dashboard', [App\Http\Controllers\admin\DashboardController::class, 'dashboard']);


    /* * User Management
     */
    // Route::get('/', 'UserController@index');
    Route::prefix('user')->group(function () {
        Route::get('list', [App\Http\Controllers\admin\UserController::class, 'index']);
        Route::any('add', [App\Http\Controllers\admin\UserController::class, 'addUser']);
        Route::any('edit/{id}', [App\Http\Controllers\admin\UserController::class, 'editUser']);
        Route::any('delete/{id}', [App\Http\Controllers\admin\UserController::class, 'deleteUser']);
        Route::any('update-status/{id}/{status}', [App\Http\Controllers\admin\UserController::class, 'updateStatus']);

    // Route::any('/users/change-password/{id}', 'UserController@checkPassword')->name('change-password');
        Route::any('change-password/{id}', [App\Http\Controllers\admin\UserController::class, 'checkPassword'])->name('change-password');


    });

        /**
     * Roles
     */
    Route::prefix('role')->group(function () {
        Route::get('list', [App\Http\Controllers\admin\RoleController::class, 'index']);
        Route::any('permissions/{role_id}', [App\Http\Controllers\admin\RoleController::class, 'permissions']);
        Route::any('edit/{role_id}', [App\Http\Controllers\admin\RoleController::class, 'edit']);
        Route::any('add', [App\Http\Controllers\admin\RoleController::class, 'add']);
    });

        /**
     * Settings
     */
    Route::any('/settings', [App\Http\Controllers\admin\SettingsController::class, 'index']);
    Route::any('/settings/list', [App\Http\Controllers\admin\SettingsController::class, 'index']);



    /**
     * Module
     */
    Route::prefix('module')->group(function () {
        Route::get('list', [App\Http\Controllers\admin\ModuleController::class, 'index']);
        Route::any('add', [App\Http\Controllers\admin\ModuleController::class, 'add']);
        Route::any('template', [App\Http\Controllers\admin\ModuleController::class, 'template']);
        Route::any('edit/{id}', [App\Http\Controllers\admin\ModuleController::class, 'edit']);
        Route::any('delete/{id}', [App\Http\Controllers\admin\ModuleController::class, 'delete']);
        Route::any('update-status/{id}/{status}', [App\Http\Controllers\admin\ModuleController::class, 'updateStatus']);
        // delete-icon
        Route::any('delete-icon/{id}', [App\Http\Controllers\admin\ModuleController::class, 'deleteIcon']);
    });


    // Dynamic Form
    Route::prefix('dynamic-form')->group(function () {
        Route::get('list', [App\Http\Controllers\admin\DynamicFormController::class, 'index']);
        Route::any('add', [App\Http\Controllers\admin\DynamicFormController::class, 'add']);
        Route::any('edit/{id}', [App\Http\Controllers\admin\DynamicFormController::class, 'edit']);
        Route::any('delete/{id}', [App\Http\Controllers\admin\DynamicFormController::class, 'delete']);
        Route::any('update-status/{id}/{status}', [App\Http\Controllers\admin\DynamicFormController::class, 'updateStatus']);
    });

    // Learning
    Route::prefix('learning')->group(function () {
        Route::get('list', [App\Http\Controllers\admin\LearningController::class, 'index']);
        Route::any('add', [App\Http\Controllers\admin\LearningController::class, 'add']);
        Route::any('edit/{id}', [App\Http\Controllers\admin\LearningController::class, 'edit']);
        Route::any('delete/{id}', [App\Http\Controllers\admin\LearningController::class, 'delete']);
        Route::any('update-status/{id}/{status}', [App\Http\Controllers\admin\LearningController::class, 'updateStatus']);
    });

    // Personal Information
    Route::prefix('personal-information')->group(function () {
        Route::get('list', [App\Http\Controllers\admin\PersonalDetailsController::class, 'index']);
        Route::any('add', [App\Http\Controllers\admin\PersonalDetailsController::class, 'add']);
        Route::any('edit/{id}', [App\Http\Controllers\admin\PersonalDetailsController::class, 'edit']);
        Route::any('view/{id}', [App\Http\Controllers\admin\PersonalDetailsController::class, 'view']);
        Route::any('delete/{id}', [App\Http\Controllers\admin\PersonalDetailsController::class, 'delete']);
        Route::any('update-status/{id}/{status}', [App\Http\Controllers\admin\PersonalDetailsController::class, 'updateStatus']);
    });

    // Driving License
    Route::prefix('driving')->group(function () {
        Route::get('list', [App\Http\Controllers\admin\DrivingController::class, 'index']);
        Route::any('add', [App\Http\Controllers\admin\DrivingController::class, 'add']);
        Route::any('edit/{id}', [App\Http\Controllers\admin\DrivingController::class, 'edit']);
        Route::any('delete/{id}', [App\Http\Controllers\admin\DrivingController::class, 'delete']);
        Route::any('update-status/{id}/{status}', [App\Http\Controllers\admin\DrivingController::class, 'updateStatus']);
    });

    // Renewal
    Route::prefix('renewal')->group(function () {
        Route::get('list', [App\Http\Controllers\admin\RenewalController::class, 'index']);
        Route::any('add', [App\Http\Controllers\admin\RenewalController::class, 'add']);
        Route::any('edit/{id}', [App\Http\Controllers\admin\RenewalController::class, 'edit']);
        Route::any('delete/{id}', [App\Http\Controllers\admin\RenewalController::class, 'delete']);
        Route::any('update-status/{id}/{status}', [App\Http\Controllers\admin\RenewalController::class, 'updateStatus']);
    });

    // Invoice
    Route::prefix('invoice')->group(function () {
        Route::get('list', [App\Http\Controllers\admin\InvoiceController::class, 'index']);
        Route::any('add', [App\Http\Controllers\admin\InvoiceController::class, 'add']);
        Route::any('edit/{id}', [App\Http\Controllers\admin\InvoiceController::class, 'edit']);
        Route::any('delete/{id}', [App\Http\Controllers\admin\InvoiceController::class, 'delete']);
        Route::any('update-status/{id}/{status}', [App\Http\Controllers\admin\InvoiceController::class, 'updateStatus']);
        Route::any('view/{id}', [App\Http\Controllers\admin\InvoiceController::class, 'view']);
        Route::any('generate-pdf/{id}', [App\Http\Controllers\admin\InvoiceController::class, 'generatePdf']);
        Route::any('generate-receipt/{id}', [App\Http\Controllers\admin\InvoiceController::class, 'generateReceipt']);
        Route::any('generate-receipt-pdf/{id}', [App\Http\Controllers\admin\InvoiceController::class, 'generateReceiptPdf']);
    });


    // product
    Route::prefix('product')->group(function () {
        Route::get('list', [App\Http\Controllers\admin\ProductController::class, 'index']);
        Route::any('add', [App\Http\Controllers\admin\ProductController::class, 'add']);
        Route::any('edit/{id}', [App\Http\Controllers\admin\ProductController::class, 'edit']);
        Route::any('delete/{id}', [App\Http\Controllers\admin\ProductController::class, 'delete']);
        Route::any('update-status/{id}/{status}', [App\Http\Controllers\admin\ProductController::class, 'updateStatus']);
    });


});

Route::get('optimize', function () {
    Artisan::call('optimize:clear');
    return 'optimized';
});





// Mail

use Illuminate\Support\Facades\Mail;


Route::get('/send-test-email', function () {
    $to = "shubham.bramhane75@gmail.com";
    Mail::send('emails.test', [], function ($message) use ($to) {
        $message->to($to)
            ->subject('Test Email');
    });

    return 'Test email sent!';
});
