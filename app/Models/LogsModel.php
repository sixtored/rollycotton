<?php
namespace App\Models ;
use CodeIgniter\Model ;

class LogsModel extends Model {

    protected $table      = 'logs';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_usuario', 'evento', 'ip', 'detalles', 'tipo', 'prueba'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function traerlogs(){
        $this->select('logs.*, us.usuario as usuario') ;
        $this->join('usuarios as us', 'logs.id_usuario = us.id' ) ; // INNER JOIN 
        $this->orderBy('logs.created_at','DESC') ;
        $datos = $this->findAll();
        /* Para consultar el query
        print_r($this->getlastQuery()) ;
        */
        return $datos ;

    }

}