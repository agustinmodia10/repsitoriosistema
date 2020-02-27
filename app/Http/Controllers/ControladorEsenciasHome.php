<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Producto\Producto;

require app_path().'/start/constants.php';
use Session;

class ControladorEsenciasHome extends Controller{
    public function index(){
        $titulo = "REPERTORIO ON LINE";
        $producto= new Producto();
        $array_productos=$producto->obtenerPorEsencia();
        return view('esencias.index', compact('titulo','array_productos'));
    }

    public function agregarAlCarrito(Request $request) {
      //  Session::put('array_carrito', array()); 
        $idProducto = $request->input('id');

        //Agrego un elemento en la primer posicion libre del carrito
        if(!Session::get('array_carrito')){
            Session::put('array_carrito', array()); 
        }
        $array_carrito = Session::get('array_carrito');
        $array_carrito[] = $idProducto;

        Session::put('array_carrito',$array_carrito);


        $aResultado["err"] = EXIT_SUCCESS;
        $aResultado["cantidad"] = count($array_carrito);
        echo json_encode($aResultado);
    }
        
                  
           
             
    }

  


   

  