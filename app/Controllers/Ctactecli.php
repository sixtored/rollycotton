<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClientesModel;
use App\Models\CtactecliModel;
use App\Models\DetalleModel;
use CodeIgniter\Validation\Validation;

class Ctactecli extends BaseController
{

    protected $ctactecli, $cliente, $accesos, $db, $query, $collumns ;
    protected $reglas;

    public function __construct()
    {
        $this->session = session();
        $this->ctactecli = new CtactecliModel();
        $this->cliente = new ClientesModel();
        $this->accesos = new DetalleModel();
        $this->db = \Config\Database::connect();

               /* AGREGAMOS CAMPOS FALTANTES EN LA BASE CTACTECLI
        */
        $query = "SHOW COLUMNS FROM `ctactecli` WHERE Field = 'id_rlabor'" ;
        $collumns = $this->db->query($query)->getNumRows() ;
        if ($collumns == 0) {
            $query =   "ALTER TABLE ctactecli ADD id_rlabor INT(11) DEFAULT 0 AFTER activo" ;
            $this->db->query($query) ;
        }

             /* AGREGAMOS CAMPOS FALTANTES EN LA BASE CTACTECLI
        */
        $query = "SHOW COLUMNS FROM `ctactecli` WHERE Field = 'id_usuario'" ;
        $collumns = $this->db->query($query)->getNumRows() ;
        if ($collumns == 0) {
            $query =   "ALTER TABLE ctactecli ADD id_usuario INT(11) DEFAULT 0 AFTER activo" ;
            $this->db->query($query) ;
        }


        helper(['form']);
        $this->reglas = [
            'detalle' => ['rules' => 'required', 'errors' => ['required' => 'El campo *Detalle es obligatorio.']]
        ];
    }

