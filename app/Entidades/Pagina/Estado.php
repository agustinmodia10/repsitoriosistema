<?php 

namespace App\Entidades\Pagina;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Estado extends Model
{
    protected $table = 'estados';
    public $timestamps = false;

    protected $fillable = [
        'idestado', 'nombre'
    ];

    protected $hidden = [

    ];

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idestado,
                  A.nombre
                FROM estados A";

        $sql .= " ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

}
