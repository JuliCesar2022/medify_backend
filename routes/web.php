<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsApp\WhatsAppController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return redirect("/admin");
});

Route::get('/admin/whatsApp',[WhatsAppController::class, 'index']);

Route::get('/whatsApp',[WhatsAppController::class, 'index']);

Route::get( 'admin', App\Http\Controllers\Dashboards\DashboardsController::class );
Route::get( 'make-moviment', [App\Http\Controllers\WalletControllerView::class, 'makeMoviment'] );

//CURD SERVICES
Route::get( 'services', [App\Http\Controllers\ServicesCurd::class, 'index']);
Route::get( 'admin/services', [App\Http\Controllers\ServicesCurd::class,'index' ]);

Route::get( 'services/add', [App\Http\Controllers\ServicesCurd::class, 'from']);
Route::get( 'admin/services/add', [App\Http\Controllers\ServicesCurd::class,'from' ]);


Route::get( 'services/save', [App\Http\Controllers\ServicesCurd::class, 'save']);
Route::get( 'admin/services/save', [App\Http\Controllers\ServicesCurd::class,'save' ]);

Route::get( 'services/edit/{id}', [App\Http\Controllers\ServicesCurd::class, 'update']);
Route::get( 'admin/services/edit/{id}', [App\Http\Controllers\ServicesCurd::class,'update' ]);

Route::get( 'services/delete/{id}', [App\Http\Controllers\ServicesCurd::class, 'delete']);
Route::get( 'admin/services/delete/{id}', [App\Http\Controllers\ServicesCurd::class,'delete' ]);

Route::get( 'services/detail/{id}', [App\Http\Controllers\ServicesCurd::class, 'detail']);
Route::get( 'admin/services/detail/{id}', [App\Http\Controllers\ServicesCurd::class,'detail' ]);



//CURD notificaciones
Route::get( 'notificaciones', [App\Http\Controllers\ScheduledNotificationsController::class, 'index']);
Route::get( 'admin/notificaciones', [App\Http\Controllers\ScheduledNotificationsController::class,'index' ]);

Route::get( 'notificaciones/add', [App\Http\Controllers\ScheduledNotificationsController::class, 'from']);
Route::get( 'admin/notificaciones/add', [App\Http\Controllers\ScheduledNotificationsController::class,'from' ]);


Route::get( 'notificaciones/save', [App\Http\Controllers\ScheduledNotificationsController::class, 'save']);
Route::get( 'admin/notificaciones/save', [App\Http\Controllers\ScheduledNotificationsController::class,'save' ]);

Route::get( 'notificaciones/edit/{id}', [App\Http\Controllers\ScheduledNotificationsController::class, 'update']);
Route::get( 'admin/notificaciones/edit/{id}', [App\Http\Controllers\ScheduledNotificationsController::class,'update' ]);

Route::get( 'notificaciones/delete/{id}', [App\Http\Controllers\ScheduledNotificationsController::class, 'delete']);
Route::get( 'admin/notificaciones/delete/{id}', [App\Http\Controllers\ScheduledNotificationsController::class,'delete' ]);

Route::get( 'notificaciones/detail/{id}', [App\Http\Controllers\ScheduledNotificationsController::class, 'detail']);
Route::get( 'admin/notificaciones/detail/{id}', [App\Http\Controllers\ScheduledNotificationsController::class,'detail' ]);

Route::get('/professions', [\App\Http\Controllers\Api\ProfessionsController::class, 'index']);
