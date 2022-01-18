<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JwtController;
use Illuminate\Http\Request;
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
Route::middleware('auth:api')->get('/user', function(Request $request) {
    return $request->user();
});    
Route::group(['middleware'=>['jwt']], function ($router) {
    Route::post('logout',[JwtController::class,'logout']);
    Route::post('refresh',[JwtController::class,'refresh']);
    Route::get('profile',[JwtController::class,'profile']);
    Route::post('changepass',[JwtController::class,'changePassword']);
    Route::post('updateProfile',[JwtController::class,'updateProfile']);
    Route::post('useraddress',[JwtController::class,'userAddress']);
    Route::post('order',[JwtController::class,'order']);
    Route::post('orderproduct',[JwtController::class,'orderProduct']);
    Route::post('usedcoupon',[JwtController::class,'usedCoupon']);
    Route::get('viewOrder/{id}',[JwtController::class,'viewOrder']);
});

Route::post('login',[JwtController::class,'login']);
Route::post('register',[JwtController::class,'register']);
Route::post('contact',[JwtController::class,'contact']);
Route::get('banner',[JwtController::class,'banner']);
Route::get('category',[JwtController::class,'category']);
Route::get('category/{id}',[JwtController::class,'show']);
Route::get('product',[JwtController::class,'product']);
Route::get('productdetails/{id}',[JwtController::class,'productdetails']);
Route::get('coupon',[JwtController::class,'coupon']);
Route::get('cms',[JwtController::class,'cmslist']);
Route::get('cmsdetails/{id}',[JwtController::class,'cmsdetails']);
Route::post('wish',[JwtController::class,'storeWishlist']);
Route::get('wishlist/{id}',[JwtController::class,'wishlist']);
Route::get('wish/{id}',[JwtController::class,'destroyWishlist']);
Route::post('checkCoupon',[JwtController::class,'checkCoupon']);
Route::get('addresses/{id}',[JwtController::class,'myAdd']);
Route::delete('deladdress/{id}',[JwtController::class,'delmyAdd']);
Route::get('newsletter/{email}',[JwtController::class,'newsletter']);