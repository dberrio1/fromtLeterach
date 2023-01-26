<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class LoginController extends Controller
{
    public function login(){

        return view('login');
    }
    public function postLgn(Request $request){
        $valores = $request->json()->all();
        //endpoint para loguin, retirna los datos del usuario y token de acceso
        return Http::post(Config::get("constants.BaseUrl").'login',[
            'rut' => $valores['rut'],
            'password' => $valores['password']
        ]);
    }
}
