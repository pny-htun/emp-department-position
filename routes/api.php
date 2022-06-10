<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('departments')->namespace('DepartmentPosition')->group(function () {
    Route::get('get', 'DepartmentPositionRegistrationController@getAllDepartments');
    Route::post('create', 'DepartmentPositionRegistrationController@createDepartment');
    Route::put('update', 'DepartmentPositionRegistrationController@updateDepartment');
    Route::delete('delete', 'DepartmentPositionRegistrationController@deleteDepartment');
});

Route::prefix('positions')->namespace('DepartmentPosition')->group(function () {
    Route::get('get', 'DepartmentPositionRegistrationController@getAllPositions');
    Route::post('create', 'DepartmentPositionRegistrationController@createPosition');
    Route::put('update', 'DepartmentPositionRegistrationController@updatePosition');
    Route::delete('delete', 'DepartmentPositionRegistrationController@deletePosition');
});

Route::prefix('dept-pos')->namespace('DepartmentPosition')->group(function () {
    Route::get('get', 'DepartmentPositionRegistrationController@getDeptPosition');
    Route::post('create', 'DepartmentPositionRegistrationController@createDeptPosition');
    Route::delete('{id}/delete', 'DepartmentPositionRegistrationController@destoryDeptPosition');
    Route::get('{id}/pair', 'DepartmentPositionRegistrationController@getPositionByDepartment');
});

Route::prefix('employees')->namespace('Employee')->group(function () {
    Route::post('search', 'EmployeeController@searchEmployee');
    Route::post('register', 'EmployeeController@registerEmployee');
    Route::get('{id}/detail', 'EmployeeController@detailEmployee');    
    Route::put('{id}/update', 'EmployeeController@updateEmployee');
    Route::delete('{id}/delete', 'EmployeeController@deleteEmployee');
});

