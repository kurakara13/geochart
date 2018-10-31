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
    return view('geochart-1');
});

Route::get('/2', function () {
    return view('geochart-2');
});

Route::get('/test/{id}', function ($id) {
  $reachPA = array("jk" => 130037704, "ma" => 98049216, "pb" => 54283278, "ss" => 2354171);

  $myArr["ID-PA"] = [
                      array("id" => "ID-PA", 'label' => "Province","name" => "Daerah Khusus Papua", "reach" => $reachPA, "mention" => [], "engagement" => [])
                    ];

  $myJSON = json_encode($myArr[$id][0]);

  return $myJSON;
});

Route::get('/test/geo/2', function () {
  $test = file_get_contents('vendor/leaflet/crimes_by_district.geojson');

  return $test;
});
