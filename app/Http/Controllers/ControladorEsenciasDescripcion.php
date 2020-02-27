<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Producto\Producto;

require app_path().'/start/constants.php';
use Session;

class ControladorEsenciasDescripcion extends Controller{
    public function index(){
        $titulo = "DESCRIPCION DE ESENCIAS";
                return view('esencias.descripcion-esencias', compact('titulo'));
    
    }


}