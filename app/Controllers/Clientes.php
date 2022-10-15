<?php

namespace App\Controllers;
use App\Controllers\BaseController ;
use App\Models\ClientesModel;
use App\Models\GruposModel ;
use App\Models\TipodocModel;
use App\Models\TiporesModel;
use CodeIgniter\Validation\Validation;

class Clientes extends BaseController {

    protected $clientes ;
    protected $grupos ;
    protected $tipoiva ;

    public function __construct()
    {
        $this->clientes = new ClientesModel() ;
        $this->grupos = new GruposModel() ;
        $this->tipoiva = new TiporesModel() ;
        $this->tipodoc = new TipodocModel();
        
    }

    public function index($activo = 1) {

        $clientes = $this->clientes->where('activo',$activo)->findAll() ;
        $data = ['titulo' => 'Clientes', 'datos' => $clientes] ;
        echo view('header') ;
        echo view('clientes/index',$data) ;
        echo view('footer') ;
    }

    public function nuevo() {

        $grupos = $this->grupos->where('activo',1)->findAll();
        $tipoiva = $this->tipoiva->where('activo',1)->findAll();
        $tipodoc = $this->tipodoc->where('activo',1)->findAll();
        $data = ['titulo' => 'Agregar Cliente','grupos'=> $grupos, 'tipoiva'=>$tipoiva, 'tipodoc'=>$tipodoc] ;
        echo view('header') ;
        echo view('clientes/nuevo',$data) ;
        echo view('footer') ;
    }

    public function insertar(){

        if ($this->request->getMethod() == 'post' && $this->validate(['nombre' => 'required', 'email' => 'required'])) 
        {

        $this->clientes->save(['nombre'=> $this->request->getPost('nombre'),
        'domicilio' => $this->request->getPost('domicilio'),
        'email' => $this->request->getPost('email'),
        'celular' => $this->request->getPost('celular'),
        'tipores' => $this->request->getPost('tipores'),
        'grupo_id' => $this->request->getPost('grupo_id'),
        'tipodoc' => $this->request->getPost('tipodoc'),
        'docu' => $this->request->getPost('docu')
    ]);
        
        return redirect()->to(base_url() .'/clientes') ;
        } else {

            $data = ['titulo' => 'Agregar Cliente', 'validation' => $this -> validator] ;

            echo view('header') ;
            echo view('clientes/nuevo',$data) ;
            echo view('footer') ;

        }
    }

    public function editar($id) {

        $grupos = $this->grupos->where('activo',1)->findAll();
        $tipoiva = $this->tipoiva->where('activo',1)->findAll();
        $tipodoc = $this->tipodoc->where('activo',1)->findAll();
        $cliente = $this->clientes->where('id',$id)->first() ;
        $data = ['titulo' => 'Editar Cliente','dato' => $cliente,'grupos'=>$grupos,'tipoiva'=>$tipoiva,'tipodoc'=>$tipodoc] ;
        echo view('header') ;
        echo view('clientes/editar',$data) ;
        echo view('footer') ;
    }

    public function guardar(){

        $this->clientes->update($this->request->getPost('id'), 
        ['nombre'=> $this->request->getPost('nombre'),
        'domicilio' => $this->request->getPost('domicilio'),
        'email' => $this->request->getPost('email'),
        'celular' => $this->request->getPost('celular'),
        'tipores' => $this->request->getPost('tipores'),
        'grupo_id' => $this->request->getPost('grupo_id'),
        'tipodoc' => $this->request->getPost('tipodoc'),
        'docu' => $this->request->getPost('docu')
    ]);
        return redirect()->to(base_url() .'/clientes') ;
    }

    public function eliminar($id){

        $this->clientes->update($id, ['activo'=> 0]);
        return redirect()->to(base_url() .'/clientes') ;
    }

    public function restaurar($id){

        $this->clientes->update($id, ['activo'=> 1]);
        return redirect()->to(base_url() .'/clientes') ;
    }

    public function eliminados($activo = 0) {

        $clientes = $this->clientes->where('activo',$activo)->findAll() ;
        $data = ['titulo' => 'Clientes Eliminados', 'datos' => $clientes] ;
        echo view('header') ;
        echo view('clientes/eliminados',$data) ;
        echo view('footer') ;
    }

    public function autocompletedata() {
        $returnData = array();
        $valor = $this->request->getGet('term');
        $clientes = $this->clientes->like('nombre', $valor)->where('activo',1)->findAll();
        if (!empty($clientes)) {
            foreach ($clientes as $row){
                $data['id'] = $row['id'] ;
                $data['value'] = $row['nombre'] ;
                array_push($returnData,$data) ;
            }
        }

        echo json_encode($returnData) ;
    }

}