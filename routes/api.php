<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthUserController;
use App\Http\Controllers\MailController;
use App\Mail\AuthMailable;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AuthMailController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Device\DeviceController;
use App\Http\Controllers\Invoice\InvoiceController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\SegmentController;
use App\Models\Product\Subcategory;
use App\Http\Controllers\Product\SubcategoryController;
use App\Http\Controllers\Sensor\Fingerprint\FingerprintEntryController;
use App\Http\Controllers\Sensor\Fingerprint\FingerprintUserController;
use App\Http\Controllers\Sensor\RelayEventController;
use App\Http\Controllers\Socket\SocketIOController;
use App\Models\Product\Segment;
use App\Models\Sensor\RelayEvent;
use App\Http\Controllers\Sensor\RelayController;
use App\Models\Sensor\Fingerprint\FingerprintEntry;

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

//php artisan serve --host 192.168.1.104 --port 8000
/**
 * Token DRL1: 90e365d710e274a96030
 * Token DDA1: 8a2566b2ffbc9e3f75b0
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(AuthUserController::class)->group(function () {
    Route::post('/user/login', 'login');
    Route::get('/user/logout', 'logout')->middleware('auth:sanctum');;
    Route::post('/user/changePassword', 'changePassword');
    Route::post('/user/create', 'create');
    Route::post('/userMobile/create', 'createUserMobile');
    Route::post('/userMobile/login', 'loginMobile');
    Route::post('/user/createUser', 'createUser');
    Route::get("/user/isAuthenticated", 'isAuthenticated')->middleware('auth:sanctum');
    Route::get('/user/validateUserToken/{user_token?}', 'validateUserToken');
    Route::post('/user/socket', 'saveIdSocket');
    Route::get('/user/socket/socketRoom/{user_token?}', 'getSocketRoom');
    Route::get('/user/getUserToken/{device_token?}', 'getUserToken');
    
});


Route::controller(SocketIOController::class)->group(function () {
    Route::get('/socketio/device/{device_token?}', 'getDevice');//Get info device
    Route::get('/socketio/user/device/{user_token?}/{id_device?}', 'getDeviceUser');//go over
    Route::get('/socketio/device/user/{device_token?}', 'getUserDevice');
    Route::post('/socketio/device/saveIdSocket', 'saveDeviceIdSocket');
});

Route::get('/user/validateEmail/{hash?}', [AuthUserController::class, 'validateEmail']);
//Route::get('/user/getUsers', [UserController::class, 'getUsers'])->middleware('auth:sanctum');
Route::get('/user/getUsers', [UserController::class, 'getUsers']);
Route::get('/user/assignPermissions', [UserController::class, 'assignPermissions']);

Route::get('/user/getAuthenticatedUser', [UserController::class, 'getAuthenticatedUser'])->middleware('auth:sanctum');


Route::controller(DeviceController::class)->group(function () {
    Route::post('/device/store', 'store')->middleware('auth:sanctum');
    Route::post('/device/update/{id_device?}', 'update')->middleware('auth:sanctum');
    Route::get('/device', 'index')->middleware('auth:sanctum');
    Route::get('/device/{id?}', 'show')->middleware('auth:sanctum');
    Route::get('device/delete/{id_device?}', 'destroy')->middleware('auth:sanctum');
});


Route::controller(RelayEventController::class)->group(function () {
    Route::post('/relayEvent/store', 'store')->middleware('auth:sanctum');
    Route::get('/relayEvent/{id_device?}', 'index')->middleware('auth:sanctum');
});


Route::controller(RelayController::class)->group(function () {
    Route::get('/relay/{id_device?}', 'index')->middleware('auth:sanctum');
});


Route::controller(FingerprintUserController::class)->group(function () {
    Route::post('/fingeprintUser/store', 'store')->middleware('auth:sanctum');
    Route::get('/fingeprintUser/{id_device?}', 'index')->middleware('auth:sanctum');
    Route::post('/fingeprintUser/changeState', 'changeStateUser')->middleware('auth:sanctum');
    Route::post('/fingeprintUser/enrollEntry', 'enrollEntry'); //It called from socketio server
});

Route::controller(FingerprintEntryController::class)->group(function () {
    Route::get('/fingerprintEntry/{id_device?}', 'index')->middleware('auth:sanctum');
});



















Route::get("/product/getCategories", [CategoryController::class, 'getCategories'])->middleware(['auth:sanctum', 'can:detailProducts.index']);
Route::post("/product/addCategory", [CategoryController::class, 'addCategory']);
Route::post("/product/updateCategory", [CategoryController::class, 'updateCategory']);

Route::get("/product/getSubcategories", [SubcategoryController::class, 'getSubcategories']);
Route::get("/product/getSegments", [SegmentController::class, 'getSegments']);

Route::post("/product/addProduct", [ProductController::class, 'addProduct']);
Route::post("/product/updateProduct", [ProductController::class, 'updateProduct']);
Route::get("/product/getProducts", [ProductController::class, 'getProducts']);
Route::get("/product/getSearchProducts/{product?}", [ProductController::class, 'getSearchProducts']);
Route::get("/product/getProductByBarcode/{barcode?}", [ProductController::class, 'getProductByBarcode']);






Route::post("/user/updateRoleUser", [UserController::class, 'updateRoleUser']);

Route::post("/customer/addCustomer", [CustomerController::class, 'addCustomer']);
Route::get("/customer/findCustomer/{idCustomer?}", [CustomerController::class, 'findCustomer']);

Route::post("/invoice/saveInvoice", [InvoiceController::class, 'saveInvoice']);
Route::post("/invoice/addInvoiceDetail", [InvoiceController::class, 'addInvoiceDetail']);

Route::get("/invoice/getInvoiceInProgress/{idInvoice?}", [InvoiceController::class, 'getInvoiceInprogress']);
Route::get("/invoice/getProductsInvoiceInprogress/{id_invoice?}", [InvoiceController::class, 'getProductsInvoiceInprogress']);
Route::post("/invoice/deleteInvoiceInProgress", [InvoiceController::class, 'deleteInvoiceInProgress']);
Route::post("/invoice/finishSale", [InvoiceController::class, 'finishSale']);

Route::get("/invoice/getInvoice/{idInvoice?}", [InvoiceController::class, 'getInvoice']);


Route::get('/user/template', function() {
    return view('emails.TestEmail');
});

Route::view('/user/template2', 'emails.TestEmail', ['details' => 'pppp']);
//Route::view('/user/template2', 'test', ['details' => 'pppp']);

/* Route::post('/user/create', function() {
    return 'mensa';
} ); */