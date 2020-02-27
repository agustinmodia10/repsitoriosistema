<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Producto\Producto;

require app_path().'/start/constants.php';
use Session;

class ControladorEsenciasInforme extends Controller{
    public function index(){
        $titulo = "INFORME DE ESENCIAS";
                return view('esencias.informe-esencias', compact('titulo'));
    
    }


}