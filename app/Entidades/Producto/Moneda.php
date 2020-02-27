<?php

namespace App\Entidades\Producto;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Moneda extends Model
{
    protected $table = 'monedas';
    public $timestamps = false;

    protected $fillable = [
        'idmoneda', 'nombre'
    ];

    protected $hidden = [

    ];
    public function obtenerTodos() {
        $sql = "SELECT 
                  D.idmoneda,
                  D.nombre
                FROM monedas D";

        $sql .= " ORDER BY D.nombre";
        $lstMonedas = DB::select($sql);
        return $lstMonedas;
    }
}
