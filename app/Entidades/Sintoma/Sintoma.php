<?php

namespace App\Entidades\Sintoma;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Sintoma extends Model
{
  protected $table = 'sintomas';
  public $timestamps = false;

  protected $fillable = 
  [
   'idsintoma', 'nombre', 'descripcion'
  ];

  protected $hidden = [

  ];


    function cargarDesdeRequest($request) {
        $this->idsintoma = $request->input('id')!="0" ? $request->input('id') : $this->idsintoma;
        $this->nombre = $request->input('txtNombre');
        $this->descripcion = $request->input('txtDescripcion');
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.nombre',
           1 => 'A.descripcion'
            );
        $sql = "SELECT DISTINCT
                    A.idsintoma,
                    A.nombre,
                    A.descripcion
                    FROM sintomas A
                    WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
          $sql.=" AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
          $sql.=" OR A.descripcion LIKE '%" . $request['search']['value'] . "%' )";
      }
      $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

      $lstRetorno = DB::select($sql);
// print_r($sql);
// exit;
        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idsintoma,
                  A.nombre,
                  A.descripcion
                FROM sintomas A";

        $sql .= " ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    //    public function obtenerMenuPadre() {
    //     $sql = "SELECT DISTINCT
    //               A.idsintoma,
    //               A.nombre
    //             FROM sintomas A
    //             WHERE A.id_padre = 0";

    //     $sql .= " ORDER BY A.nombre";
    //     $lstRetorno = DB::select($sql);
    //     return $lstRetorno;
    // }

    // public function obtenerSubMenu($idsintoma=null){
    //     if($idsintoma){
    //         $sql = "SELECT DISTINCT
    //                   A.idsintoma,
    //                   A.nombre
    //                   A.descripcion
    //                 FROM sintomas A
    //                 WHERE A.idsintoma <> '$idsintoma'";

    //         $sql .= " ORDER BY A.nombre";
    //         $resultado = DB::select($sql);
    //     } else {
    //         $resultado = $this->obtenerTodos();
    //     }
    //     return $resultado;
    // }

    public function obtenerPorId($idsintoma) {
        $sql = "SELECT
                idsintoma,
                nombre,
                descripcion
                FROM sintomas WHERE idsintoma = '$idsintoma'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idsintoma = $lstRetorno[0]->idsintoma;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->descripcion = $lstRetorno[0]->descripcion;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE sintomas SET
            nombre='$this->nombre',
            descripcion='$this->descripcion'
            WHERE idsintoma=?";
        $affected = DB::update($sql, [$this->idsintoma]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM sintomas WHERE 
            idsintoma=?";
        $affected = DB::delete($sql, [$this->idsintoma]);
    }

    public function insertar() {
        $sql = "INSERT INTO sintomas (
                nombre,
                descripcion
            ) VALUES (?, ?);";
       $result = DB::insert($sql, [
            $this->nombre,
            $this->descripcion

        ]);
       return $this->idsintoma = DB::getPdo()->lastInsertId();
    }

    public function obtenerMenuDelGrupo($idGrupo){
        $sql = "SELECT DISTINCT
        A.idsintoma,
        A.nombre,
        A.descripcion
        FROM sintomas A
        -- INNER JOIN sistema_menu_area B ON A.idsintoma = B.idsintoma
        -- WHERE A.activo = '1' AND B.fk_idarea = $idGrupo ORDER BY A.orden";
        $resultado = DB::select($sql);
        return $resultado;
    }

}
