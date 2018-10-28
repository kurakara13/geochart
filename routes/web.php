<?php

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

Route::get('/', function () {
    return view('home');
});

Route::get('/test', function () {
  $myArr["cols"] = [
                      array("id" => "A", 'label' => "Province","type" => "string")
                    ];
  $myArr["rows"] = [
                      array(
                            "c" => [
                                      array("v" => 'ID-AC',"f" => 'Aceh')
                                    ]
                            ),
                      array(
                            "c" => [
                                      array("v" => "ID-BA","f" => "Bali")
                                    ]
                            )
                    ];

  $myJSON = json_encode($myArr);

  return $myJSON;
});
