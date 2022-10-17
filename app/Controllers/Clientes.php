<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClientesModel;
use App\Models\DetalleModel;
use App\Models\GruposModel;
use App\Models\TipodocModel;
use App\Models\TiporesModel;
use CodeIgniter\Validation\Validation;

class Clientes extends BaseController
{

    protected $clientes, $session, $accesos;
    protected $grupos;
    protected $tipoiva;

    public function __construct()
    {
        $this->session = session();
        $this->clientes = new ClientesModel();
        $this->grupos = new GruposModel();
        $this->tipoiva = new TiporesModel();
        $this->tipodoc = new TipodocModel();
        $this->accesos = new DetalleModel();
    }

    public function index($activo = 1)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'ClientesLista');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $clientes = $this->clientes->where('activo', $activo)->findAll();
            $data = ['titulo' => 'Clientes', 'datos' => $clientes];
            echo view('header');
            echo view('clientes/index', $data);
            echo view('footer');
        }
    }

    public function nuevo()
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'ClientesNuevo');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $grupos = $this->grupos->where('activo', 1)->findAll();
            $tipoiva = $this->tipoiva->where('activo', 1)->findAll();
            $tipodoc = $this->tipodoc->where('activo', 1)->findAll();
            $data = ['titulo' => 'Agregar Cliente', 'grupos' => $grupos, 'tipoiva' => $tipoiva, 'tipodoc' => $tipodoc];
            echo view('header');
            echo view('clientes/nuevo', $data);
            echo view('footer');
        }
    }

    public function insertar()
    {

        if ($this->request->getMethod() == 'post' && $this->validate(['nombre' => 'required', 'email' => 'required'])) {

            $this->clientes->save([
                'nombre' => $this->request->getPost('nombre'),
                'domicilio' => $this->request->getPost('domicilio'),
                'email' => $this->request->getPost('email'),
                'celular' => $this->request->getPost('celular'),
                'tipores' => $this->request->getPost('tipores'),
                'grupo_id' => $this->request->getPost('grupo_id'),
                'tipodoc' => $this->request->getPost('tipodoc'),
                'docu' => $this->request->getPost('docu')
            ]);

            return redirect()->to(base_url() . '/clientes');
        } else {

            $data = ['titulo' => 'Agregar Cliente', 'validation' => $this->validator];

            echo view('header');
            echo view('clientes/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'ClientesEditar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $grupos = $this->grupos->where('activo', 1)->findAll();
            $tipoiva = $this->tipoiva->where('activo', 1)->findAll();
            $tipodoc = $this->tipodoc->where('activo', 1)->findAll();
            $cliente = $this->clientes->where('id', $id)->first();
            $data = ['titulo' => 'Editar Cliente', 'dato' => $cliente, 'grupos' => $grupos, 'tipoiva' => $tipoiva, 'tipodoc' => $tipodoc];
            echo view('header');
            echo view('clientes/editar', $data);
            echo view('footer');
        }
    }

    public function guardar()
    {

        $this->clientes->update(
            $this->request->getPost('id'),
            [
                'nombre' => $this->request->getPost('nombre'),
                'domicilio' => $this->request->getPost('domicilio'),
                'email' => $this->request->getPost('email'),
                'celular' => $this->request->getPost('celular'),
                'tipores' => $this->request->getPost('tipores'),
                'grupo_id' => $this->request->getPost('grupo_id'),
                'tipodoc' => $this->request->getPost('tipodoc'),
                'docu' => $this->request->getPost('docu')
            ]
        );
        return redirect()->to(base_url() . '/clientes');
    }

    public function eliminar($id)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'ClientesEliminar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $this->clientes->update($id, ['activo' => 0]);
            return redirect()->to(base_url() . '/clientes');
        }
    }

    public function restaurar($id)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'ClientesEliminar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {
            $this->clientes->update($id, ['activo' => 1]);
            return redirect()->to(base_url() . '/clientes');
        }
    }

    public function eliminados($activo = 0)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'ClientesLista');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {
            $clientes = $this->clientes->where('activo', $activo)->findAll();
            $data = ['titulo' => 'Clientes Eliminados', 'datos' => $clientes];
            echo view('header');
            echo view('clientes/eliminados', $data);
            echo view('footer');
        }
    }

    public function autocompletedata()
    {
        $returnData = array();
        $valor = $this->request->getGet('term');
        $clientes = $this->clientes->like('nombre', $valor)->where('activo', 1)->findAll();
        if (!empty($clientes)) {
            foreach ($clientes as $row) {
                $data['id'] = $row['id'];
                $data['value'] = $row['nombre'];
                array_push($returnData, $data);
            }
        }

        echo json_encode($returnData);
    }
}
