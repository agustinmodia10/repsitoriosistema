<?php

namespace App\Entidades\Producto;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Producto extends Model
{
    protected $table = 'productos';
    public $timestamps = false;

    protected $fillable = [
        'idproducto', 'nombre', 'descripcion', 'fk_idmoneda', 'cantidad', 'fk_idmarca', 'modelo', 'fk_idtipo', 'importe', 'imagen' 
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idproducto = $request->input('id')!="0" ? $request->input('id') : $this->idproducto;
        $this->nombre = $request->input('txtNombre');
        $this->descripcion = $request->input('txtDescripcion');
        $this->fk_idmoneda = $request->input('lstMoneda');
        $this->cantidad = $request->input('txtCantidad');
        $this->fk_idmarca = $request->input('lstMarca');
        $this->modelo = $request->input('txtModelo');
        $this->fk_idtipo = $request->input('lstTipo');
        $this->importe = $request->input('txtImporte');
        
    }
    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.nombre',
           1 => 'B.nombre',
           2 => 'A.modelo',
           3 => 'C.nombre',
           4 => 'A.importe'
         );
        $sql = "SELECT DISTINCT
                    A.idproducto,
                    A.nombre,
                    A.descripcion,
                    A.fk_idmoneda,
                    A.cantidad,
                    A.fk_idmarca,
                    A.modelo,
                    A.fk_idtipo,
                    A.importe,
                    B.nombre AS marca,
                    C.nombre AS tipo
                    FROM productos A
                    LEFT JOIN marcas B ON A.fk_idmarca = B.idmarca
                    LEFT JOIN tipos C ON A.fk_idtipo = C.idtipo
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.modelo LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR C.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.importe LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstProductos = DB::select($sql);

        return $lstProductos;
    }



    public function obtenerPorEsencia() {
        $sql = "SELECT 
                A.idproducto,
                A.nombre,
                B.nombre AS tipoNombre,
                A.imagen
                FROM productos A
                INNER JOIN tipos B
                ON A.fk_idtipo = B.idtipo
                WHERE A.fk_idtipo = 1";
                
        $lstEsencia = DB::select($sql);
        return $lstEsencia;
    }

    public function obtenerTodosPorSistemaFloral() {
        $sql = "SELECT 
                A.idproducto,
                A.nombre,
                B.nombre AS tipoNombre 
                FROM productos A
                INNER JOIN tipos B 
                ON A.fk_idtipo = B.idtipo
                WHERE A.fk_idtipo = 2"; 
        
        $lstFloral = DB::select($sql);
        return $lstFloral;
    } 


    

  

    public function obtenerPorId($idproducto) {
        $sql = "SELECT
                idproducto,
                nombre,
                descripcion,
                fk_idmoneda,
                cantidad,
                fk_idmarca,
                modelo,
                fk_idtipo,
                importe
                FROM productos WHERE idproducto = '$idproducto'";
        $lstProductos = DB::select($sql);

        if(count($lstProductos)>0){
            $this->idproducto = $lstProductos[0]->idproducto;
            $this->nombre = $lstProductos[0]->nombre;
            $this->descripcion = $lstProductos[0]->descripcion;
            $this->fk_idmoneda = $lstProductos[0]->fk_idmoneda;
            $this->cantidad = $lstProductos[0]->cantidad;
            $this->fk_idmarca = $lstProductos[0]->fk_idmarca;
            $this->modelo = $lstProductos[0]->modelo;
            $this->fk_idtipo = $lstProductos[0]->fk_idtipo;
            $this->importe = $lstProductos[0]->importe;
          
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE productos SET
            nombre='$this->nombre',
            descripcion='$this->descripcion',
            fk_idmoneda='$this->fk_idmoneda',
            cantidad='$this->cantidad',
            fk_idmarca='$this->fk_idmarca',
            modelo='$this->modelo',
            fk_idtipo='$this->fk_idtipo',
            importe='$this->importe',
            imagen='$this->imagen'
            WHERE idproducto=?";
        $affected = DB::update($sql, [$this->idproducto]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM productos WHERE 
            idproducto=?";
        $affected = DB::delete($sql, [$this->idproducto]);
    }

    public function insertar() {
        $sql = "INSERT INTO productos (
                nombre,
                descripcion,
                fk_idmoneda,
                cantidad,
                fk_idmarca,
                modelo,
                fk_idtipo,
                importe,
                imagen
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [
            $this->nombre, 
            $this->descripcion, 
            $this->fk_idmoneda, 
            $this->cantidad, 
            $this->fk_idmarca,
            $this->modelo,
            $this->fk_idtipo,
            $this->importe,
            $this->imagen
        ]);
       return $this->idproducto = DB::getPdo()->lastInsertId();
    }


}
