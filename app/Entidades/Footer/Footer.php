<?php

namespace App\Entidades\Footer;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Footer extends Model
{
  protected $table = 'footers';
  public $timestamps = false;

  protected $fillable = 
  [
   'idfooter', 'telefono', 'email',
    'direccion', 'web', 'instagram',
   'facebook', 'youtube', 'whatsapp'
    ,'twitter', 'github', 'linkedin'
  ];

  protected $hidden = [

  ];


    function cargarDesdeRequest($request) {
        $this->idfooter = $request->input('id')!="0" ? $request->input('id') : $this->idfooter;
        $this->telefono = $request->input('txtTelefono');
        $this->email = $request->input('txtEmail');
        $this->Domicilio = $request->input('txtDomicilio');
        $this->Web = $request->input('txtWeb');
        $this->Instagram = $request->input('txtInstagram');
        $this->Facebook = $request->input('txtFacebook');
        $this->Youtube = $request->input('txtYoutube');
        $this->Whatsapp = $request->input('txtWhatsapp');
        $this->Twitter = $request->input('txtTwitter');
        $this->Github = $request->input('txtGithub');
        $this->Linkedin = $request->input('txtLinkedin');
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.telefono',
           1 => 'A.email'
            );
        $sql = "SELECT DISTINCT
                    A.idfooter,
                    A.telefono,
                    A.email
                    FROM footers A
                    WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
          $sql.=" AND ( A.telefono LIKE '%" . $request['search']['value'] . "%' ";
          $sql.=" OR A.email LIKE '%" . $request['search']['value'] . "%' )";
      }
      $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

      $lstRetorno = DB::select($sql);
// print_r($sql);
// exit;
        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idfooter,
                  A.telefono,
                  A.email
                FROM footers A";

        $sql .= " ORDER BY A.telefono";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    //    public function obtenerMenuPadre() {
    //     $sql = "SELECT DISTINCT
    //               A.idfooter,
    //               A.telefono
    //             FROM footers A
    //             WHERE A.id_padre = 0";

    //     $sql .= " ORDER BY A.telefono";
    //     $lstRetorno = DB::select($sql);
    //     return $lstRetorno;
    // }

    // public function obtenerSubMenu($idfooter=null){
    //     if($idfooter){
    //         $sql = "SELECT DISTINCT
    //                   A.idfooter,
    //                   A.telefono
    //                   A.email
    //                 FROM footers A
    //                 WHERE A.idfooter <> '$idfooter'";

    //         $sql .= " ORDER BY A.telefono";
    //         $resultado = DB::select($sql);
    //     } else {
    //         $resultado = $this->obtenerTodos();
    //     }
    //     return $resultado;
    // }

    public function obtenerPorId($idfooter) {
        $sql = "SELECT
                idfooter,
                telefono,
                email,
                direccion,
                web,
                instagram,
                facebook,
                youtube,
                whatsapp,
                twitter,
                github,
                linkedin
                FROM footers WHERE idfooter = '$idfooter'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idfooter = $lstRetorno[0]->idfooter;
            $this->telefono = $lstRetorno[0]->telefono;
            $this->email = $lstRetorno[0]->email;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE footers SET
            telefono='$this->telefono',
            email='$this->email'
            WHERE idfooter=?";
        $affected = DB::update($sql, [$this->idfooter]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM footers WHERE 
            idfooter=?";
        $affected = DB::delete($sql, [$this->idfooter]);
    }

    public function insertar() {
        $sql = "INSERT INTO footers (
                telefono,
                email
            ) VALUES (?, ?);";
       $result = DB::insert($sql, [
            $this->telefono,
            $this->email

        ]);
       return $this->idfooter = DB::getPdo()->lastInsertId();
    }

    public function obtenerMenuDelGrupo($idGrupo){
        $sql = "SELECT DISTINCT
        A.idfooter,
        A.telefono,
        A.email
        FROM footers A
        -- INNER JOIN sistema_menu_area B ON A.idfooter = B.idfooter
        -- WHERE A.activo = '1' AND B.fk_idarea = $idGrupo ORDER BY A.orden";
        $resultado = DB::select($sql);
        return $resultado;
    }

}
