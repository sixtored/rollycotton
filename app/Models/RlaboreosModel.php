<?php

namespace App\Models ;
use CodeIgniter\Model ;

class RlaboreosModel extends Model {

    protected $table      = 'rlaboreos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_campo','id_operacion', 'fecha', 'detalle', 'monto', 
    'litros', 'activo', 'verifica', 'id_usuario', 'id_ctactecli', 'id_cliente'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function agregaStock($id_producto, $cantidad){
        $this->set('existencia',"existencia + $cantidad", FALSE) ;
        $this->where('id',$id_producto) ;
        $this->update() ;
    }

    public function restaStock($id_producto, $cantidad){
        $this->set('existencia',"existencia - $cantidad", FALSE) ;
        $this->where('id',$id_producto) ;
        $this->update() ;
    }

    public function total_productos(){
       return  $this->where('activo',1)->countAllResults(); // conteo de filas

    }

    public function productosSminimo(){
        $where = "stock_min >= existencia AND controla_stock = 1 AND activo = 1" ;
        $this->where($where) ;
        $sql = $this->countAllResults() ;
       // print_r($this->getlastQuery($sql)) ;
       // return $datos ;
        return $sql ;
    }

}