<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Producto\Producto;
use App\Entidades\Producto\Marca;
use App\Entidades\Producto\Moneda;
use App\Entidades\Producto\Tipo;



require app_path().'/start/constants.php';
use Session;

class ControladorMarca extends Controller{

    public function index(){
        $titulo = "Listado de Marcas de Productos";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('producto.marca-listar', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    
    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidadMarca = new Marca();
        $aMarca = $entidadMarca->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aMarca) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aMarca) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/producto/' . $aMarca[$i]->idmarca . '">' . $aMarca[$i]->nombre . '</a>';
                $row[] = $aMarca[$i]->idmarca;
                $row[] = $aMarca[$i]->nombre;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aMarca), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aMarca),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);

    }
    public function nuevo(){
        $titulo = "Nuevo Marca";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("MENUALTA")) {
                $codigo = "MENUALTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $entidad = new Marca();
                $array_marca = $entidad->obtenerTodos();

                return view('producto.marca-nuevo', compact('array_marca', 'titulo'));
            }
        } else {
           return redirect('login');
        }   
}
public function guardar(Request $request){
    try {
        //Define la entidad servicio
        $titulo = "Modificar Marca";
        $entidad = new Marca();
        $entidad->cargarDesdeRequest($request);

        //validaciones
        if ($entidad->nombre == "") {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Complete todos los datos";
        } else {
            if ($_POST["id"] > 0) {
                //Es actualizacion
                $entidad->guardar();

                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = OKINSERT;
            } else {
                //Es nuevo
                $entidad->insertar();

                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = OKINSERT;
            }
          
            $_POST["id"] = $entidad->idmarca;
            return view('producto.marca-listar', compact('titulo', 'msg'));
        }
    } catch (Exception $e) {
        $msg["ESTADO"] = MSG_ERROR;
        $msg["MSG"] = ERRORINSERT;
    }

    $id = $entidad->idmarca;
    $menu = new Marca();
    $menu->obtenerPorId($id);

    $entidad = new Marca();
    $array_marca = $entidad->obtenerTodos();

    return view('producto.marca-nuevo', compact('msg', 'array_marca')).'?id='. $entidad->idmarca;

}
public function editar($id){
    $titulo = "Modificar Marca";
    if(Usuario::autenticado() == true){
        if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
            $codigo = "MENUMODIFICACION";
            $mensaje = "No tiene pemisos para la operaci&oacute;n.";
            return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
        } else {
            $marca = new Marca();
            $marca->obtenerPorId($id);

            $entidad = new Marca();
            $array_marca = $entidad->obtenerTodos();


            return view('producto.marca-nuevo', compact('titulo', 'array_marca'));
        }
    } else {
       return redirect('login');
    }
}
}

