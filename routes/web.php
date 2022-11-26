<?php

use App\Http\Controllers\Admin\AgeGroupController;
use App\Http\Controllers\Admin\AtributeProcessingController;
use App\Http\Controllers\Admin\AtributeStitchingController;
use App\Http\Controllers\Admin\AtributeWeavingController;
use App\Http\Controllers\Admin\AtributeYarnController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FabricTypeController;
use App\Http\Controllers\Admin\LoomTypeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PermissionGroupController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\front\HomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class,'index'])->name('main');
Route::group(['middleware' => ['auth','verified','IsActive','xss'],'prefix'=>'admin'], function() {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    //Permissions
    Route::resource('permission_group',PermissionGroupController::class);
    Route::resource('permission',PermissionController::class);
    //Roles
    Route::resource('role',RoleController::class);
    Route::get('get/roles',[RoleController::class,'getRoles'])->name('getRoles');
    //User
    Route::resource('user',UserController::class);
    Route::get('get/users',[UserController::class,'getUsers'])->name('getUsers');
    //Category
    Route::resource('category',CategoryController::class);
    Route::get('get/categories',[CategoryController::class,'getCategories'])->name('getCategories');
    //Season
    Route::resource('season',SeasonController::class);
    Route::get('get/seasons',[SeasonController::class,'getSeasons'])->name('getSeasons');
    //Age Group
    Route::resource('age-group',AgeGroupController::class);
    Route::get('get/age-groups',[AgeGroupController::class,'getAgeGroups'])->name('getAgeGroups');
    //Country
    Route::resource('country',CountryController::class);
    Route::get('get/countries',[CountryController::class,'getCountries'])->name('getCountries');
    //Regions
    Route::resource('region',RegionController::class);
    Route::get('get/regions',[RegionController::class,'getRegions'])->name('getRegions');
    //Customers
    Route::resource('customer',CustomerController::class);
    Route::get('get/customers',[CustomerController::class,'getCustomers'])->name('getCustomers');
    //Loom Type
    Route::resource('loom-type',LoomTypeController::class);
    Route::get('get/loom-types',[LoomTypeController::class,'getLoomTypes'])->name('getLoomTypes');
    //Attribute Yarn
    Route::resource('atribute-yarn',AtributeYarnController::class);
    Route::get('get/atribute-yarns',[AtributeYarnController::class,'getAtributeYarn'])->name('getAtributeYarn');
    //Attribute Weaving
    Route::resource('atribute-weaving',AtributeWeavingController::class);
    Route::get('get/atribute-weavings',[AtributeWeavingController::class,'getAtributeWeaving'])->name('getAtributeWeaving');
    //Attribute Processing
    Route::resource('atribute-processing',AtributeProcessingController::class);
    Route::get('get/atribute-processings',[AtributeProcessingController::class,'getAtributeProcessing'])->name('getAtributeProcessing');
    //Attribute Stitching
    Route::resource('atribute-stitching',AtributeStitchingController::class);
    Route::get('get/atribute-stitchings',[AtributeStitchingController::class,'getAtributeStitching'])->name('getAtributeStitching');
    //Fabric Type
    Route::resource('fabric-type',FabricTypeController::class);
    Route::get('get/fabric-types',[FabricTypeController::class,'getFabricType'])->name('getFabricType');
    //Product
    Route::resource('product',ProductController::class);
    Route::get('get/products',[ProductController::class,'getProducts'])->name('getProducts');
});
Route::get('/logout', function () {
    Auth::logout();
    return redirect(route('login'));
});
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
  ]);

