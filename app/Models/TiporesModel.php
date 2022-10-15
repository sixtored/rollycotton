<?php

namespace App\Models ;
use CodeIgniter\Model ;

class TiporesModel extends Model {

    protected $table      = 'tipores';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $useSoftUpdated = false;
    protected $useSoftCreated = false;

    protected $allowedFields = ['nombre', 'codigo', 'activo'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}