<?php

namespace App\Models ;
use CodeIgniter\Model ;

class DetalleVentaModel extends Model {

    protected $table      = 'ventas_detalle';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_ventas', 'id_producto' , 'codigo', 'nombre', 'cantidad', 'precio', 'subtotal', 'activo'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function porIdProductoVenta($id_producto, $folio){
        $this->select('*') ;
        $this->where('folio',$folio) ;
        $this->where('id_producto',$id_producto) ;
        $datos = $this->get()->getRow() ;
        return $datos ;
    }

    public function porVenta($folio){
        $this->select('*') ;
        $this->where('folio',$folio) ;
        $datos = $this->findAll() ;
        return $datos ;
    }
    

    public function actulizarproductoventa($id_producto, $folio, $cantidad, $subtotal) {

        $this->set('cantidad',$cantidad) ;
        $this->set('subtotal',$subtotal) ;
        $this->where('id_producto',$id_producto) ;
        $this->where('folio',$folio) ;
        $this->update() ;

    }

    public function eliminarproductoventa($id_producto, $folio) {
        $this->where('id_producto',$id_producto) ;
        $this->where('folio',$folio) ;
        $this->delete() ;

    }
}