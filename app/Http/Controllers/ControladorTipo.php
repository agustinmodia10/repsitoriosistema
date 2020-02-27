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

class ControladorTipo extends Controller{

    public function index(){
        $titulo = "Listado de Tipos";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('producto.tipo-listar', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    
    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidadTipo = new Tipo();
        $aTipo = $entidadTipo->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aTipo) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aTipo) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/producto/' . $aTipo[$i]->idtipo . '">' . $aTipo[$i]->nombre . '</a>';
                $row[] = $aTipo[$i]->idtipo;
                $row[] = $aTipo[$i]->nombre;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aTipo), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aTipo),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);

    }
    public function nuevo(){
        $titulo = "Nuevo Tipo";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("MENUALTA")) {
                $codigo = "MENUALTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $entidad = new Tipo();
                $array_tipo = $entidad->obtenerTodos();

                return view('producto.tipo-nuevo', compact('array_tipo', 'titulo'));
            }
        } else {
           return redirect('login');
        }   
}
public function guardar(Request $request){
    try {
        //Define la entidad servicio
        $titulo = "Modificar Tipo";
        $entidad = new Tipo();
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
          
            $_POST["id"] = $entidad->idtipo;
            return view('producto.tipo-listar', compact('titulo', 'msg'));
        }
    } catch (Exception $e) {
        $msg["ESTADO"] = MSG_ERROR;
        $msg["MSG"] = ERRORINSERT;
    }
    $id = $entidad->idtipo;
    $menu = new Tipo();
    $menu->obtenerPorId($id);

    $entidad = new Tipo();
    $array_tipo = $entidad->obtenerTodos();

    return view('producto.tipo-nuevo', compact('msg', 'array_tipo')) . '?id=' . $entidad->idtipo;

}
public function editar($id){
    $titulo = "Modificar Tipo";
    if(Usuario::autenticado() == true){
        if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
            $codigo = "MENUMODIFICACION";
            $mensaje = "No tiene pemisos para la operaci&oacute;n.";
            return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
        } else {
            $tipo = new Tipo();
            $tipo->obtenerPorId($id);

            $entidad = new Tipo();
            $array_tipo = $entidad->obtenerTodos();


            return view('producto.tipo-nuevo', compact('titulo', 'array_tipo'));
        }
    } else {
       return redirect('login');
    }
}
}

