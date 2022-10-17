<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DetalleModel;
use App\Models\GruposModel;

class Grupos extends BaseController
{

    protected $grupos, $session, $accesos;

    public function __construct()
    {
        $this->session = session();
        $this->grupos = new GruposModel();
        $this->accesos = new DetalleModel();
    }

    public function index($activo = 1)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'GruposLista');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $grupos = $this->grupos->where('activo', $activo)->findAll();
            $data = ['titulo' => 'Grupos', 'datos' => $grupos];

            echo view('header');
            echo view('grupos/index', $data);
            echo view('footer');
        }
    }

    public function nuevo()
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'GruposNuevo');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {
            $data = ['titulo' => 'Agregar Grupo'];
            echo view('header');
            echo view('grupos/nuevo', $data);
            echo view('footer');
        }
    }

    public function insertar()
    {

        $this->grupos->save(['nombre' => $this->request->getPost('nombre')]);
        return redirect()->to(base_url() . '/grupos');
    }

    public function editar($id)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'GruposEditar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {
            $grupo = $this->grupos->where('id', $id)->first();
            $data = ['titulo' => 'Editar Grupo', 'dato' => $grupo];
            echo view('header');
            echo view('grupos/editar', $data);
            echo view('footer');
        }
    }

    public function guardar()
    {

        $this->grupos->update($this->request->getPost('id'), ['nombre' => $this->request->getPost('nombre')]);
        return redirect()->to(base_url() . '/grupos');
    }

    public function eliminar($id)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'GruposEliminar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $this->grupos->update($id, ['activo' => 0]);
            return redirect()->to(base_url() . '/grupos');
        }
    }

    public function restaurar($id)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'GruposEliminar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $this->grupos->update($id, ['activo' => 1]);
            return redirect()->to(base_url() . '/grupos');
        }
    }

    public function eliminados($activo = 0)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'GruposLista');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $grupos = $this->grupos->where('activo', $activo)->findAll();
            $data = ['titulo' => 'Grupos eliminados', 'datos' => $grupos];

            echo view('header');
            echo view('grupos/eliminados', $data);
            echo view('footer');
        }
    }
}
