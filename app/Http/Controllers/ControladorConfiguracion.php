<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Configuracion\Configuracion;


require app_path().'/start/constants.php';
use Session;

class ControladorConfiguracion extends Controller
{
    public function index(){
        $titulo = "Configuracion General";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('configuracion.configuracion-listar', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;
    
        $entidadMenu = new Configuracion();
        $aMenu = $entidadMenu->obtenerFiltrado();
    
        $data = array();
    
        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];
        if (count($aMenu) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aMenu) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/configuracion/' . $aMenu[$i]->idconfiguracion . '">' . $aMenu[$i]->titulo_del_sitio . '</a>';
                $row[] = $aMenu[$i]->email_contacto;    
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
        $titulo = "Nueva Configuracion General";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("MENUALTA")) {
                $codigo = "MENUALTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $entidad = new Configuracion();
                return view('configuracion.configuracion-nuevo', compact('titulo'));
            } 
        } else {
           return redirect('login');
        }   
}
public function guardar(Request $request){
    try {
        //Define la entidad servicio
        $titulo = "Modificar Configuracion General";
        $entidad = new Configuracion();
        $entidad->cargarDesdeRequest($request);

        //validaciones
        if ($entidad->titulo_del_sitio == "") {
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
            $_POST["id"] = $entidad->idconfiguracion;
            return view('configuracion.configuracion-listar', compact('titulo', 'msg'));
        }
    } catch (Exception $e) {
        $msg["ESTADO"] = MSG_ERROR;
        $msg["MSG"] = ERRORINSERT;
    }

}
public function editar($id){
    $titulo = "Modificar Configuraciones Generales";
    if(Usuario::autenticado() == true){
        if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
            $codigo = "MENUMODIFICACION";
            $mensaje = "No tiene pemisos para la operaci&oacute;n.";
            return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
        } else {
            $menu = new Configuracion();
            $menu->obtenerPorId($id);
            return view('configuracion.configuracion-nuevo', compact('menu', 'titulo'));
        }
    } else {
       return redirect('login');
    }
}

public function eliminar(Request $request){
    $id = $request->input('id');

    if(Usuario::autenticado() == true){
        if(Patente::autorizarOperacion("MENUELIMINAR")){

            $entidad = new Configuracion();
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