<?php

namespace App\Models;

use CodeIgniter\Model;

class ArqueoCajasModel extends Model
{

    protected $table      = 'arqueo_caja';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_caja', 'id_usuario', 'fecha_apertura', 'fecha_cierre', 'monto_inicial', 'monto_final', 'total_ventas', 'estado'];

    protected $useTimestamps = true;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function getdatos($idcaja)
    {
        $this->select('arqueo_caja.*, cajas.nombre');
        $this->join('cajas', 'arqueo_caja.id_caja = cajas.id');
        $this->where('arqueo_caja.id_caja', $idcaja);
        $this->orderBy('arqueo_caja.id','DESC') ;
        $datos = $this->findAll() ;
        return $datos ;
    }
}
