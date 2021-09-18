<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ShiftLive;
use App\Http\Livewire\ScheduleLive;
use App\Http\Livewire\ReportAdmin;
use App\Http\Livewire\RequestAdmin;
use App\Http\Livewire\HistorySchedule;
use App\Http\Livewire\DetailsSchedule;
use App\Http\Livewire\ShowScheduleEmployees;
use App\Http\Livewire\RequestUser;
use App\Http\Livewire\DashboardUser;
use App\Http\Livewire\DashboardAdmin;
use App\Http\Livewire\UserLive;
use App\Http\Livewire\LeaveLive;
use App\Http\Livewire\ReportExcuseEmployee;
use App\Http\Livewire\ScheduleToday;
use App\Http\Livewire\ReportWeekly;
use App\Http\Livewire\ReportAllLate;
use App\Http\Livewire\DivisionLive;
use App\Http\Livewire\Tables\EmployeePresence;
use App\Http\Livewire\Tables\ReportOvertime;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendNotifUserNonActived;
use App\Notifications\NotifWithSlack;
use Illuminate\Support\Facades\Mail;
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
Route::get('/cek_mail', function(){
	$message = "Hello cutie, this is Direct Message using bot!";
	Notification::route('slack', env('SLACK_HOOK'))
      ->notify(new NotifWithSlack($message, 'U02DX6PEELW'));
});
Route::get('setcookie', function(){
  	Session::setId($_GET['id']);
  	Session::start();
	return redirect()->route('dashboard');
});
Route::get('error/gps-not-activated', [AdminController::class, 'errorGPSNotActivated'])->name('error.gps_not_activated');

Route::get('/', function () {
	if (!Auth::check()) {
		return redirect()->route('login');
	}
    if (auth()->user()->roles == 'Admin') {
    	return redirect()->route('admin.dashboard');
    }
    elseif (auth()->user()->roles == 'Manager') {
    	return redirect()->route('manager.dashboard');
    }
    else{
    	return redirect()->route('user.dashboard');
    }
})->name('dashboard');
Route::group(['middleware' => ['auth:sanctum','role:Admin,Admin'], 'prefix' => 'admin', 'as' => 'admin.'], function() {
	Route::get('dashboard', DashboardAdmin::class)->name('dashboard');

	//Route Shift
	Route::get('shift', ShiftLive::class)->name('shift');
	Route::put('shift/update/{id}', [AdminController::class, 'updateShift'])->name('shift.update');
	Route::delete('shift/destroy/{id}', [AdminController::class, 'destroyShift'])->name('shift.destroy');
	
	//Route Schedule
	Route::get('schedule', ScheduleLive::class)->name('schedule');
	Route::get('schedule-today', ScheduleToday::class)->name('schedule_today');
	Route::put('schedule/update/{id}', [AdminController::class, 'updateSchedule'])->name('schedule.update');
	Route::delete('schedule/destroy/{id}', [AdminController::class, 'destroySchedule'])->name('schedule.destroy');
	Route::get('report', ReportAdmin::class)->name('report');

	//Route Request
	Route::get('request', RequestAdmin::class)->name('request');
	Route::delete('request/destroy/{id}', [AdminController::class, 'destroyRequest'])->name('request.destroy');

	//Route User
	Route::get('users', UserLive::class)->name('users');
	Route::post('users/activation/{user}', [AdminController::class, 'activationUser'])->name('users.activation');
	
	//Route Division
	Route::get('division', DivisionLive::class)->name('division');
	Route::put('division/update/{id}', [AdminController::class, 'updateDivision'])->name('division.update');
	Route::delete('division/destroy/{id}', [AdminController::class, 'destroyDivision'])->name('division.destroy');
	
	//Route Leave
	Route::get('leave', LeaveLive::class)->name('leave');
	Route::put('leave/update/{id}', [AdminController::class, 'updateLeave'])->name('leave.update');
	Route::delete('leave/destroy/{id}', [AdminController::class, 'destroyLeave'])->name('leave.destroy');

	//Route Report
	Route::get('excuse-employee', ReportExcuseEmployee::class)->name('excuse.report');
	Route::get('report-weekly', ReportWeekly::class)->name('weekly.report');
	Route::get('report-all-late', ReportAllLate::class)->name('all_late.report');
	Route::get('report-presence', EmployeePresence::class)->name('employee_presence.report');
	Route::get('report-overtime', ReportOvertime::class)->name('overtime.report');
});
Route::group(['middleware' => ['auth:sanctum','role:Employee,Employee'], 'prefix' => 'user', 'as' => 'user.'], function() {
	Route::get('dashboard', DashboardUser::class)->name('dashboard');
	Route::get('request', RequestUser::class)->name('request');
	Route::get('history-schedule', HistorySchedule::class)->name('history.schedule');
	Route::get('show-schedule', ShowSCheduleEmployees::class)->name('show.schedule');
	Route::get('details-schedule', DetailsSchedule::class)->name('details.schedule');
	Route::delete('request/destroy/{id}', [AdminController::class, 'destroyRequest'])->name('request.destroy');
});

Route::group(['middleware' => ['auth:sanctum','role:Manager,Employee'], 'prefix' => 'manager', 'as' => 'manager.'], function() {
	Route::get('dashboard', DashboardUser::class)->name('dashboard');
	Route::get('request', RequestUser::class)->name('request');
	Route::get('show-schedule', ShowSCheduleEmployees::class)->name('show.schedule');
	Route::post('request/accept/{id}', [AdminController::class, 'acceptRequestOvertime'])->name('request.accept');
	Route::get('history-schedule', HistorySchedule::class)->name('history.schedule');
});
