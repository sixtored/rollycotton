<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CamposModel;
use App\Models\ClientesModel;
use App\Models\RlaboreosModel;
use App\Models\DetalleModel;
use App\Models\ToperacionModel;
use CodeIgniter\Validation\Validation;

class Rlaboreos extends BaseController
{

    protected $session, $rlaboreo, $cliente, $accesos, $db, $campo, $topercaion;
    protected $reglas;

    public function __construct()
    {
        $this->session = session();
        $this->rlaboreo = new RlaboreosModel();
        $this->cliente = new ClientesModel();
        $this->campo = new CamposModel();
        $this->topercaion = new ToperacionModel();
        $this->accesos = new DetalleModel();
        $this->db = \Config\Database::connect();

        helper(['form']);
        $this->reglas = [
            'cliente_id' => ['rules' => 'required', 'errors' => ['required' => 'El campo *Cliente es obligatorio.']],
            'op_id' => ['rules' => 'required', 'errors' => ['required' => 'El campo *Operacion es obligatorio.']],
            'detalle' => ['rules' => 'required', 'errors' => ['required' => 'El campo *Detalle es obligatorio.']],
            'monto' => ['rules' => 'required', 'errors' => ['required' => 'El campo *monto es obligatorio.']],
            'litros' => ['rules' => 'required', 'errors' => ['required' => 'El campo *litros es obligatorio.']],
            'id_campo' => ['rules' => 'required', 'errors' => ['required' => '*Es obligatorio seleccionar un campo.']]
        ];
    }

    public function index($activo = 1)
    {
        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'CuentaCorrienteCliente');
        $acceder = true;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $query = "SELECT rl.id,
            rl.fecha,
            rl.id_campo,
            rl.id_operacion,
            rl.detalle,
            rl.monto, 
            rl.litros,
            op.nombre as tipo,
            cl.id as idcliente,
            cl.nombre as cliente,
            ca.nombre as campo
            FROM rlaboreos rl 
            INNER JOIN toperacion op 
            ON op.id = rl.id_operacion
            INNER JOIN clientes cl
            ON cl.id = rl.id_cliente
            INNER JOIN campos ca
            ON ca.id = rl.id_campo
            where rl.activo = {$activo}";

            $rlaboreos = $this->db->query($query)->getResultArray();
            $total = 0.00;
            $litros = 0.00;
            foreach ($rlaboreos as $row) {
                $total += ($row['monto']);
                $litros += ($row['litros']);
            }

