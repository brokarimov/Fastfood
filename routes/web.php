<?php

use App\Http\Middleware\Check;
use App\Livewire\AttendanceComponent;
use App\Livewire\CategoryComponent;
use App\Livewire\DepartmentComponent;
use App\Livewire\EmployeeComponent;
use App\Livewire\FoodComponent;
use App\Livewire\LoginComponent;
use App\Livewire\MasalliqComponent;
use App\Livewire\OrderAdminComponent;
use App\Livewire\OrderResultComponent;
use App\Livewire\Ovqat;
use App\Livewire\OvqatMasalliqComponent;
use App\Livewire\QueuesComponent;
use App\Livewire\SalaryComponent;
use App\Livewire\UserComponent;
use App\Livewire\UserPageComponent;
use Illuminate\Support\Facades\Route;

Route::middleware([Check::class . ':admin'])->group(function () {
    Route::get('/category', CategoryComponent::class);
    Route::get('/food', FoodComponent::class);
    Route::get('/department', DepartmentComponent::class);
    Route::get('/users', UserComponent::class);
    Route::get('/employee', EmployeeComponent::class);
    Route::get('/attendance', AttendanceComponent::class);
    Route::get('/salary', SalaryComponent::class);
    Route::get('/logout', [LoginComponent::class, 'logout']);

});
Route::middleware([Check::class . ':admin,waiter,chef,manager'])->group(function () {
    Route::get('/order', OrderAdminComponent::class);
    Route::get('/logout', [LoginComponent::class, 'logout']);

});
Route::get('/login', LoginComponent::class);

Route::get('/', UserPageComponent::class);
Route::get('/queue', QueuesComponent::class);