    public function index($id, $activo = 1)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }
        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'Clietesctacte');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $cliente = $this->cliente->where(['activo' => 1, 'id' => $id])->first();
            $ctactecli = $this->ctactecli->where('activo', $activo)->findAll();
            $data = ['titulo' => 'ctactecli', 'datos' => $ctactecli, 'cliente' => $cliente];
            echo view('header');
            echo view('ctactecli/index', $data);
            echo view('footer');
        }
    }

    public function ctacli($id, $activo = 1)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'Clientesctacte');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $query = "SELECT ct.id,
            ct.fch,
            ct.detalle,
            ct.debito,
            ct.credito,
            (SELECT sum(ct1.debito) - sum(ct1.credito) as saldo
            FROM ctactecli as ct1 WHERE ct1.id <= ct.id and ct1.activo = 1 and ct1.cliente_id = {$id}) as saldo,
            ct.origen,
            ct.tcomp,
            ct.id_comp
            FROM ctactecli as ct where ct.cliente_id = {$id} and ct.activo = 1";

            $cliente = $this->cliente->where(['activo' => 1, 'id' => $id])->first();
            $ctactecli = $this->db->query($query)->getResultArray();
            $saldo = 0.00;
            foreach ($ctactecli as $row) {
                $saldo += ($row['debito'] - $row['credito']);
            }
            // $ctactecli = $this->ctactecli->where('activo', $activo)->findAll();
            $data = ['titulo' => 'Cuenta Corriente', 'datos' => $ctactecli, 'cliente' => $cliente, 'saldo' => $saldo];
            echo view('header');
            echo view('ctactecli/index', $data);
            echo view('footer');
        }
    }


    public function nuevo($id)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'CtacteNuevo');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $query = "SELECT ct.id,
            ct.fch,
            ct.detalle,
            ct.debito,
            ct.credito,
            ct.origen,
            ct.tcomp,
            ct.id_comp
            FROM ctactecli as ct where ct.cliente_id = {$id} and ct.activo = 1";

            $ctactecli = $this->db->query($query)->getResultArray();
            $saldo = 0.00;
            foreach ($ctactecli as $row) {
                $saldo += ($row['debito'] - $row['credito']);
            }

            $cliente = $this->cliente->where(['activo' => 1, 'id' => $id])->first();
            $data = ['titulo' => 'Agregar', 'cliente' => $cliente, 'saldo' => $saldo];
            echo view('header');
            echo view('ctactecli/nuevo', $data);
            echo view('footer');
        }
    }


    public function insertar()
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $id_usuario = $this->session->id_usuario ;
        $cliente_id = $this->request->getPost('cliente_id');
        $detalle = $this->request->getPost('detalle');
        $importe = $this->request->getPost('importe');
        $tipo = $this->request->getPost('tipo');
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
            $debito = 0.00;
            $credito = 0.00;
            $tcomp = 0;
            $id_comp = 0;
            $origen = 'MA';
            $fch = date('y/m/d H:i:s');
            if ($tipo == 1) {
                $debito = $importe;
            } else {
                $credito = $importe;
            }

            $this->ctactecli->save([
                'cliente_id' => $cliente_id,
                'id_usuario' => $id_usuario,
                'fch' => $fch,
                'detalle' => $detalle,
                '$origen' => $origen,
                'tcomp' => $tcomp,
                'id_comp' => $id_comp,
                'debito' => $debito,
                'credito' => $credito
            ]);

            $id_ctactecli = $this->ctactecli->InsertID();

            $ip = $_SERVER['REMOTE_ADDR'];
            // obtiene ip
            $evento = 'NUEVO';
            $detalles = 'NUEVO REGISTRO CTACTE,' . $id_ctactecli;
            $tipo = 'CTACTE';
            $this->logs->save([
                'id_usuario' => $id_usuario,
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

            return redirect()->to(base_url() . '/ctactecli/ctacli/' . $cliente_id);
        } else {

            $query = "SELECT ct.id,
            ct.fch,
            ct.detalle,
            ct.debito,
            ct.credito,
            ct.origen,
            ct.tcomp,
            ct.id_comp
            FROM ctactecli as ct where ct.cliente_id = {$cliente_id} and ct.activo = 1";

            $ctactecli = $this->db->query($query)->getResultArray();
            $saldo = 0.00;
            foreach ($ctactecli as $row) {
                $saldo += ($row['debito'] - $row['credito']);
            }

            $cliente = $this->cliente->where(['activo' => 1, 'id' => $cliente_id])->first();
            $data = ['titulo' => 'Agregar Mov. Cuenta Corriente', 'cliente' => $cliente, 'saldo' => $saldo, 'validation' => $this->validator];
            echo view('header');
            echo view('ctactecli/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid = null)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'CtacteEditar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {
            $ctactecli = $this->ctactecli->where('id', $id)->first();
            $cliente_id = $ctactecli['cliente_id'];
            $cliente = $this->cliente->where(['activo' => 1, 'id' => $cliente_id])->first();
            $query = "SELECT ct.id,
            ct.fch,
            ct.detalle,
            ct.debito,
            ct.credito,
            ct.origen,
            ct.tcomp,
            ct.id_comp
            FROM ctactecli as ct where ct.cliente_id = {$cliente_id} and ct.activo = 1";

            $ctamov = $this->db->query($query)->getResultArray();
            $saldo = 0.00;
            foreach ($ctamov as $row) {
                $saldo += ($row['debito'] - $row['credito']);
            }
            if ($valid != null) {
                $data = [
                    'titulo' => 'Editar Mov. Cuenta Corriente', 'dato' => $ctactecli, 'cliente' => $cliente,
                    'saldo' => $saldo, 'validation' => $valid
                ];
            } else {
                $data = [
                    'titulo' => 'Editar Mov. Cuenta Corriente', 'dato' => $ctactecli, 'cliente' => $cliente,
                    'saldo' => $saldo
                ];
            }


            echo view('header');
            echo view('ctactecli/editar', $data);
            echo view('footer');
        }
    }

    public function guardar()
    {
        $id_usuario = $this->session->id_usuario ;
        $id = $this->request->getPost('id');
        $cliente_id = $this->request->getPost('cliente_id');
        $detalle = $this->request->getPost('detalle');
        $importe = $this->request->getPost('importe');
        $tipo = $this->request->getPost('tipo');
        $origen = $this->request->getPost('origen');
        //  if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
        $debito = 0.00;
        $credito = 0.00;
        $tcomp = 0;
        $id_comp = 0;

        $fch = date('y/m/d H:i:s');
        if ($tipo == 1) {
            $debito = $importe;
        } else {
            $credito = $importe;
        }


        $this->ctactecli->update(
            $id,
            [
                'cliente_id' => $cliente_id,
                'id_usuario' => $id_usuario, 
                'detalle' => $detalle,
                'tcomp' => $tcomp,
                'id_comp' => $id_comp,
                'origen' => $origen,
                'debito' => $debito,
                'credito' => $credito,
                'fch' => $fch
            ]
        );

        $ip = $_SERVER['REMOTE_ADDR'];
        // obtiene ip
        $evento = 'EDITA';
        $detalles = 'EDITA REGISTRO CTACTE,' . $id;
        $tipo = 'CTACTE';
        $this->logs->save([
            'id_usuario' => $id_usuario,
            'evento' => $evento,
            'ip' => $ip,
            'detalles' => $detalles,
            'tipo' => $tipo
        ]);

        return redirect()->to(base_url() . '/ctactecli/ctacli/' . $cliente_id);
    }


    public function eliminados($id, $activo = 0)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'CtacteEliminar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {
            $query = "SELECT ct.id,
            ct.fch,
            ct.detalle,
            ct.debito,
            ct.credito,
            (SELECT sum(ct1.debito) - sum(ct1.credito) as saldo
            FROM ctactecli as ct1 WHERE ct1.id <= ct.id and ct1.activo = 0 and ct1.cliente_id = {$id}) as saldo,
            ct.origen,
            ct.tcomp,
            ct.id_comp
            FROM ctactecli as ct where ct.cliente_id = {$id} and ct.activo = 0";

            $cliente = $this->cliente->where(['activo' => 1, 'id' => $id])->first();
            $ctactecli = $this->db->query($query)->getResultArray();
            $saldo = 0.00;
            foreach ($ctactecli as $row) {
                $saldo += ($row['debito'] - $row['credito']);
            }
            // $ctactecli = $this->ctactecli->where('activo', $activo)->findAll();
            $data = ['titulo' => 'Eliminados Cuenta Corriente', 'datos' => $ctactecli, 'cliente' => $cliente, 'saldo' => $saldo];
            echo view('header');
            echo view('ctactecli/eliminados', $data);
            echo view('footer');
        }
    }

    public function eliminar($id)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }
        $id_usuario = $this->session->id_usario ;
        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'CtacteEliminar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {
            $ctactecli = $this->ctactecli->where('id', $id)->first();
            $cliente_id = $ctactecli['cliente_id'];
            $this->ctactecli->update($id, ['activo' => 0]);


            $ip = $_SERVER['REMOTE_ADDR'];
            // obtiene ip
            $evento = 'ELIMINA';
            $detalles = 'ELIMINA REGISTRO CTACTE,' . $id;
            $tipo = 'CTACTE';
            $this->logs->save([
                'id_usuario' => $id_usuario,
                'evento' => $evento,
                'ip' => $ip,
                'detalles' => $detalles,
                'tipo' => $tipo
            ]);

            return redirect()->to(base_url() . '/ctactecli/ctacli/' . $cliente_id);
        }
    }

    public function restaurar($id)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }
        $id_usuario = $this->session->id_usario ;
        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'CtacteEliminar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {
            $ctactecli = $this->ctactecli->where('id', $id)->first();
            $cliente_id = $ctactecli['cliente_id'];
            $this->ctactecli->update($id, ['activo' => 1]);
            
            $ip = $_SERVER['REMOTE_ADDR'];
            // obtiene ip
            $evento = 'RESTURA';
            $detalles = 'RESTAURA REGISTRO CTACTE,' . $id;
            $tipo = 'CTACTE';
            $this->logs->save([
                'id_usuario' => $id_usuario,
                'evento' => $evento,
                'ip' => $ip,
                'detalles' => $detalles,
                'tipo' => $tipo
            ]);
            return redirect()->to(base_url() . '/ctactecli/ctacli/' . $cliente_id);
        }
    }
}
