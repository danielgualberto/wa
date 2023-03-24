<?php


use App\Http\Controllers\Admin\ManageIntegrationController;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\PerksController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;

Route::get('generate', function (){
return \Illuminate\Support\Facades\Artisan::call('storage:link');
  echo 'ok';
});
Route::get('schedule-run', function () {
  return Illuminate\Support\Facades\Artisan::call('schedule:run');
});

Route::get('/perks', function () {
    return view('pages.perks');
})->name('perks');

Route::get('/integration', [IntegrationController::class, 'index'])->name('integration');
Route::get('/integration/update/{id}', [IntegrationController::class, 'details'])->name('integration_details');
Route::put('/integration/update/{id}', [IntegrationController::class, 'update'])->name('integration_update');
Route::get('/integration/add', [IntegrationController::class, 'add'])->name('integration_add');
Route::post('/integration/save', [IntegrationController::class, 'save'])->name('integration_save');
Route::delete('/integration/{id}', [IntegrationController::class, 'destroy'])->name('integration_delete');

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => AdminMiddleware::class
    ], function(){
        Route::get('/manage-integration', [ManageIntegrationController::class, 'index'])->name('manage_integration');
        Route::get('/manage-integration/integration/{id}', [ManageIntegrationController::class, 'details'])->name('manage_integration_details');
        Route::put('/manage-integration/integration/{id}', [ManageIntegrationController::class, 'update'])->name('manage_integration_update');
        Route::get('/manage-integration/add', [ManageIntegrationController::class, 'add'])->name('manage_integration_add');
        Route::post('/manage-integration/save', [ManageIntegrationController::class, 'save'])->name('manage_integrationn_save');
        Route::delete('/manage-integration/{id}', [ManageIntegrationController::class, 'destroy'])->name('manage_integration_delete');
});



// Route::prefix('/requesthttp')->group(function(){
//   Route::resource('/manage-integration', ManageIntegration::class);
//   Route::get('/continuacaoreq', [ManageIntegrationController::class, 'index'])->name('admin.manage_integration');
// });

?>
