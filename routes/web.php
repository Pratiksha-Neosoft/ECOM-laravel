<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CmsController;
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

Route::get('admin',[UserController::class,'index']);
Route::post('admin/auth',[UserController::class,'auth'])->name('admin.auth');
Route::group(['middleware'=>'admin_auth'],function(){
    Route::get('admin/dashboard',[UserController::class,'dashboard']);
    Route::get('admin/logout', function () {
        session()->forget('LOGIN');
        session()->forget('ID');
        return redirect('admin');
    });
	Route::get('admin/user/view',[UserController::class,'viewuser']);
    Route::get('admin/user/add',[UserController::class,'adduser']);
    Route::post('admin/user/postadd',[UserController::class,'postadduser']);
    Route::get('admin/user/update/{id}',[UserController::class,'updateuser']);
    Route::post('admin/user/postupdate',[UserController::class,'postupdateuser']);
    Route::get('admin/user/delete/{id}',[UserController::class,'deleteuser']);
    
    Route::get('admin/category',[CategoryController::class,'index']);
    Route::get('admin/category/add',[CategoryController::class,'addCategory']);
    Route::post('admin/category/insert',[CategoryController::class,'insertCategory'])->name('category.insert');
    Route::get('admin/category/update/{cat_slug}',[CategoryController::class,'updatecat']);
    Route::post('admin/category/postupdate/{cat_slug}',[CategoryController::class,'postupdatecat']);
    Route::get('admin/category/delete/{cat_slug}',[CategoryController::class,'deletecat']);
    
    	// Admin Products Routes
	Route::match(['get','post'],'/admin/add-product',[ProductController::class,'addProduct']);
	Route::match(['get','post'],'/admin/edit-product/{id}',[ProductController::class,'editProduct']);
	Route::get('/admin/delete-product/{id}',[ProductController::class,'deleteProduct']);
	Route::get('/admin/view-products',[ProductController::class,'viewProducts']);
	Route::get('/admin/export-products',[ProductController::class,'exportProducts']);
	Route::get('/admin/delete-product-image/{id}',[ProductController::class,'deleteProductImage']);
	Route::get('/admin/delete-product-video/{id}',[ProductController::class,'deleteProductVideo']);
	
	Route::match(['get', 'post'], '/admin/add-images/{id}',[ProductController::class,'addImages']);
	Route::get('/admin/delete-alt-image/{id}',[ProductController::class,'deleteProductAltImage']);

	// Admin Attributes Routes
	Route::match(['get', 'post'], '/admin/add-attributes/{id}',[ProductController::class,'addAttributes']);
	Route::match(['get', 'post'], '/admin/edit-attributes/{id}',[ProductController::class,'editAttributes']);
	Route::get('/admin/delete-attribute/{id}',[ProductController::class,'deleteAttribute']);

    
    Route::match(['get','post'],'/admin/add-coupon',[CouponController::class,'addCoupon']);
	Route::match(['get','post'],'/admin/edit-coupon/{id}',[CouponController::class,'editCoupon']);
	Route::get('/admin/view-coupons',[CouponController::class,'viewCoupons']);
	Route::get('/admin/delete-coupon/{id}',[CouponController::class,'deleteCoupon']);

    Route::match(['get','post'],'/admin/add-banner',[BannerController::class,'addBanner']);
	Route::match(['get','post'],'/admin/edit-banner/{id}',[BannerController::class,'editBanner']);
	Route::get('admin/view-banners',[BannerController::class,'viewBanners']);
	Route::get('/admin/delete-banner/{id}',[BannerController::class,'deleteBanner']);

    Route::match(['get','post'],'/admin/add-cms',[CmsController::class,'addCms']);
	Route::match(['get','post'],'/admin/edit-cms/{id}',[CmsController::class,'editCms']);
	Route::get('admin/view-cms',[CmsController::class,'viewCms']);
	Route::get('/admin/delete-cms/{id}',[CmsController::class,'deleteCms']);

    Route::get('/admin/view-enquiries',[ContactController::class,'viewEnquiries']);

	Route::get('admin/view-orders',[ProductController::class,'viewOrder']);
	Route::post('status/update',[ProductController::class,'updateStatus']);
	Route::get('report',[UserController::class,'report']);
	Route::get('downloadUser',[UserController::class,'exportCsv']);
	Route::get('downloadOrder',[ProductController::class,'exportCsv']);
	Route::get('downloadCoupon',[CouponController::class,'exportCsv']);
});