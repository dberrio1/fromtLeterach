<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VisadorController extends Controller
{
    public function index(){
        return view('visador/visaRequerimiento');
    }
    public function visaDetalle(){
        return view('visador/visaDetalleRequerimiento');
    }
}
