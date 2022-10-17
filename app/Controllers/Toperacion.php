<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DetalleModel;
use App\Models\ToperacionModel;

class Toperacion extends BaseController
{

    protected $toperacion, $session, $accesos;

    public function __construct()
    {
        $this->session = session();
        $this->toperacion = new ToperacionModel();
        $this->accesos = new DetalleModel();
    }

    public function index($activo = 1)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'ToperacionLista');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $toperacion = $this->toperacion->where('activo', $activo)->findAll();
            $data = ['titulo' => 'Tipo operacion', 'datos' => $toperacion];

            echo view('header');
            echo view('toperacion/index', $data);
            echo view('footer');
        }
    }

    public function nuevo()
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'ToperacionNuevo');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {
            $data = ['titulo' => 'Agregar Tipo Operacion'];
            echo view('header');
            echo view('toperacion/nuevo', $data);
            echo view('footer');
        }
    }

    public function insertar()
    {

        $this->toperacion->save(['nombre' => $this->request->getPost('nombre')]);
        return redirect()->to(base_url() . '/toperacion');
    }

    public function editar($id)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'ToperacionEditar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {
            $grupo = $this->toperacion->where('id', $id)->first();
            $data = ['titulo' => 'Editar Tipo operacion', 'dato' => $grupo];
            echo view('header');
            echo view('toperacion/editar', $data);
            echo view('footer');
        }
    }

    public function guardar()
    {

        $this->toperacion->update($this->request->getPost('id'), ['nombre' => $this->request->getPost('nombre')]);
        return redirect()->to(base_url() . '/toperacion');
    }

    public function eliminar($id)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'ToperacionEliminar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $this->toperacion->update($id, ['activo' => 0]);
            return redirect()->to(base_url() . '/toperacion');
        }
    }

    public function restaurar($id)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'ToperacionEliminar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $this->toperacion->update($id, ['activo' => 1]);
            return redirect()->to(base_url() . '/toperacion');
        }
    }

    public function eliminados($activo = 0)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'ToperacionLista');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $toperacion = $this->toperacion->where('activo', $activo)->findAll();
            $data = ['titulo' => 'Tipo operacion eliminados', 'datos' => $toperacion];

            echo view('header');
            echo view('toperacion/eliminados', $data);
            echo view('footer');
        }
    }
}
