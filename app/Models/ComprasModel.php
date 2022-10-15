<?php

namespace App\Models ;
use CodeIgniter\Model ;

class ComprasModel extends Model {

    protected $table      = 'compras';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['folio', 'total', 'id_cajero', 'activo'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function insertarcompras($id_compra, $total, $id_usuario) {

        $this->insert([
            'folio' => $id_compra,
            'total' => $total,
            'id_cajero' => $id_usuario
        ]) ;

        return $this->insertID() ;
    }

}