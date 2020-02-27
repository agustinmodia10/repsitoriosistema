<?php

namespace App\Entidades\Producto;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Marca extends Model
{
    protected $table = 'marcas';
    public $timestamps = false;

    protected $fillable = [
        'idmarca','nombre'
    ];

    protected $hidden = [

    ];

    public function obtenerMarca() {
        $sql = "SELECT 
                  idmarca,
                  nombre
                FROM marcas ";

        $sql .= "ORDER BY nombre";
        $lstMarcas = DB::select($sql);
        return $lstMarcas;
    }
    
    function cargarDesdeRequest($request) {
        $this->idmarca = $request->input('id')!="0" ? $request->input('id') : $this->idmarca;
        $this->nombre = $request->input('txtNombre');
    }
    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'idmarca',
           1 =>'nombre'          
         );
        $sql = "SELECT DISTINCT
                    idmarca,
                    nombre
                    FROM marcas
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstMarcas = DB::select($sql);

        return $lstMarcas;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                idmarca,
                nombre
                FROM marcas ORDER BY nombre";
                $lstMarcas = DB::select($sql);
                return $lstMarcas;
    }


    public function obtenerPorId($idmarca) {
        $sql = "SELECT
                idmarca,
                nombre
                FROM marcas WHERE idmarca = '$idmarca'";
        $lstMarcas = DB::select($sql);

        if(count($lstMarcas)>0){
            $this->idmarca = $lstMarcas[0]->idmarca;
            $this->nombre = $lstMarcas[0]->nombre;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE marcas SET
            nombre = '$this->nombre'
            WHERE idmarca=?";
        $affected = DB::update($sql, [$this->idmarca]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM marcas WHERE 
            idmarca=?";
        $affected = DB::delete($sql, [$this->idmarca]);
    }

    public function insertar() {
        $sql = "INSERT INTO marcas  (
                nombre
            ) VALUES (?);";
       $result = DB::insert($sql, [
            $this->nombre
        ]);
       return $this->idmarca= DB::getPdo()->lastInsertId();
    }


}
