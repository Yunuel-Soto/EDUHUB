<?php

use App\Http\Controllers\AssistanceController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherScheduleController;
use App\Http\Controllers\ViewsController;
use App\Models\Assistance;
use App\Models\Health;
use App\Models\TeacherSchedule;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Routing\ViewController;
use Illuminate\Support\Facades\Route;

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

Route::controller(ViewsController::class)->group(function() {
    $domain = '/EDUHUB';
    Route::get($domain, 'showLogin')->name('shLogin');
    Route::get($domain . '/SingIn', 'showSing')->name('shSing');
    Route::get($domain . '/Home', 'home')->name('home');
    Route::get($domain . '/Create/User', 'createUser')->name('create_user');
    Route::get($domain . '/Catalogos', 'catalogos')->name('catalogos');
});

Route::controller(TeacherController::class)->group(function() {
    $domain = '/EDUHUB';
    Route::post($domain . '/Login', 'login')->name('login');
    Route::post($domain . '/SingIn', 'singIn')->name('singIn');
    Route::get($domain . '/logout', 'logout')->name('logout');
    Route::post($domain . '/Register/New/User', 'registerTeacher')->name('registerTeacher');
    Route::get($domain . '/Users', 'index')->name('indexUser');
    route::delete($domain . '/Delete/Teacher/{teacher}', 'destroy')->name('deleteTeacher');
    route::put($domain . '/Update/Teacher/{teacher}', 'update')->name('updateTeacher');
});

Route::controller(CareerController::class)->group(function() {
    $domain = '/EDUHUB';
    Route::get($domain . '/Catalogs', 'index')->name('indexCatalogs');
    Route::post($domain . '/New/Career', 'create')->name('createCareer');
    Route::delete($domain . '/Delete/{career}', 'destroy')->name('deleteCareer');
    Route::put($domain . '/Update/Career/{career}', 'update')->name('updateCareer');
});

Route::controller(SubjectController::class)->group(function() {
    $domain = '/EDUHUB';
    Route::post($domain . '/New/Subject', 'create')->name('createSubject');
    Route::delete($domain . '/Delete/Subject/{subject}', 'destroy')->name('deleteSubject');
    Route::put($domain . '/Update/Subject/{subject}', 'update')->name('updateSubject');
});

Route::controller(GroupsController::class)->group(function() {
    $domain = '/EDUHUB';
    Route::post($domain . '/New/Gruop', 'create')->name('createGroup');
    Route::delete($domain . '/Delete/Group/{group}', 'destroy')->name('deleteGroup');
    Route::put($domain . '/Update/Group/{group}', 'update')->name('updateGroup');
});

Route::controller(StudentController::class)->group(function() {
    $domain = '/EDUHUB';
    Route::post($domain . '/Create/Student', 'create')->name('createStudent');
    Route::put($domain . '/Update/Student/{student}', 'update')->name('updateStudent');
    Route::delete($domain . '/Delete/Student/{student}', 'destroy')->name('deleteStudent');
});

Route::controller(HealthController::class)->group(function() {
    $domain = '/EDUHUB';
    Route::get($domain . '/Health', 'index')->name('indexHealth');
    Route::post($domain . '/Create/Health', 'create')->name('createHealth');
    Route::delete($domain . '/Delete/Health/{health}', 'destroy')->name('deleteHealth');
    Route::put($domain . '/Update/Health/{health}', 'update')->name('updateHealth');
});

Route::controller(TeacherScheduleController::class)->group(function() {
    $domain = '/EDUHUB';
    Route::get($domain . '/Assignments', 'index')->name('indexAssignments');
    Route::post($domain . '/Create/Schedule', 'create')->name('createSchedule');
    Route::get($domain . '/Schedule/Teachers', 'scheduleTeacher')->name('scheduleTeacher');
    Route::post($domain . '/Schedule/Teachers/Edit', 'edit')->name('editSchedule');
    Route::put($domain . '/Schedule/Teacher/Update', 'update')->name('scheduleUpdate');
    Route::get($domain . '/Schedule/Students', 'scheduleStudent')->name('scheduleStudent');
});

Route::controller(AssistanceController::class)->group(function() {
    $domain = '/EDUHUB';
    Route::get($domain . '/Assistances', 'index')->name('indexAssistances');
    Route::post($domain . '/Assistance/Save/{group}/{subject}/{student}/{day}', 'createAssistance')->name('createAssistance');
});