<?php

namespace App\Models ;
use CodeIgniter\Model ;

class UsuariosModel extends Model {

    protected $table      = 'usuarios';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['usuario', 'nombre', 'email', 
    'password', 'id_rol', 'id_caja', 'activo'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function traerusuario($id_usuario) {
        $this->select('usuarios.id, usuarios.usuario, usuarios.nombre, usuarios.id_rol, usuarios.id_caja,
         usuarios.email, rl.nombre as rol, ca.nombre as caja') ;
        $this->join('roles as rl', 'rl.id = usuarios.id_rol') ;
        $this->join('cajas as ca', 'ca.id = usuarios.id_caja') ;
        $this->where('usuarios.id',$id_usuario) ;
        $datos = $this->first() ;

        return $datos ;

    }

}