<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Pagina\Pagina;
use App\Entidades\Pagina\Estado;
require app_path().'/start/constants.php';
use Session;

class ControladorPagina extends Controller{
    public function index(){
        $titulo = "Listado de paginas";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('pagina.pagina-listar', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidadPagina = new Pagina();
        $aPagina = $entidadPagina->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aPagina) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aPagina) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/pagina/' . $aPagina[$i]->idpagina . '">' . $aPagina[$i]->titulo . '</a>';
                $row[] = $aPagina[$i]->subtitulo;
                $row[] = $aPagina[$i]->fecha_creacion;
                $row[] = $aPagina[$i]->fecha_publicacion;
                $row[] = $aPagina[$i]->estado;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aPagina), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aPagina),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function nuevo(){
        $titulo = "Nueva Pagina";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("MENUALTA")) {
                $codigo = "MENUALTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $entidad = new Estado();
                $array_estados = $entidad->obtenerTodos();

                return view('pagina.pagina-nuevo', compact('titulo', 'array_estados'));
            }
        } else {
           return redirect('login');
        }   
}

public function guardar(Request $request){
    try {
        //Define la entidad servicio
        $titulo = "Modificar Área";
        $entidad = new Pagina();
        $entidad->cargarDesdeRequest($request);

        //validaciones
        if ($entidad->titulo == "") {
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
            $_POST["id"] = $entidad->idpagina;
            return view('pagina.pagina-listar', compact('titulo', 'msg'));
        }
    } catch (Exception $e) {
        $msg["ESTADO"] = MSG_ERROR;
        $msg["MSG"] = ERRORINSERT;
    }
    $id = $entidad->idpagina;
        $pagina = new Pagina();
        $pagina->obtenerPorId($id);

        $entidad = new Estado();
        $array_estados = $entidad->obtenerTodos();
        print_r("HOLA");
        exit;
        return view('pagina.pagina-nuevo', compact('msg', 'pagina', 'titulo', 'array_estados')) . '?id=' . $pagina->idpagina;

    }

    public function editar($id){
        $titulo = "Modificar Pagina";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                $codigo = "MENUMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $pagina = new Pagina();
                $pagina->obtenerPorId($id);

                $entidad = new Estado();
                $array_estados = $entidad->obtenerTodos();

                return view('pagina.pagina-nuevo', compact('titulo', 'pagina', 'array_estados'));
            }
        } else {
           return redirect('login');
        }
    }

    public function eliminar(Request $request){
        $id = $request->input('id');

        if(Usuario::autenticado() == true){
            if(Patente::autorizarOperacion("MENUELIMINAR")){

    
                $entidad = new Pagina();
                $entidad->cargarDesdeRequest($request);
                $entidad->eliminar();

                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
            } else {
                $codigo = "MENUELIMINAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                $aResultado["err"] = EXIT_FAILURE; //error al elimiar
            }
            echo json_encode($aResultado);
        } else {
            return redirect('login');
        }
    }

}