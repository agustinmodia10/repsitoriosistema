<?php

namespace App\Entidades\Configuracion;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Configuracion extends Model
{
  protected $table = 'configuraciones';
  public $timestamps = false;

  protected $fillable = 
  [
    'idconfiguracion', 'titulo_del_sitio', 'email_contacto'  ];

  protected $hidden = [

  ];


    function cargarDesdeRequest($request) {
        $this->idconfiguracion = $request->input('id')!="0" ? $request->input('id') : $this->idconfiguracion;
        $this->titulo_del_sitio = $request->input('txtTitulo_del_sitio');
        $this->email_contacto = $request->input('txtEmail_contacto');
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.titulo_del_sitio',
           1 => 'A.email_contacto'
            );
        $sql = "SELECT DISTINCT
                    A.idconfiguracion,
                    A.titulo_del_sitio,
                    A.email_contacto
                    FROM configuraciones A
                    WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
          $sql.=" AND ( A.titulo_del_sitio LIKE '%" . $request['search']['value'] . "%' ";
          $sql.=" OR A.email_contacto LIKE '%" . $request['search']['value'] . "%' )";
      }
      $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

      $lstRetorno = DB::select($sql);
// print_r($sql);
// exit;
        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idconfiguracion,
                  A.titulo_del_sitio,
                  A.email_contacto
                FROM configuraciones A";

        $sql .= " ORDER BY A.titulo_del_sitio";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    //    public function obtenerMenuPadre() {
    //     $sql = "SELECT DISTINCT
    //               A.idconfiguracion,
    //               A.titulo_del_sitio
    //             FROM configuraciones A
    //             WHERE A.id_padre = 0";

    //     $sql .= " ORDER BY A.titulo_del_sitio";
    //     $lstRetorno = DB::select($sql);
    //     return $lstRetorno;
    // }

    // public function obtenerSubMenu($idconfiguracion=null){
    //     if($idconfiguracion){
    //         $sql = "SELECT DISTINCT
    //                   A.idconfiguracion,
    //                   A.titulo_del_sitio
    //                   A.email_contacto
    //                 FROM configuraciones A
    //                 WHERE A.idconfiguracion <> '$idconfiguracion'";

    //         $sql .= " ORDER BY A.titulo_del_sitio";
    //         $resultado = DB::select($sql);
    //     } else {
    //         $resultado = $this->obtenerTodos();
    //     }
    //     return $resultado;
    // }

    public function obtenerPorId($idconfiguracion) {
        $sql = "SELECT
                idconfiguracion,
                titulo_del_sitio,
                email_contacto
                FROM configuraciones WHERE idconfiguracion = '$idconfiguracion'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idconfiguracion = $lstRetorno[0]->idconfiguracion;
            $this->titulo_del_sitio = $lstRetorno[0]->titulo_del_sitio;
            $this->email_contacto = $lstRetorno[0]->email_contacto;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE configuraciones SET
            titulo_del_sitio='$this->titulo_del_sitio',
            email_contacto='$this->email_contacto'
            WHERE idconfiguracion=?";
        $affected = DB::update($sql, [$this->idconfiguracion]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM configuraciones WHERE 
            idconfiguracion=?";
        $affected = DB::delete($sql, [$this->idconfiguracion]);
    }

    public function insertar() {
        $sql = "INSERT INTO configuraciones (
                titulo_del_sitio,
                email_contacto
            ) VALUES (?, ?);";
       $result = DB::insert($sql, [
            $this->titulo_del_sitio,
            $this->email_contacto

        ]);
       return $this->idconfiguracion = DB::getPdo()->lastInsertId();
    }

    public function obtenerMenuDelGrupo($idGrupo){
        $sql = "SELECT DISTINCT
        A.idconfiguracion,
        A.titulo_del_sitio,
        A.email_contacto
        FROM configuraciones A
        -- INNER JOIN sistema_menu_area B ON A.idconfiguracion = B.idconfiguracion
        -- WHERE A.activo = '1' AND B.fk_idarea = $idGrupo ORDER BY A.orden";
        $resultado = DB::select($sql);
        return $resultado;
    }

}