            $data = ['titulo' => 'Registro de Labores', 'datos' => $rlaboreos, 'total' => $total, 'litros' => $litros];
            echo view('header');
            echo view('rlaboreos/labores', $data);
            echo view('footer');
        }
    }

    public function registro($id_campo, $activo = 1)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'CuentaCorrienteCliente');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $query = "SELECT rl.id,
            rl.fecha,
            rl.id_campo,
            rl.id_operacion,
            rl.detalle,
            rl.monto, 
            rl.litros,
            op.nombre as tipo,
            cl.id as idcliente,
            cl.nombre as cliente
            FROM rlaboreos rl 
            INNER JOIN toperacion op 
            ON op.id = rl.id_operacion
            INNER JOIN clientes cl
            ON cl.id = rl.id_cliente
            where rl.id_campo = {$id_campo} and rl.activo = 1";

            $campo = $this->campo->where(['activo' => 1, 'id' => $id_campo])->first();
            $rlaboreos = $this->db->query($query)->getResultArray();
            $total = 0.00;
            $litros = 0.00;
            foreach ($rlaboreos as $row) {
                $total += ($row['monto']);
                $litros += ($row['litros']);
            }
            // $ctactecli = $this->ctactecli->where('activo', $activo)->findAll();
            $data = ['titulo' => 'Laboreos ' . $campo['nombre'], 'datos' => $rlaboreos, 'campo' => $campo, 'total' => $total, 'litros' => $litros];
            echo view('header');
            echo view('rlaboreos/index', $data);
            echo view('footer');
        }
    }

    public function eliminados($activo = 0)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'CuentaCorrienteCliente');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $query = "SELECT rl.id,
            rl.fecha,
            rl.id_campo,
            rl.id_operacion,
            rl.detalle,
            rl.monto, 
            rl.litros,
            op.nombre as tipo,
            cl.id as idcliente,
            cl.nombre as cliente,
            ca.nombre as campo
            FROM rlaboreos rl 
            INNER JOIN toperacion op 
            ON op.id = rl.id_operacion
            INNER JOIN clientes cl
            ON cl.id = rl.id_cliente
            INNER JOIN campos ca
            ON ca.id = rl.id_campo
            where rl.activo = {$activo}";

            //$campo = $this->campo->where(['activo' => 1, 'id' => $id_campo])->first();
            $rlaboreos = $this->db->query($query)->getResultArray();
            $total = 0.00;
            $litros = 0.00;
            foreach ($rlaboreos as $row) {
                $total += ($row['monto']);
                $litros += ($row['litros']);
            }
            // $ctactecli = $this->ctactecli->where('activo', $activo)->findAll();
            $data = ['titulo' => 'Laboreos Eliminados ', 'datos' => $rlaboreos, 'total' => $total, 'litros' => $litros];
            echo view('header');
            echo view('rlaboreos/eliminados', $data);
            echo view('footer');
        }
    }


    public function nuevo($id_campo)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $query = "SELECT rl.id,
        rl.fecha,
        rl.id_campo,
        rl.id_operacion,
        rl.detalle,
        rl.monto, 
        rl.litros,
        op.nombre as tipo,
        cl.id as idcliente,
        cl.nombre as cliente
        FROM rlaboreos rl 
        INNER JOIN toperacion op 
        ON op.id = rl.id_operacion
        INNER JOIN clientes cl
        ON cl.id = rl.id_cliente
        where rl.id_campo = {$id_campo} and rl.activo = 1";

        $campo = $this->campo->where(['activo' => 1, 'id' => $id_campo])->first();
        $clientes = $this->cliente->where(['activo' => 1])->findAll();
        $toper = $this->topercaion->where(['activo' => 1])->findAll();
        $rlaboreos = $this->db->query($query)->getResultArray();
        $total = 0.00;
        $litros = 0.00;
        foreach ($rlaboreos as $row) {
            $total += ($row['monto']);
            $litros += ($row['litros']);
        }
        $data = [
            'titulo' => 'Agregar Laboreo', 'datos' => $rlaboreos, 'campo' => $campo, 'clientes' => $clientes, 'total' => $total,
            'litros' => $litros, 'toper' => $toper
        ];

        echo view('header');
        echo view('rlaboreos/nuevo', $data);
        echo view('footer');
    }

    public function nuevo1()
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $query = "SELECT rl.id,
        rl.fecha,
        rl.id_campo,
        rl.id_operacion,
        rl.detalle,
        rl.monto, 
        rl.litros,
        op.nombre as tipo,
        cl.id as idcliente,
        cl.nombre as cliente,
        ca.nombre as campo
        FROM rlaboreos rl 
        INNER JOIN toperacion op 
        ON op.id = rl.id_operacion
        INNER JOIN clientes cl
        ON cl.id = rl.id_cliente
        INNER JOIN campos ca
        ON ca.id = rl.id_campo
        where rl.activo = 1";

        $campo = $this->campo->where(['activo' => 1])->findAll();
        $clientes = $this->cliente->where(['activo' => 1])->findAll();
        $toper = $this->topercaion->where(['activo' => 1])->findAll();
        $rlaboreos = $this->db->query($query)->getResultArray();
        $total = 0.00;
        $litros = 0.00;
        foreach ($rlaboreos as $row) {
            $total += ($row['monto']);
            $litros += ($row['litros']);
        }
        $data = [
            'titulo' => 'Agregar Laboreo', 'datos' => $rlaboreos, 'campo' => $campo, 'clientes' => $clientes, 'total' => $total,
            'litros' => $litros, 'toper' => $toper
        ];

        echo view('header');
        echo view('rlaboreos/nuevo1', $data);
        echo view('footer');
    }


    public function insertar()
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }
        $cliente_id = $this->request->getPost('cliente_id');
        $detalle = $this->request->getPost('detalle');
        $id_campo = $this->request->getPost('id_campo');
        $monto = $this->request->getPost('monto');
        $litros = $this->request->getPost('litros');
        $op_id = $this->request->getPost('op_id');
        $session = session();
        $id_us = $session->id_usuario;

        $fch = date('y/m/d H:i:s');
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {

            $this->rlaboreo->insert([
                'id_cliente' => $cliente_id,
                'fecha' => $fch,
                'id_usuario' => $id_us,
                'detalle' => $detalle,
                'id_campo' => $id_campo,
                'id_operacion' => $op_id,
                'monto' => $monto,
                'litros' => $litros,
            ]);

            $id_rlaboreo = $this->rlaboreo->InsertID();
            /* PARA CARGAR MULTIPLES IMAGENES 
            if ($imagefile = $this->request->getFiles()) {
                $contador = 1 ;
                foreach ($imagefile['img_producto'] as $img) {

                    $ruta = "images/productos/".$id ;
                    if (!file_exists($ruta)){
                        mkdir($ruta,0777,true) ;
                    }

                    if ($img->isValid() && !$img->hasMoved()) {

                        $img->move('./images/productos/'.$id, '/foto_'.$contador.'.jpg');
                        
                        //$newName = $img->getRandomName();
                        //$img->move(WRITEPATH . 'uploads', $newName);
                        
                        $contador ++ ;
                    }
                }
            }
            */  //HASTA AQUI PARA CARGAR MULTIPLES IMAGENES 
            /*
                    $validacion = $this->validate([
                        'img_producto' => [
                            'uploaded[img_producto]',
                            'mime_in[img_producto,image/jpg,image/jpeg]',
                            'max_size[img_producto, 4096]'
                        ]
                    ]);

                    if ($validacion) {

                        $ruta_logo = "images/productos/".$id.".jpg";
                        if (file_exists($ruta_logo)) {
                            unlink($ruta_logo);
                        }

                        $img = $this->request->getFile('img_producto');
                        $img->move('./images/productos', $id.'.jpg');
                    } else {
                        echo 'ERROR en validacion de la Imagen';
                        exit;
                    }
                    */
            return redirect()->to(base_url() . '/rlaboreos/registro/' . $id_campo);
        } else {

            $query = "SELECT rl.id,
        rl.fecha,
        rl.id_campo,
        rl.id_operacion,
        rl.detalle,
        rl.monto, 
        rl.litros,
        op.nombre as tipo,
        cl.id as idcliente,
        cl.nombre as cliente
        FROM rlaboreos rl 
        INNER JOIN toperacion op 
        ON op.id = rl.id_operacion
        INNER JOIN clientes cl
        ON cl.id = rl.id_cliente
        where rl.id_campo = {$id_campo} and rl.activo = 1";

            $campo = $this->campo->where(['activo' => 1, 'id' => $id_campo])->first();
            $clientes = $this->cliente->where(['activo' => 1])->findAll();
            $toper = $this->topercaion->where(['activo' => 1])->findAll();
            $rlaboreos = $this->db->query($query)->getResultArray();
            $total = 0.00;
            $litros = 0.00;
            foreach ($rlaboreos as $row) {
                $total += ($row['monto']);
                $litros += ($row['litros']);
            }
            $data = [
                'titulo' => 'Agregar Laboreo', 'datos' => $rlaboreos, 'campo' => $campo, 'clientes' => $clientes, 'total' => $total,
                'litros' => $litros, 'toper' => $toper, 'validation' => $this->validator
            ];
            echo view('header');
            echo view('rlaboreos/nuevo', $data);
            echo view('footer');
        }
    }


    public function insertar1()
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }
        $cliente_id = $this->request->getPost('cliente_id');
        $detalle = $this->request->getPost('detalle');
        $id_campo = $this->request->getPost('id_campo');
        $monto = $this->request->getPost('monto');
        $litros = $this->request->getPost('litros');
        $op_id = $this->request->getPost('op_id');
        $session = session();
        $id_us = $session->id_usuario;

        $fch = date('y/m/d H:i:s');
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {

            $this->rlaboreo->insert([
                'id_cliente' => $cliente_id,
                'fecha' => $fch,
                'id_usuario' => $id_us,
                'detalle' => $detalle,
                'id_campo' => $id_campo,
                'id_operacion' => $op_id,
                'monto' => $monto,
                'litros' => $litros,
            ]);

            $id_rlaboreo = $this->rlaboreo->InsertID();

            return redirect()->to(base_url() . '/rlaboreos/index');
        } else {

            $query = "SELECT rl.id,
        rl.fecha,
        rl.id_campo,
        rl.id_operacion,
        rl.detalle,
        rl.monto, 
        rl.litros,
        op.nombre as tipo,
        cl.id as idcliente,
        cl.nombre as cliente,
        ca.nombre as campo
        FROM rlaboreos rl 
        INNER JOIN toperacion op 
        ON op.id = rl.id_operacion
        INNER JOIN clientes cl
        ON cl.id = rl.id_cliente
        INNER JOIN campos ca
        ON ca.id = rl.id_campo
        where rl.activo = 1";

            $campo = $this->campo->where(['activo' => 1])->findAll();
            $clientes = $this->cliente->where(['activo' => 1])->findAll();
            $toper = $this->topercaion->where(['activo' => 1])->findAll();
            $rlaboreos = $this->db->query($query)->getResultArray();
            $total = 0.00;
            $litros = 0.00;
            foreach ($rlaboreos as $row) {
                $total += ($row['monto']);
                $litros += ($row['litros']);
            }
            $data = [
                'titulo' => 'Agregar Laboreo', 'datos' => $rlaboreos, 'campo' => $campo, 'clientes' => $clientes, 'total' => $total,
                'litros' => $litros, 'toper' => $toper, 'validation' => $this->validator
            ];
            echo view('header');
            echo view('rlaboreos/nuevo1', $data);
            echo view('footer');
        }
    }

    public function editar($id)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $rlabor = $this->rlaboreo->where(['id' => $id])->first();
        $id_campo = $rlabor['id_campo'];

        $query = "SELECT rl.id,
        rl.fecha,
        rl.id_campo,
        rl.id_operacion,
        rl.detalle,
        rl.monto, 
        rl.litros,
        op.nombre as tipo,
        cl.id as idcliente,
        cl.nombre as cliente
        FROM rlaboreos rl 
        INNER JOIN toperacion op 
        ON op.id = rl.id_operacion
        INNER JOIN clientes cl
        ON cl.id = rl.id_cliente
        where rl.id = {$id_campo} and rl.activo = 1";

        $campo = $this->campo->where(['activo' => 1, 'id' => $id_campo])->first();
        $clientes = $this->cliente->where(['activo' => 1])->findAll();
        $toper = $this->topercaion->where(['activo' => 1])->findAll();
        $rlaboreos = $this->db->query($query)->getResultArray();
        $total = 0.00;
        $litros = 0.00;
        foreach ($rlaboreos as $row) {
            $total += ($row['monto']);
            $litros += ($row['litros']);
        }
        $data = [
            'titulo' => 'Editar Labor', 'datos' => $rlabor, 'campo' => $campo, 'clientes' => $clientes, 'total' => $total,
            'litros' => $litros, 'toper' => $toper
        ];

        echo view('header');
        echo view('rlaboreos/editar', $data);
        echo view('footer');
    }


    public function editar1($id)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $rlabor = $this->rlaboreo->where(['id' => $id])->first();
        $id_campo = $rlabor['id_campo'];

        $query = "SELECT rl.id,
        rl.fecha,
        rl.id_campo,
        rl.id_operacion,
        rl.detalle,
        rl.monto, 
        rl.litros,
        op.nombre as tipo,
        cl.id as idcliente,
        cl.nombre as cliente,
        ca.nombre as campo 
        FROM rlaboreos rl 
        INNER JOIN toperacion op 
        ON op.id = rl.id_operacion
        INNER JOIN clientes cl
        ON cl.id = rl.id_cliente
        INNER JOIN campos ca
        ON ca.id = rl.id_campo
        where  rl.activo = 1";

        $campo = $this->campo->where(['activo' => 1])->findAll();
        $clientes = $this->cliente->where(['activo' => 1])->findAll();
        $toper = $this->topercaion->where(['activo' => 1])->findAll();
        $rlaboreos = $this->db->query($query)->getResultArray();
        $total = 0.00;
        $litros = 0.00;
        foreach ($rlaboreos as $row) {
            $total += ($row['monto']);
            $litros += ($row['litros']);
        }
        $data = [
            'titulo' => 'Editar Labor', 'datos' => $rlabor, 'campo' => $campo, 'clientes' => $clientes, 'total' => $total,
            'litros' => $litros, 'toper' => $toper
        ];

        echo view('header');
        echo view('rlaboreos/editar1', $data);
        echo view('footer');
    }


    public function guardar()
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $id = $this->request->getPost('id');
        $cliente_id = $this->request->getPost('cliente_id');
        $detalle = $this->request->getPost('detalle');
        $id_campo = $this->request->getPost('id_campo');
        $monto = $this->request->getPost('monto');
        $litros = $this->request->getPost('litros');
        $op_id = $this->request->getPost('op_id');
        $session = session();
        $id_us = $session->id_usuario;

        $fch = date('y/m/d H:i:s');
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {

            $this->rlaboreo->update($id, [
                'id_cliente' => $cliente_id,
                'fecha' => $fch,
                'id_usuario' => $id_us,
                'detalle' => $detalle,
                'id_campo' => $id_campo,
                'id_operacion' => $op_id,
                'monto' => $monto,
                'litros' => $litros,
            ]);

            return redirect()->to(base_url() . '/rlaboreos/registro/' . $id_campo);
        } else {

            $rlabor = $this->rlaboreo->where(['id' => $id])->first();
            $id_campo = $rlabor['id_campo'];

            $query = "SELECT rl.id,
            rl.fecha,
            rl.id_campo,
            rl.id_operacion,
            rl.detalle,
            rl.monto, 
            rl.litros,
            op.nombre as tipo,
            cl.id as idcliente,
            cl.nombre as cliente,
            rl.id_usuario
            FROM rlaboreos rl 
            INNER JOIN toperacion op 
            ON op.id = rl.id_operacion
            INNER JOIN clientes cl
            ON cl.id = rl.id_cliente
            where rl.id = {$id_campo} and rl.activo = 1";

            $campo = $this->campo->where(['activo' => 1, 'id' => $id_campo])->first();
            $clientes = $this->cliente->where(['activo' => 1])->findAll();
            $toper = $this->topercaion->where(['activo' => 1])->findAll();
            $rlaboreos = $this->db->query($query)->getResultArray();
            $total = 0.00;
            $litros = 0.00;
            foreach ($rlaboreos as $row) {
                $total += ($row['monto']);
                $litros += ($row['litros']);
            }
            $data = [
                'titulo' => 'Editar Labor', 'datos' => $rlabor, 'campo' => $campo, 'clientes' => $clientes, 'total' => $total,
                'litros' => $litros, 'toper' => $toper, 'validation' => $this->validator
            ];

            echo view('header');
            echo view('rlaboreos/editar', $data);
            echo view('footer');
        }
    }

    public function guardar1()
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $id = $this->request->getPost('id');
        $cliente_id = $this->request->getPost('cliente_id');
        $detalle = $this->request->getPost('detalle');
        $id_campo = $this->request->getPost('id_campo');
        $monto = $this->request->getPost('monto');
        $litros = $this->request->getPost('litros');
        $op_id = $this->request->getPost('op_id');
        $session = session();
        $id_us = $session->id_usuario;

        $fch = date('y/m/d H:i:s');
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {

            $this->rlaboreo->update($id, [
                'id_cliente' => $cliente_id,
                'fecha' => $fch,
                'id_usuario' => $id_us,
                'detalle' => $detalle,
                'id_campo' => $id_campo,
                'id_operacion' => $op_id,
                'monto' => $monto,
                'litros' => $litros,
            ]);

            return redirect()->to(base_url() . '/rlaboreos/index');
        } else {

            $query = "SELECT rl.id,
            rl.fecha,
            rl.id_campo,
            rl.id_operacion,
            rl.detalle,
            rl.monto, 
            rl.litros,
            op.nombre as tipo,
            cl.id as idcliente,
            cl.nombre as cliente,
            rl.id_usuario,
            ca.nombre as campo
            FROM rlaboreos rl 
            INNER JOIN toperacion op 
            ON op.id = rl.id_operacion
            INNER JOIN clientes cl
            ON cl.id = rl.id_cliente
            INNER JOIN campos ca
            ON ca.id = rl.id_campo
            where rl.activo = 1";

            $rlabor = $this->laboreo->where(['id'=>$id])->first() ;
            $campo = $this->campo->where(['activo' => 1])->findAll();
            $clientes = $this->cliente->where(['activo' => 1])->findAll();
            $toper = $this->topercaion->where(['activo' => 1])->findAll();
            $rlaboreos = $this->db->query($query)->getResultArray();
            $total = 0.00;
            $litros = 0.00;
            foreach ($rlaboreos as $row) {
                $total += ($row['monto']);
                $litros += ($row['litros']);
            }
            $data = [
                'titulo' => 'Editar Labor', 'datos' => $rlabor, 'campo' => $campo, 'clientes' => $clientes, 'total' => $total,
                'litros' => $litros, 'toper' => $toper, 'validation' => $this->validator
            ];

            echo view('header');
            echo view('rlaboreos/editar1', $data);
            echo view('footer');
        }
    }


    public function eliminar($id_rlabor)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }
        $rlabor = $this->rlaboreo->where(['id' => $id_rlabor])->first();
        $id_campo = $rlabor['id_campo'];

        $this->rlaboreo->update($id_rlabor, ['activo' => 0]);

        return redirect()->to(base_url() . '/rlaboreos/registro/' . $id_campo);
    }

    public function restaurar($id_rlabor)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }
        $rlabor = $this->rlaboreo->where(['id' => $id_rlabor])->first();
        $id_campo = $rlabor['id_campo'];

        $this->rlaboreo->update($id_rlabor, ['activo' => 1]);

        return redirect()->to(base_url() . '/rlaboreos/registro/' . $id_campo);
    }
}
