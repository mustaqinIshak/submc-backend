<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

Route::post('/login', 'LoginController@login');
Route::post('/profileCompany', "CrasherController@getProfileCompany");
Route::post('/aboutUs', "CrasherController@getAboutUs");
Route::post('/bannerHome', "CrasherController@getBannerHome");
Route::post('/newItem', "CrasherController@getNewItem");
Route::post('/productById', "CrasherController@getProduk");
Route::post('/categorieProduct', "CrasherController@getCategorie");
Route::post('/subcategorieProduct', "CrasherController@getSubCategorie");
Route::post('/productByCategorie', "CrasherController@getByCategorie");
Route::post('/productByCmmApparel', "CrasherController@getProdukByCmm");
Route::post('/productByCrasherMusicMerchandise', "CrasherController@getProdukByCrasherMusicMenchandise");
Route::post('/getBrands', "CrasherController@getBrands");
Route::post('/brand', "CrasherController@getProdukByBrand");

Route::group(['middleware' => 'auth:api'],function(){
    Route::post('/userAll', "UserController@getAll");
    Route::post('/user', "UserController@getSelected");
    Route::post('/addUser', "UserController@store");
    Route::post('/editUser', "UserController@edit");
    Route::post('/deleteUser', "UserController@delete");
    Route::post('/getMenu', "MenuController@getMenu");
    Route::post('/addMenu', "MenuController@postMenu");
    Route::post('/editMenu', "MenuController@updateMenu");
    Route::post('/deleteMenu', "MenuController@deleteMenu");
    Route::post('/getAllAksesMenu', "AksesMenuController@getAllAksesMenu");
    Route::post('/getSelectedAksesMenu', "AksesMenuController@getSelectedAksesMenu");
    Route::post('/createAksesMenu', "AksesMenuController@createAksesMenu");
    Route::post('/getAllRoleUser', "RoleUserController@getAll");
    Route::post('/getRoleUser', "RoleUserController@getRoleUser");
    Route::post('/getSelectedRoleUser', "RoleUserController@getSelected");
    Route::post('/createRoleUser', "RoleUserController@create");
    Route::post('/editRoleUser', "RoleUserController@edit");
    Route::post('/getIndexCategori', "CategoriController@index");
    Route::post('/getAllCategori', "CategoriController@getAll");
    Route::post('/createCategori', "CategoriController@create");
    Route::post('/getSelectedCategori', "CategoriController@getSelected");
    Route::post('/updateCategori', "CategoriController@update");
    Route::post('/deleteCategori','CategoriController@delete');
    Route::post('/getIndexSubCategori', "SubCategoriController@index");
    Route::post('/getAllSubCategori', "SubCategoriController@getAll");
    Route::post('/getSelectedSubCategori', "SubCategoriController@getSelected");
    Route::post('/createSubCategori', "SubCategoriController@create");
    Route::post('/updateSubCategori', "SubCategoriController@update");
    Route::post('/deleteSubCategori', "SubCategoriController@delete");
    Route::post('/getBannerHome', "BannerHomeController@index");
    Route::post('/createBannerHome', "BannerHomeController@create");
    Route::post('/deleteBannerHome', "BannerHomeController@delete");
    Route::post('/getIndexProduk', "ProdukController@index");
    Route::post('/getSelectedProduk', "ProdukController@getSelected");
    Route::post('/createProduk', "ProdukController@create");
    Route::post('/updateProduk', "ProdukController@update");
    Route::post('/deleteProduk', "ProdukController@delete");
    Route::post('/getGambarProduk', "GambarProdukController@index");
    Route::post('/createGambarProduk', "GambarProdukController@create");
    Route::post('/deleteGambarProduk', "GambarProdukController@delete");
    route::post('/getSize', 'SizeController@index');
    route::post('/createSize', 'SizeController@create');
    Route::post('/updateSize', "SizeController@update");
    Route::post('/deleteSize', "Sizecontroller@delete");
    Route::post('/getProfileCompany', "ProfileCompanyController@index");
    Route::post('/updateProfileCompany', "ProfileCompanyController@update");
    Route::post('/getAllBrand', "BrandController@index");
    Route::post('/getBrand', "BrandController@getALl");
    Route::post('/getSelectedBrand', "BrandController@getSelected");
    Route::post('/createBrand', "BrandController@create");
    Route::post('/updateBrand', "BrandController@update");
    Route::post('/getAllKodeTransaksi', "KodeTransaksiController@index");
    Route::post('/createKodeTransaksi', "KodeTransaksiController@create");
    Route::post('/searchProdukForTransaksi',"TransaksiController@searchProduk");
    Route::post('/getCountProduk', "ProdukController@getCountProduct");
    Route::post('/getCountBrand', "BrandController@getCountBrand");
    Route::post('/getCountTransaksiShopee', "TransaksiController@getCountTransaksiShopee");
    Route::post('/getCountTransaksiWa', "TransaksiController@getCountTransaksiWa");
    Route::post('/transaction',"TransaksiController@index");
    Route::post('/transaction/search-products',"TransaksiController@searchProduk");
    Route::post('/transaction/store',"TransaksiController@store");
    Route::post('/transaction/update', "TransaksiController@update");
    Route::post('/jenisPembayaran', "JenisPembayaranController@index");
    Route::post('/jenisPembayaran/store', "JenisPembayaranController@store");
    Route::post('/jenisPembayaran/update', "JenisPembayaranController@update");
});
