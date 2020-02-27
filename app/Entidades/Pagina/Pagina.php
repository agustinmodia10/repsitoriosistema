<?php 

namespace App\Entidades\Pagina;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Pagina extends Model
{
    protected $table = 'paginas';
    public $timestamps = false;

    protected $fillable = [
        'idpagina', 'titulo', 'subtitulo', 'contenido', 'fecha_creacion', 'fecha_publicacion', 'fk_idestado'
    ];

    protected $hidden = [

    ];


    function cargarDesdeRequest($request) {
        $this->idpagina = $request->input('id')!="0" ? $request->input('id') : $this->idpagina;
        $this->titulo = $request->input('txtTitulo');
        $this->subtitulo = $request->input('txtSubtitulo');
        $this->contenido = $request->input('txtContenido');
        $this->fecha_creacion = $request->input('dateFechaCreacion');
        $this->fecha_publicacion = $request->input('dateFechaPublicacion');
        $this->estado = $request->input('lstEstado');
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.titulo',
           1 => 'A.subtitulo',
           2 => 'A.fecha_creacion',
           3 => 'A.fecha_publicacion',
           4 => 'B.nombre'
            );
        $sql = "SELECT DISTINCT
                    A.idpagina,
                    A.titulo,
                    A.subtitulo,
                    A.fecha_creacion,
                    A.fecha_publicacion,
                    B.nombre as estado
                    FROM paginas A
                    LEFT JOIN estados B ON A.fk_idestado = B.idestado
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.titulo LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.subtitulo LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.fecha_creacion LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.fecha_publicacion LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.nombre LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idpagina,
                  A.titulo
                FROM paginas A";

        $sql .= " ORDER BY A.titulo";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
  
    public function obtenerPorId($idpagina) {
        $sql = "SELECT
                idpagina,
                titulo,
                subtitulo,
                fecha_creacion,
                fecha_publicacion
                FROM paginas WHERE idpagina = '$idpagina'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idpagina = $lstRetorno[0]->idpagina;
            $this->titulo = $lstRetorno[0]->titulo;
            $this->subtitulo = $lstRetorno[0]->subtitulo;
            $this->fecha_creacion = $lstRetorno[0]->fecha_creacion;
            $this->fecha_publicacion = $lstRetorno[0]->fecha_publicacion;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE paginas SET
            titulo='$this->titulo',
            subtitulo='$this->subtitulo',
            fecha_creacion='$this->fecha_creacion',
            fecha_publicacion='$this->fecha_publicacion',
            contenido='$this->contenido'
            WHERE idpagina=?";
        $affected = DB::update($sql, [$this->idpagina]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM paginas WHERE 
            idpagina=?";
        $affected = DB::delete($sql, [$this->idpagina]);
    }

    public function insertar() {
        $sql = "INSERT INTO paginas (
                titulo,
                subtitulo,
                contenido,
                fecha_creacion,
                fecha_publicacion
            ) VALUES (?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [
            $this->titulo, 
            $this->subtitulo, 
            $this->contenido, 
            $this->fecha_creacion, 
            $this->fecha_publicacion
        ]);
       return $this->idpagina = DB::getPdo()->lastInsertId();
    }

}
?>

    