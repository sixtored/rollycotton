<?php

namespace App\Controllers;
use App\Controllers\BaseController ;
use App\Models\TipodocModel;

class Tipores extends BaseController {

    protected $tipodoc ;

    public function __construct()
    {
        $this->tipodoc = new TipodocModel() ;
    }

    public function index($activo = 1) {

        $tipodoc = $this->tipodoc->where('activo',$activo)->findAll() ;
        $data = ['titulo' => 'Tipores', 'datos' => $tipodoc] ;

        echo view('header') ;
        echo view('tipodoc/index',$data) ;
        echo view('footer') ;
    }

    public function nuevo() {

        $data = ['titulo' => 'Agregar Tipo Docu'] ;
        echo view('header') ;
        echo view('tipodoc/nuevo',$data) ;
        echo view('footer') ;
    }

    public function insertar(){

        $this->tipodoc->save(['nombre'=> $this->request->getPost('nombre'),
        'codigo'=>$this->request->getPost('codigo')
    ]);
        return redirect()->to(base_url() .'/tipodoc') ;
    }

    public function editar($id) {

        $tipodoc = $this->tipodoc->where('id',$id)->first() ;
        $data = ['titulo' => 'Editar Tipo Docu','dato' => $tipodoc] ;
        echo view('header') ;
        echo view('tipodoc/editar',$data) ;
        echo view('footer') ;
    }

    public function guardar(){

        $this->tipodoc->update($this->request->getPost('id'), ['nombre'=> $this->request->getPost('nombre'),
        'codigo'=> $this->request->getPost('codigo')
    ]);
        return redirect()->to(base_url() .'/tipodoc') ;
    }

    public function eliminar($id){

        $this->tipodoc->update($id, ['activo'=> 0]);
        return redirect()->to(base_url() .'/tipodoc') ;
    }

    public function restaurar($id){

        $this->tipodoc->update($id, ['activo'=> 1]);
        return redirect()->to(base_url() .'/tipodoc') ;
    }

    public function eliminados($activo = 0) {

        $tipodoc = $this->tipodoc->where('activo',$activo)->findAll() ;
        $data = ['titulo' => 'Tipores', 'datos' => $tipodoc] ;

        echo view('header') ;
        echo view('tipodoc/eliminados',$data) ;
        echo view('footer') ;
    }

}