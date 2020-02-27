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

class ControladorProducto extends Controller{

    public function index(){
        $titulo = "Listado de Productos";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("PRODUCTOCONSULTA")) {
                $codigo = "PRODUCTOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('producto.producto-listar', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    
    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidadProducto = new Producto();
        $aProducto = $entidadProducto->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aProducto) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aProducto) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/producto/' . $aProducto[$i]->idproducto . '">' . $aProducto[$i]->nombre . '</a>';
                $row[] = $aProducto[$i]->fk_idmarca;
                $row[] = $aProducto[$i]->modelo;
                $row[] = $aProducto[$i]->fk_idtipo;
                $row[] = $aProducto[$i]->importe;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aProducto), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aProducto),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);

    }
    public function nuevo(){
        $titulo = "Nuevo Producto";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("PRODUCTOALTA")) {
                $codigo = "PRODUCTOALTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $entidad = new Marca();
                $array_marca = $entidad->obtenerTodos();
                $entidad = new Moneda();
                $array_moneda = $entidad->obtenerTodos();
                $entidad = new Tipo();
                $array_tipo = $entidad->obtenerTodos();

                return view('producto.producto-nuevo', compact('array_marca', 'array_tipo', 'array_moneda', 'titulo'));
            }
        } else {
           return redirect('login');
        }   
}
public function guardar(Request $request){
    try {
        //Define la entidad servicio
        $titulo = "Modificar Producto";
        $nombre = "";
        $entidad = new Producto();
        $entidad->cargarDesdeRequest($request);
        if($_FILES["archivo"]["error"] === UPLOAD_ERR_OK)
        {
            $nombre = date("Ymdhmsi") . ".jpg"; 
            $archivo = $_FILES["archivo"]["tmp_name"];
            move_uploaded_file($archivo, env('APP_PATH') . "public\images\\$nombre");//guardaelarchivo
            $entidad->imagen =$nombre;
        }
      


        //validaciones
        if ($entidad->nombre == "") {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Complete todos los datos";
        } else {
            if ($_POST["id"] > 0) {
                //Es actualizacion
                $productAnt = new Producto();
                $productAnt->obtenerPorId($entidad->idproducto);
                $archivoAnterior =$productAnt->imagen;
                if($archivoAnterior !=""){
                    unlink (env('APP_PATH') . "public\images\\$nombre" . $archivoAnterior);
                }

                $entidad->guardar();

                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = OKINSERT;
            } else {
                //Es nuevo
                $entidad->insertar();

                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = OKINSERT;
            }
          
            $_POST["id"] = $entidad->idproducto;
            return view('producto.producto-listar', compact('titulo', 'msg'));
        }
    } catch (Exception $e) {
        $msg["ESTADO"] = MSG_ERROR;
        $msg["MSG"] = ERRORINSERT;
    }
    
    $id = $entidad->idproducto;
    $menu = new Producto();
    $menu->obtenerPorId($id);

    $entidad = new Marca();
    $array_marca = $entidad->obtenerTodos();
    $entidad = new Moneda();
    $array_moneda = $entidad->obtenerTodos();
    $entidad = new Tipo();
    $array_tipo = $entidad->obtenerTodos();

    return view('producto.producto-nuevo', compact('msg', 'producto', 'array_moneda', 'array_marca', 'array_tipo')) . '?id=' . $producto->idproducto;

}
public function editar($id){
    $titulo = "Modificar Producto";
    if(Usuario::autenticado() == true){
        if (!Patente::autorizarOperacion("PRODUCTOMODIFICACION")) {
            $codigo = "PRODUCTOMODIFICACION";
            $mensaje = "No tiene pemisos para la operaci&oacute;n.";
            return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
        } else {
            $producto = new Producto();
            $producto->obtenerPorId($id);

            $entidad = new Marca();
            $array_marca = $entidad->obtenerTodos();
            $entidad = new Moneda();
            $array_moneda = $entidad->obtenerTodos();
            $entidad = new Tipo();
            $array_tipo = $entidad->obtenerTodos();


            return view('producto.producto-nuevo', compact('titulo', 'producto', 'array_moneda', 'array_marca', 'array_tipo'));
        }
    } else {
       return redirect('login');
    }
}


public function eliminar(Request $request){
    $id = $request->input('id');

    if(Usuario::autenticado() == true){
        if(Patente::autorizarOperacion("PRODUCTOELIMINAR")){

            $entidad = new Producto();
            $entidad->cargarDesdeRequest($request);
            $entidad->eliminar();

            $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
        
        } else {
            $codigo = "PRODUCTOELIMINAR";
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