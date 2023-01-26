<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class ApiController extends Controller
{
    //Retorna  todas las descripciones de trabajos
    public function descripciones(Request $request){
        $valores = $request->json()->all();
        return Http::withToken($valores['token'])->get(Config::get("constants.BaseUrl").'descripciones');
    }
    //Retorna la institución del usuario logiueado
    public function instituciones (Request $request){
        $valores = $request->json()->all();         
        return Http::withToken($valores['token'])->get(Config::get("constants.BaseUrl").'instituciones/'.$valores['id']);
    }
    //Inserta nuevo requerimiento
    public function addRequerimiento(Request $request){
        $valores = $request->json()->all();
        return Http::withToken($valores['token'])->post(Config::get("constants.BaseUrl").'requerimietos',[
            'id_usuario' => $valores['id_usuario'],
            'id_inst' => $valores['id_inst'],
            'id_desc' => $valores['id_desc'],
            'detalle' => $valores['detalle'],
            'foto' => $valores['foto'],
            'id_estado' => $valores['id_estado'],
            'created_at' => $valores['created_at'],
            'updated_at' => $valores['updated_at'],
        ]);
        return response(['success'=>'Ok']);
    }
    //Lista requerimientos creados
    public function lstRequerimientosCreador(Request $request){
        $valores = $request->json()->all();
        $str = $valores['perfil'].'/'.$valores['id_usuario'].'/'.$valores['id_inst'];
        return Http::withToken($valores['token'])->get(Config::get("constants.BaseUrl").'requerimietos/'.$str);

    }
    //Retorna requerimiento por ID
    public function retDetalleReq(Request $request){
        $valores = $request->json()->all();
        return Http::withToken($valores['token'])->get(Config::get("constants.BaseUrl").'requerimietos/'.$valores['id']);
    }
    //Actualiza requerimieto
    public function actualizaReq(Request $request){
        $valores = $request->json()->all();
        return Http::withToken($valores['token'])->put(Config::get("constants.BaseUrl").'requerimietos/actualiza/',[
            'id' => $valores['id'],
            'detalle' => $valores['detalle'],
            'prioridad'=> $valores['prioridad'],
            'updated_at' => $valores['updated_at']
        ]);
    }
    //Retorna imagen de requerimiento
    public function retImagen(Request $request){
        $valores = $request->json()->all();
        return Http::withToken($valores['token'])->get(Config::get("constants.BaseUrl").'requerimietos/imagen/'.$valores['id']);

    }

}
