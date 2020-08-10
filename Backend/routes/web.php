<?php

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

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    // Matches "/api/register
    $router->post('register', 'AuthController@register');
     // Matches "/api/login
    $router->post('login', 'AuthController@login');

    // Matches "/api/profile
    $router->get('profile', 'UserController@profile');

    // Matches "/api/users/1
    //get one user by id
    $router->get('users/{id}', 'UserController@singleUser');

    // Matches "/api/users
    $router->get('users', 'UserController@allUsers');

    $router->post('upload','ImageController@upload');

    $router->post('image/delete','ImageController@delete');

    $router->get('region', 'RegionController@index');
    $router->get('region/show', 'RegionController@show');
    $router->post('region','RegionController@create');
    $router->post('region/{id}', 'RegionController@edit');
    $router->delete('region/{id}', 'RegionController@destroy');

    $router->get('delivery', 'DeliveryController@index');
    $router->post('delivery','DeliveryController@create');
    $router->post('delivery/{id}', 'DeliveryController@edit');
    $router->delete('delivery/{id}', 'DeliveryController@destroy');

    $router->get('souvenirgroup', 'SouvenirGroupController@index');
    $router->post('souvenirgroup','SouvenirGroupController@create');
    $router->post('souvenirgroup/{id}', 'SouvenirGroupController@edit');
    $router->delete('souvenirgroup/{id}', 'SouvenirGroupController@destroy');

    $router->get('souvenir', 'SouvenirController@index');
    $router->post('souvenir','SouvenirController@create');
    $router->post('souvenir/{id}', 'SouvenirController@edit');
    $router->delete('souvenir/{id}', 'SouvenirController@destroy');

    $router->get('unit', 'UnitController@index');
    $router->post('unit','UnitController@create');
    $router->post('unit/{id}', 'UnitController@edit');
    $router->delete('unit/{id}', 'UnitController@destroy');

    $router->get('deliverys/{did}/weight', 'WeightController@index');
    $router->post('deliverys/weight','WeightController@create');
    $router->post('deliverys/weight/{id}', 'WeightController@edit');
    $router->delete('deliverys/weight/{id}', 'WeightController@destroy');


    $router->get('member', 'MemberController@index');
    $router->get('member/show/{id}', 'MemberController@show');
    $router->post('member','MemberController@create');
    $router->post('member/{id}', 'MemberController@edit');
    $router->delete('member/{id}', 'MemberController@destroy');
    $router->post('login/member', 'MemberController@Login');

    $router->get('customer', 'CustomerController@index');
    $router->get('customer/show/{id}', 'CustomerController@show');
    $router->post('customer','CustomerController@create');
    $router->post('customer/{id}', 'CustomerController@edit');
    $router->delete('customer/{id}', 'CustomerController@destroy');
    $router->post('login/customer', 'CustomerController@Login');

    $router->post('shops','ShopsController@create');


    //order
    $router->post('orders','OrdersController@create');
    $router->get('orders/show/{id}/status/{status}', 'OrdersController@show');
    $router->get('orders/show/{id}', 'OrdersController@show2');

    //order detail

    $router->post('ordersDetail','ordersDetailController@create');

    //shop order
    $router->get('shopsOrders/show/{id}/{status}', 'ShopsOrdersController@show');
    $router->post('shopsOrders/{id}', 'ShopsOrdersController@edit');
    $router->post('shopsOrders','ShopsOrdersController@create');
});
