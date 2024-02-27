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
    Route::post('/getBrand', "BrandController@index");
    Route::post('/getSelectedBrand', "BrandController@getSelected");
    Route::post('/createBrand', "BrandController@create");
    Route::post('/updateBrand', "BrandController@update");
});
