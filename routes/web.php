<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['namespace' => 'API\V1', 'prefix' => 'api/v1', 'as' => 'API.'], function ($router) {
    $router->get('send-sms', 'NotificationController@sendSmsNotificaition');
    $router->post('login', 'AuthController@userLogin');
    $router->post('user_signup', 'AuthController@userSignup');
});


$router->group(['namespace' => 'API\V1', 'prefix' => 'api/v1', 'middleware' => ['auth']], function () use ($router) {
    
    $router->group(['prefix' => 'user'], function () use ($router) {

        $router->post('register',        ['as' => 'register',        'uses'  => 'AuthController@register']);
        $router->get('getNetwork',       ['as' => 'getNetwork',        'uses'  => 'AuthController@getNetwork']);
        $router->post('change-password', ['as' => 'change-password', 'uses'  => 'AuthController@changePassword']);
        $router->get('getnetworklist',       ['as' => 'getNetworkList',        'uses'  => 'AuthController@getNetworkList']);
        $router->get('get-profile',      ['as' => 'get-profile',     'uses'  => 'AuthController@getProfile']);
        $router->post('update-profile',  ['as' => 'update-profile',  'uses'  => 'AuthController@updateProfile']);
        $router->post('logout',          ['as' => 'logout',          'uses'  => 'AuthController@logout']);
        $router->post('addtocart',       ['as' => 'addtocart',       'uses'  => 'CartController@addToCart']);
        $router->post('cartdelete',      ['as' => 'cartdelete',      'uses'  => 'CartController@cartDelete']);

    });

    $router->group(['prefix' => 'product'], function () use ($router) {

        $router->get('list/product',     ['as'    => 'listproduct',  'uses'  => 'ProductController@index']);
        $router->post('add/product',     ['as'    => 'addproduct',   'uses'  => 'ProductController@addProduct']);
        $router->post('delete/product',  ['as'    => 'deleteproduct','uses'  => 'ProductController@destroy']);
        $router->post('find/product',    ['as'    => 'getproductbyid','uses' => 'ProductController@getProductById']);

    });

    $router->group(['prefix' => 'pay'], function () use ($router) {
        $router->post('razorpaypayment',     ['as'    => 'razorpaypayment',  'uses'  => 'RazorpayController@payment']);      
    });

});

/*$router->group(['namespace' => 'API\V1', 'prefix' => 'api/v1', 'middleware' => ['auth','admin']], function () use ($router) {

});
*/

/*$router->group(['namespace' => 'API\V1', 'prefix' => 'api', 'as' => 'API.'], function ($router) {
    $router->post('login', 'AuthController@userLogin');
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('register', 'AuthController@register');
        $router->post('logout', 'AuthController@logout');
        $router->post('change-password', 'AuthController@changePassword');
        $router->get('get-profile', 'AuthController@getProfile');
        $router->post('update-profile', 'AuthController@updateProfile');
        $router->post('adtocart', 'CartController@addToCart');
        $router->post('cartdelete', 'CartController@cartDelete');
        $router->post('add/product', 'ProductController@addProduct');
        $router->get('list/product', 'ProductController@index');
        $router->post('delete/product', 'ProductController@destroy');
    });
});*/
