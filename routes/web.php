<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SuppliersController;
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

require 'auth.php';

Route::group(['middleware' => ['auth']], function () {

    // Home and account

    Route::get('/', [HomeController::class,'index'])->name('home');
    Route::post('/search', [HomeController::class,'search'])->name('search');
    Route::get('account', [AccountController::class,'Account']);
    Route::post('account', [AccountController::class,'update']);

    // Product

    Route::get('/product/expired', [ProductController::class,'expired']);
    Route::get('/product/outstock', [ProductController::class,'outstock']);
    Route::get('product/pdf/{product}', [ProductController::class,'pdf'])->name('product.pdf');
    Route::resource('product', ProductController::class);
    Route::post('/product/search', [ProductController::class,'search']);
    Route::post('/product/sell', [ProductController::class,'sell']);

    // Category

    Route::resource('category', CategoryController::class,);

    // Sales

    Route::get('sales/invoice/{product}', [SalesController::class,'getInvoice'])->name('sales.invoice');
    Route::get('sales/pdf/{product}', [SalesController::class,'pdf'])->name('sales.pdf');
    Route::resource('sales', SalesController::class);
    Route::post('/sales/check', [SalesController::class,'check']);
    Route::post('/sales/bk', [SalesController::class,'bk']);
    Route::post('/sales/search', [SalesController::class,'search']);

    // Suppliers

    Route::resource('suppliers', SuppliersController::class);

    // Language

    Route::get('language/{locale}', [LanguageController::class,'index']);

    // Customers

    Route::get('customers/pdf/{customers}', [CustomersController::class,'pdf'])->name('customers.pdf');
    Route::resource('customers', CustomersController::class);
    Route::post('/customers/search', [CustomersController::class,'search']);

    // Setting

    Route::get('setting/lt', [SettingController::class,'lt'])->name('setting.lt');
    Route::get('setting/printer', [SettingController::class,'printer'])->name('setting.printer');
    Route::get('setting/other', [SettingController::class,'other'])->name('setting.other');

    Route::match(['PUT','PATCH'], 'setting/lt/{setting}', [
        'uses'  => [SettingController::class,'ltUpdate'],
        'as'    =>    'setting.ltUpdate',
    ]);
    Route::match(['PUT','PATCH'], 'setting/printer/{setting}', [
        'uses'  => [SettingController::class,'printerUpdate'],
        'as'    => 'setting.printerUpdate'
    ]);
    Route::match(['PUT','PATCH'], 'setting/other/{setting}', [
        'uses'  => [SettingController::class,'otherUpdate'],
        'as'    => 'setting.otherUpdate'
    ]);


    // Tools

    Route::get('tools/discount', 'ToolsController@discount')->name('tools.discount');
    Route::get('tools/dsearch', 'ToolsController@dsearch')->name('tools.dsearch');
    Route::get('tools/note', 'ToolsController@note')->name('tools.note');
    Route::post('tools', [
        'uses'  => 'ToolsController@noteStore',
        'as'    => 'tools.noteStore'
    ]);
    Route::match(['PUT','PATCH'], 'tools/note/{note}', [
        'uses'  => 'ToolsController@noteUpdate',
        'as'    => 'tools.noteUpdate'
    ]);
    Route::delete('tools/note/{note}', 'ToolsController@noteDestroy')->name('tools.noteDestroy');

    //Backups
    Route::get('setting/backup/get/{filename}', [
        'as' => 'backup.download',
        'uses' => 'BackupController@backupDownload']);
    Route::get('setting/backup', 'BackupController@backup')->name('setting.backup');
    Route::post('setting', 'BackupController@backupStore')->name('setting.backupStore');
    Route::delete('setting/backups/{setting}', 'BackupController@backupDestroy')->name('setting.backupDestroy');

    // Users

    Route::resource('users', \App\Http\Controllers\UsersController::class);

    // Analysis

    Route::get('analysis', 'AnalysisController@index');
    Route::get('analysis/sales', 'AnalysisController@sales');
    Route::get('analysis/purchases', 'AnalysisController@purchases');
    Route::get('analysis/customers', 'AnalysisController@customers');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

