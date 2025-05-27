<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ConsumeController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\AutomationController;
use App\Http\Controllers\MQTTController;
use App\Http\Controllers\AlertReportController;
use App\Http\Controllers\Api\DeviceDataController;
use Illuminate\Support\Facades\Artisan;


Route::get('/', function () {
    return view('welcome');
});

/* principal */
Route::get('/dashboard', [DashboardController::class, 'index'])
     ->middleware(['auth', 'verified'])
     ->name('dashboard');

     /* section dispositivos */
Route::get('/dispositivos', [DeviceController::class, 'index'])
    ->middleware(['auth'])
    ->name('devices.index');
Route::put('/dispositivos/{device}/toggle', [DeviceController::class, 'toggle'])->name('devices.toggle');
Route::get('/dispositivos/{device}/edit', [DeviceController::class, 'edit'])->name('devices.edit');
Route::put('/dispositivos/{device}', [DeviceController::class, 'update'])->name('devices.update');
Route::get('/dispositivos/crear', [DeviceController::class, 'create'])->name('devices.create');
Route::post('/dispositivos', [DeviceController::class, 'store'])->name('devices.store');
Route::delete('/dispositivos/{device}', [DeviceController::class, 'destroy'])->name('devices.destroy');
    
    /* section consumes */
Route::get('/dispositivos/{device}/consumo', [ConsumeController::class, 'show'])
    ->name('consumes.show');

    /* alertas */
Route::get('/alertas', [AlertController::class, 'index'])->middleware(['auth'])->name('alerts.index');
Route::delete('/alertas/limpiar', [AlertController::class, 'clear'])->middleware(['auth'])->name('alerts.clear');

    /* records */
Route::get('/historial', [RecordController::class, 'index'])->middleware('auth')->name('records.index');

    /* automatizaciones */
Route::resource('automations', AutomationController::class)->middleware('auth');

/* NODE-RED en local aun en ajustes */
Route::get('/mqtt/publish', [MQTTController::class, 'publishMessage']);
Route::get('/mqtt/subscribe', [MQTTController::class, 'subscribeMessage']);

/*  exportacion de PDF */
Route::get('/report/alerts/pdf', [AlertReportController::class, 'exportPdf'])->name('report.alerts.pdf');

/* API */
// Rutas API
Route::post('/api/device/data', [DeviceDataController::class, 'receiveData'])->name('device.data');

Route::post('/ejecutar-analisis-ia', function () {
    Artisan::call('ai:analizar-datos');
    return redirect()->back()->with('success', 'Análisis ejecutado correctamente.');
})->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
