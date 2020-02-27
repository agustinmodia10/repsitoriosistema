<?php

namespace App\Entidades\Producto;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Tipo extends Model
{
    protected $table = 'tipos';
    public $timestamps = false;

    protected $fillable = [
        'idtipo', 'nombre'
    ];

    protected $hidden = [

    ];
    public function obtenerTipo() {
        $sql = "SELECT 
                  idtipo,
                  nombre
                FROM tipos";

        $sql .= " ORDER BY nombre ";
        $lstTipos = DB::select($sql);
        return $lstTipos;
    }
    
    function cargarDesdeRequest($request) {
        $this->idtipo = $request->input('id')!="0" ? $request->input('id') : $this->idtipo;
        $this->nombre = $request->input('txtNombre');
      
    }
    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'nombre',
          
         );
        $sql = "SELECT DISTINCT
                    idtipo,
                    nombre
                    FROM tipos 
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstTipos = DB::select($sql);

        return $lstTipos;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  idtipo,
                  nombre
                FROM tipos ORDER BY nombre ";
        $lstTipos = DB::select($sql);
        return $lstTipos;
    }

    public function obtenerPorId($idtipo) {
        $sql = "SELECT
                idtipo,
                nombre
                FROM tipos WHERE idtipo = '$idtipo'";
        $lstTipos = DB::select($sql);

        if(count($lstTipos)>0){
            $this->idtipo = $lstTipos[0]->idtipo;
            $this->nombre = $lstTipos[0]->nombre;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE tipos SET
            nombre='$this->nombre'
            WHERE idtipo=?";
        $affected = DB::update($sql, [$this->idtipo]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM tipos WHERE 
            idtipo=?";
        $affected = DB::delete($sql, [$this->idtipo]);
    }

    public function insertar() {
        $sql = "INSERT INTO tipos (
               nombre
            ) VALUES (?);";
       $result = DB::insert($sql, [
            $this->nombre
        ]);
       return $this->idtipo= DB::getPdo()->lastInsertId();
    }


}
