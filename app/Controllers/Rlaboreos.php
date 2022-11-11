<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CamposModel;
use App\Models\ClientesModel;
use App\Models\CtactecliModel;
use App\Models\RlaboreosModel;
use App\Models\DetalleModel;
use App\Models\LogsModel;
use App\Models\ToperacionModel;
use CodeIgniter\Validation\Validation;

class Rlaboreos extends BaseController
{

    protected $session, $rlaboreo, $cliente, $accesos, $db, $campo, $topercaion, $logs;
    protected $reglas, $ctactecli;

    public function __construct()
    {
        $this->session = session();
        $this->rlaboreo = new RlaboreosModel();
        $this->cliente = new ClientesModel();
        $this->campo = new CamposModel();
        $this->topercaion = new ToperacionModel();
        $this->accesos = new DetalleModel();
        $this->logs = new LogsModel();
        $this->ctactecli = new CtactecliModel();
        $this->db = \Config\Database::connect();

        helper(['form']);
        $this->reglas = [
            'cliente_id' => ['rules' => 'required', 'errors' => ['required' => 'El campo *Cliente es obligatorio.']],
            'op_id' => ['rules' => 'required', 'errors' => ['required' => 'El campo *Operacion es obligatorio.']],
            'detalle' => ['rules' => 'required', 'errors' => ['required' => 'El campo *Detalle es obligatorio.']],
            'monto' => ['rules' => 'required', 'errors' => ['required' => 'El campo *monto es obligatorio.']],
            'id_campo' => ['rules' => 'required', 'errors' => ['required' => '*Es obligatorio seleccionar un campo.']]
        ];
    }

