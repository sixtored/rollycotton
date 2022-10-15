<?php

namespace App\Models ;
use CodeIgniter\Model ;

class VentasModel extends Model {

    protected $table      = 'ventas';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['folio', 'total', 'id_cajero', 'id_cliente', 'id_caja', 'forma_pago', 'activo'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function insertarventas($id_venta, $total, $id_usuario, $id_caja, $id_cliente, $forma_pago) {

        $this->insert([
            'folio' => $id_venta,
            'total' => $total,
            'id_cajero' => $id_usuario,
            'id_caja' => $id_caja,
            'id_cliente' => $id_cliente,
            'forma_pago' => $forma_pago
        ]) ;

        return $this->insertID() ;
    }

    public function obtener($activo = 1){
        $this->select('ventas.*, us.usuario as cajero, cl.nombre as cliente') ;
        $this->join('usuarios as us', 'ventas.id_cajero = us.id' ) ; // INNER JOIN 
        $this->join('clientes as cl', 'ventas.id_cliente = cl.id') ; // INNER JOIN
        $this->where('ventas.activo',$activo) ;
        $this->orderBy('ventas.created_at','DESC') ;
        $datos = $this->findAll();
        /* Para consultar el query
        print_r($this->getlastQuery()) ;
        */
        return $datos ;

    }

    public function ventas_del_dia($fecha, $id_cajero){
        $where = "activo = 1 AND DATE(created_at) ='$fecha' AND id_cajero = ".$id_cajero ;
        $this->select("sum(total) as total") ;
        return  $this->where($where)->first() ; // conteo de filas
        //print_r($this->getlastQuery($datos)) ;
       // return $datos ;

    }

    public function total_ventas_desdehasta($fchdesde, $fchhasta, $id_cajero){
        $where = "activo = 1 AND DATE(created_at) >= DATE('$fchdesde')  AND DATE(created_at) <= '$fchhasta' AND id_cajero = ".$id_cajero ;
        $this->select("sum(total) as total") ;
        $datos =  $this->where($where)->first() ; // conteo de filas
       // print_r($this->getlastQuery($datos)) ;
        return $datos ;

    }

}