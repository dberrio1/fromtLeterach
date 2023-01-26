<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreadorController extends Controller
{
    public function index(){
        return view('creador/creaRequerimiento');
    }
    public function listaRequerimientos(){
        return view('creador/listaRequerimientos');
    }
}