    public function index($activo = 1)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'LaboresLista');
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

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'LaboresCampo');
        $lista = $this->accesos->verificapermisos($this->session->id_rol, 'LaboresLista');

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $id_usuario = $this->session->id_usuario;
            if ($lista) {
                $filtro = " and 1 = 1";
            } else {
                $filtro = " and rl.id_usuario = {$id_usuario}";
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
            where rl.id_campo = {$id_campo} and rl.activo = 1" . $filtro;

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

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'LaboresLista');
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

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'LaboresCampoNuevo');
        $lista = $this->accesos->verificapermisos($this->session->id_rol, 'LaboresLista');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $id_usuario = $this->session->id_usuario;
            if ($lista) {
                $filtro = " and 1 = 1";
            } else {
                $filtro = " and rl.id_usuario = {$id_usuario}";
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
            where rl.id_campo = {$id_campo} and rl.activo = 1" . $filtro;

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
    }

    public function nuevo1()
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'LaboresNuevo');
        $lista = $this->accesos->verificapermisos($this->session->id_rol, 'LaboresLista');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $id_usuario = $this->session->id_usuario;
            if ($lista) {
                $filtro = " and 1 = 1";
            } else {
                $filtro = " and rl.id_usuario = {$id_usuario}";
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
            where rl.activo = 1" . $filtro;

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
    }


    public function insertar()
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }
        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'LaboresCampoNuevo');
        $lista = $this->accesos->verificapermisos($this->session->id_rol, 'LaboresLista');

        $cliente_id = $this->request->getPost('cliente_id');
        $detalle = $this->request->getPost('detalle');
        $id_campo = $this->request->getPost('id_campo');
        $monto = $this->request->getPost('monto');
        $litros = $this->request->getPost('litros');
        $op_id = $this->request->getPost('op_id');
        $id_us = $this->session->id_usuario;

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

            // CARGAMOS EL DEBITO EN LA CTACTECLIENTE
            $this->ctactecli->save([
                'cliente_id' => $cliente_id,
                'fch' => $fch,
                'id_usuario' => $id_us,
                'origen' => 'LABOR',
                'detalle' => '[LABOR] ' . $detalle,
                'debito' => $monto,
                'id_rlabor' => $id_rlaboreo,
            ]);

            /** Logs
             * 
             */
            $ip = $_SERVER['REMOTE_ADDR'];
            // obtiene ip
            $evento = 'NUEVO';
            $detalles = 'NUEVO REGISTRO LOBAREO,' . $id_rlaboreo;
            $tipo = 'LABOREOS';
            $this->logs->save([
                'id_usuario' => $id_us,
                'evento' => $evento,
                'ip' => $ip,
                'detalles' => $detalles,
                'tipo' => $tipo
            ]);


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
            if (!$this->request->getFile('img_rlaboreo')) {

                $validacion = $this->validate([
                    'img_producto' => [
                        'uploaded[img_rlaboreo]',
                        'mime_in[img_rlaboreo,image/jpg,image/jpeg]',
                        'max_size[img_rlaboreo, 8192]'
                    ]
                ]);

                if ($validacion) {

                    $ruta_logo = "images/rlaboreos/" . $id_rlaboreo . ".jpg";
                    if (file_exists($ruta_logo)) {
                        unlink($ruta_logo);
                    }

                    $img = $this->request->getFile('img_rlaboreo');
                    $img->move('./images/rlaboreos', $id_rlaboreo . '.jpeg');

                    $info = \Config\Services::image()->withFile($img)->getFile()->getProperties(true);
                    $ancho = $info['width'];
                    $alto = $info['height'];
                    if (($ancho <> 300) or ($alto <> 300)) {
                        $imagen = \Config\Services::image()
                            ->withFile($img)
                            // ->reorient()
                            //->rotate(90)
                            //->fit(250,250,'bottom-left')
                            ->resize(300, 300)
                            //->crop(300,300,50,0)
                            ->save($img);
                    }
                } else {
                    echo 'ERROR en validacion de la Imagen';
                    exit;
                }
            }

            return redirect()->to(base_url() . '/rlaboreos/registro/' . $id_campo);
        } else {
            $id_usuario = $this->session->id_usuario;
            if ($lista) {
                $filtro = " and 1 = 1";
            } else {
                $filtro = " and rl.id_usuario = {$id_usuario}";
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
            where rl.id_campo = {$id_campo} and rl.activo = 1" . $filtro;

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

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'LaboresNuevo');
        $lista = $this->accesos->verificapermisos($this->session->id_rol, 'LaboresLista');

        $cliente_id = $this->request->getPost('cliente_id');
        $detalle = $this->request->getPost('detalle');
        $id_campo = $this->request->getPost('id_campo');
        $monto = $this->request->getPost('monto');
        $litros = $this->request->getPost('litros');
        $op_id = $this->request->getPost('op_id');
        $img = $this->request->getFile('img_rlaboreo');
        $id_us = $this->session->id_usuario;

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


            // CARGAMOS EL DEBITO EN LA CTACTECLIENTE
            $this->ctactecli->save([
                'cliente_id' => $cliente_id,
                'fch' => $fch,
                'id_usuario' => $id_us,
                'origen' => 'LABOR',
                'detalle' => '[LABOR] ' . $detalle,
                'debito' => $monto,
                'id_rlabor' => $id_rlaboreo,
            ]);

            $ip = $_SERVER['REMOTE_ADDR'];
            // obtiene ip
            $evento = 'NUEVO';
            $detalles = 'NUEVO REGISTRO LOBAREO,' . $id_rlaboreo;
            $tipo = 'LABOREOS';
            $this->logs->save([
                'id_usuario' => $id_us,
                'evento' => $evento,
                'ip' => $ip,
                'detalles' => $detalles,
                'tipo' => $tipo
            ]);

            if (empty($img->getname())) {
            } else {
                $validacion = $this->validate([
                    'img_rlaboreo' => [
                        'uploaded[img_rlaboreo]',
                        'mime_in[img_rlaboreo,image/jpg,image/jpeg]',
                        'max_size[img_rlaboreo, 4096]'
                    ]
                ]);

                if ($validacion) {

                    $ruta_logo = "images/rlaboreos/" . $id_rlaboreo . ".jpg";
                    if (file_exists($ruta_logo)) {
                        unlink($ruta_logo);
                    }

                    //$img = $this->request->getFile('img_rlaboreo');
                    $img->move('./images/rlaboreos', $id_rlaboreo . '.jpeg', true);
                } else {
                    echo 'ERROR en validacion de la Imagen';
                    exit;
                }
            }

            return redirect()->to(base_url() . '/rlaboreos/index');
        } else {

            $id_usuario = $this->session->id_usuario;
            if ($lista) {
                $filtro = " and 1 = 1";
            } else {
                $filtro = " and rl.id_usuario = {$id_usuario}";
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
            where rl.activo = 1".$filtro ;

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

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'LaboresCampoEditar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
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
    }


    public function editar1($id)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'LaboresEditar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
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
        $img = $this->request->getFile('img_rlaboreo');
        $id_us = $this->session->id_usuario;

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

            $datoscta = $this->ctactecli->where(['id_rlabor' => $id])->first();
            $idcta =  0;
            if (isset($datoscta['id'])) {
                $idcta = $datoscta['id'];
            }
            // CARGAMOS EL DEBITO EN LA CTACTECLIENTE
            if ($idcta > 0) {
                $this->ctactecli->save([
                    $idcta,
                    'cliente_id' => $cliente_id,
                    'fch' => $fch,
                    'id_usuario' => $id_us,
                    'origen' => 'LABOR',
                    'detalle' => '[LABOR] ' . $detalle,
                    'debito' => $monto,
                    'id_rlabor' => $id
                ]);
            }

            $ip = $_SERVER['REMOTE_ADDR'];
            // obtiene ip
            $evento = 'EDITA';
            $detalles = 'EDITA REGISTRO LOBAREO,' . $id;
            $tipo = 'LABOREOS';
            $this->logs->save([
                'id_usuario' => $id_us,
                'evento' => $evento,
                'ip' => $ip,
                'detalles' => $detalles,
                'tipo' => $tipo
            ]);

            if (empty($img->getname())) {
            } else {
                $validacion = $this->validate([
                    'img_rlaboreo' => [
                        'uploaded[img_rlaboreo]',
                        'mime_in[img_rlaboreo,image/jpg,image/jpeg]',
                        'max_size[img_rlaboreo, 4096]'
                    ]
                ]);

                if ($validacion) {

                    $ruta_logo = "images/rlaboreos/" . $id . ".jpg";
                    if (file_exists($ruta_logo)) {
                        unlink($ruta_logo);
                    }

                    //$img = $this->request->getFile('img_rlaboreo');
                    $img->move('./images/rlaboreos', $id . '.jpeg', true);
                } else {
                    echo 'ERROR en validacion de la Imagen';
                    exit;
                }
            }

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
        $id_us = $this->session->id_usuario;
        $img = $this->request->getFile('img_rlaboreo');
        //$nombre = $img->getname() ;
        // var_dump($nombre) ;
        //exit ;
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

            $datoscta = $this->ctactecli->where(['id_rlabor' => $id])->first();
            $idcta = 0;
            if (isset($datoscta['id'])) {
                $idcta = $datoscta['id'];
            }
            // CARGAMOS EL DEBITO EN LA CTACTECLIENTE
            if ($idcta > 0) {
                $this->ctactecli->save([
                    $idcta,
                    'id_cliente' => $cliente_id,
                    'fch' => $fch,
                    'id_usuario' => $id_us,
                    'origen' => 'LABOR',
                    'detalle' => '[LABOR] ' . $detalle,
                    'debito' => $monto,
                    'id_rlabor' => $id
                ]);
            }

            $ip = $_SERVER['REMOTE_ADDR'];
            // obtiene ip
            $evento = 'EDITA';
            $detalles = 'EDITA REGISTRO LOBAREO,' . $id . ',' . $detalle;
            $tipo = 'LABOREOS';
            $this->logs->save([
                'id_usuario' => $id_us,
                'evento' => $evento,
                'ip' => $ip,
                'detalles' => $detalles,
                'tipo' => $tipo
            ]);


            if (empty($img->getname())) {
            } else {
                $validacion = $this->validate([
                    'img_rlaboreo' => [
                        'uploaded[img_rlaboreo]',
                        'mime_in[img_rlaboreo,image/jpg,image/jpeg]',
                        'max_size[img_rlaboreo, 4096]'
                    ]
                ]);

                if ($validacion) {

                    $ruta_logo = "images/rlaboreos/" . $id . ".jpg";
                    if (file_exists($ruta_logo)) {
                        unlink($ruta_logo);
                    }

                    //$img = $this->request->getFile('img_rlaboreo');
                    $img->move('./images/rlaboreos', $id . '.jpeg', true);
                    /** 
                    $info=\Config\Services::image()->withFile($img)->getFile()->getProperties(true);
                    $ancho=$info['width'];
                    $alto=$info['height'];
                    if (($ancho <> 150) OR ($alto <> 150)){
                        $imagen=\Config\Services::image()
                        ->withFile($img)
                       // ->reorient()
                        //->rotate(90)
                        //->fit(250,250,'bottom-left')
                        ->resize(300,300)
                        //->crop(300,300,50,0)
                        ->save($ruta_logo);
                        
                    }
                     */
                } else {
                    echo 'ERROR en validacion de la Imagen';
                    exit;
                }
            }

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
            where rl.activo = 1 ";

            $rlabor = $this->rlaboreo->where(['id' => $id])->first();
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

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'LaboresCampoEliminar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $rlabor = $this->rlaboreo->where(['id' => $id_rlabor])->first();
            $id_campo = $rlabor['id_campo'];

            $this->rlaboreo->update($id_rlabor, ['activo' => 0]);

            $ip = $_SERVER['REMOTE_ADDR'];
            // obtiene ip
            $id_us = $this->session->id_usuario;
            $evento = 'ELIMINA';
            $detalles = 'ELIMINA REGISTRO LOBAREO,' . $id_rlabor;
            $tipo = 'LABOREOS';
            $this->logs->save([
                'id_usuario' => $id_us,
                'evento' => $evento,
                'ip' => $ip,
                'detalles' => $detalles,
                'tipo' => $tipo
            ]);

            return redirect()->to(base_url() . '/rlaboreos/registro/' . $id_campo);
        }
    }

    public function restaurar($id_rlabor)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'LaboresCampoEliminar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $rlabor = $this->rlaboreo->where(['id' => $id_rlabor])->first();
            $id_campo = $rlabor['id_campo'];

            $this->rlaboreo->update($id_rlabor, ['activo' => 1]);
            $id_us = $this->session->id_usuario;
            $ip = $_SERVER['REMOTE_ADDR'];
            // obtiene ip
            $evento = 'RESTAURA';
            $detalles = 'RESTAURA REGISTRO LOBAREO,' . $id_rlabor;
            $tipo = 'LABOREOS';
            $this->logs->save([
                'id_usuario' => $id_us,
                'evento' => $evento,
                'ip' => $ip,
                'detalles' => $detalles,
                'tipo' => $tipo
            ]);

            return redirect()->to(base_url() . '/rlaboreos/registro/' . $id_campo);
        }
    }

    public function eliminar1($id_rlabor)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'LaboresEliminar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $rlabor = $this->rlaboreo->where(['id' => $id_rlabor])->first();
            $id_campo = $rlabor['id_campo'];

            $this->rlaboreo->update($id_rlabor, ['activo' => 0]);

            $ip = $_SERVER['REMOTE_ADDR'];
            // obtiene ip
            $evento = 'ELIMINA';
            $id_us = $this->session->id_usuario;
            $detalles = 'ELIMINA REGISTRO LOBAREO,' . $id_rlabor;
            $tipo = 'LABOREOS';
            $this->logs->save([
                'id_usuario' => $id_us,
                'evento' => $evento,
                'ip' => $ip,
                'detalles' => $detalles,
                'tipo' => $tipo
            ]);

            return redirect()->to(base_url() . '/rlaboreos/index');
        }
    }

    public function restaurar1($id_rlabor)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'LaboresEliminar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $rlabor = $this->rlaboreo->where(['id' => $id_rlabor])->first();
            $id_campo = $rlabor['id_campo'];

            $this->rlaboreo->update($id_rlabor, ['activo' => 1]);

            $ip = $_SERVER['REMOTE_ADDR'];
            // obtiene ip
            $evento = 'RESTAURA';
            $id_us = $this->session->id_usuario;
            $detalles = 'RESTAURA REGISTRO LOBAREO,' . $id_rlabor;
            $tipo = 'LABOREOS';
            $this->logs->save([
                'id_usuario' => $id_us,
                'evento' => $evento,
                'ip' => $ip,
                'detalles' => $detalles,
                'tipo' => $tipo
            ]);

            return redirect()->to(base_url() . '/rlaboreos/index');
        }
    }
}
