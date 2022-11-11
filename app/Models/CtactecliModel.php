<?php

namespace App\Models ;
use CodeIgniter\Model ;

class CtactecliModel extends Model {

    protected $table      = 'ctactecli';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['cliente_id','fch', 'tcomp', 'id_comp', 'origen', 
    'detalle', 'debito', 'credito', 'activo','id_rlabor', 'id_usuario'];

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