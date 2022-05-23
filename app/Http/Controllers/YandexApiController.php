<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class YandexApiController extends Controller
{
    public function index(Request $request){
        $api ='https://api.weather.yandex.ru/v2/forecast/';
        $method =$request->method();
        $response = Http::withHeaders(['X-Yandex-API-Key'=>config('other.YANDEX_API_KEY')])->$method($api,$request->all());
        return response($response->json(), $response->status()) ;

    }
}
