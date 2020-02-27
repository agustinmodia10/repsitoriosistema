<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sintoma\Sintoma;


require app_path().'/start/constants.php';
use Session;

class ControladorSintoma extends Controller
{
    public function index(){
        $titulo = "Sintomas";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('sintoma.sintoma-listar', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;
    
        $entidadMenu = new Sintoma();
        $aMenu = $entidadMenu->obtenerFiltrado();
    
        $data = array();
    
        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];
        if (count($aMenu) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aMenu) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/sintoma/' . $aMenu[$i]->idsintoma . '">' . $aMenu[$i]->nombre . '</a>';
                $row[] = $aMenu[$i]->descripcion;
                $cont++;
                $data[] = $row;
            }
    
        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aMenu), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aMenu),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }
    public function nuevo(){
        $titulo = "Nuevo Sintoma";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("MENUALTA")) {
                $codigo = "MENUALTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $entidad = new Sintoma();

                return view('sintoma.sintoma-nuevo', compact('titulo'));
            }
        } else {
           return redirect('login');
        }   
}


public function guardar(Request $request){
    try {
        //Define la entidad servicio
        $titulo = "Modificar Sintoma";
        $entidad = new Sintoma();
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
            $_POST["id"] = $entidad->idsintoma;
            return view('sintoma.sintoma-listar', compact('titulo', 'msg'));
        }
    } catch (Exception $e) {
        $msg["ESTADO"] = MSG_ERROR;
        $msg["MSG"] = ERRORINSERT;
    }

}
public function editar($id){
    $titulo = "Modificar Sintomaa";
    if(Usuario::autenticado() == true){
        if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
            $codigo = "MENUMODIFICACION";
            $mensaje = "No tiene pemisos para la operaci&oacute;n.";
            return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
        } else {
            $menu = new Sintoma();
            $menu->obtenerPorId($id);
            return view('sintoma.sintoma-nuevo', compact('menu', 'titulo'));
        }
    } else {
       return redirect('login');
    }
}
public function eliminar(Request $request){
    $id = $request->input('id');

    if(Usuario::autenticado() == true){
        if(Patente::autorizarOperacion("MENUELIMINAR")){

            $entidad = new Sintoma();
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




?>