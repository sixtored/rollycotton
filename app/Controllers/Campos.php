<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CamposModel;
use App\Models\DetalleModel;

class Campos extends BaseController
{

    protected $campos, $session, $accesos;

    public function __construct()
    {
        $this->session = session();
        $this->campos = new CamposModel();
        $this->accesos = new DetalleModel();
    }

    public function index($activo = 1)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'CamposLista');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $campos = $this->campos->where('activo', $activo)->findAll();
            $data = ['titulo' => 'Campos', 'datos' => $campos];

            echo view('header');
            echo view('campos/index', $data);
            echo view('footer');
        }
    }

    public function nuevo()
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'CamposNuevo');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {
            $data = ['titulo' => 'Agregar Campo'];
            echo view('header');
            echo view('campos/nuevo', $data);
            echo view('footer');
        }
    }

    public function insertar()
    {

        $this->campos->save(['nombre' => $this->request->getPost('nombre')]);
        $this->campos->save(['ubicacion' => $this->request->getPost('ubicacion')]);
        return redirect()->to(base_url() . '/campos');
    }

    public function editar($id)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'CamposEditar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $campo = $this->campos->where('id', $id)->first();
            $data = ['titulo' => 'Editar Campo', 'dato' => $campo];
            echo view('header');
            echo view('campos/editar', $data);
            echo view('footer');
        }
    }

    public function guardar()
    {

        $this->campos->update($this->request->getPost('id'), ['nombre' => $this->request->getPost('nombre')]);
        $this->campos->update($this->request->getPost('id'), ['ubicacion' => $this->request->getPost('ubicacion')]);
        return redirect()->to(base_url() . '/campos');
    }

    public function eliminar($id)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'CamposEliminar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {
            $this->campos->update($id, ['activo' => 0]);
            return redirect()->to(base_url() . '/campos');
        }
    }

    public function restaurar($id)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'CamposEliminar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $this->campos->update($id, ['activo' => 1]);
            return redirect()->to(base_url() . '/campos');
        }
    }

    public function eliminados($activo = 0)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'CamposEliminar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {
            $campos = $this->campos->where('activo', $activo)->findAll();
            $data = ['titulo' => 'Campos eliminados', 'datos' => $campos];

            echo view('header');
            echo view('campos/eliminados', $data);
            echo view('footer');
        }
    }
}
