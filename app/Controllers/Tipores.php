<?php

namespace App\Controllers;
use App\Controllers\BaseController ;
use App\Models\TiporesModel;

class Tipores extends BaseController {

    protected $tipores ;

    public function __construct()
    {
        $this->tipores = new TiporesModel() ;
    }

    public function index($activo = 1) {

        $tipores = $this->tipores->where('activo',$activo)->findAll() ;
        $data = ['titulo' => 'Tipores', 'datos' => $tipores] ;

        echo view('header') ;
        echo view('tipores/index',$data) ;
        echo view('footer') ;
    }

    public function nuevo() {

        $data = ['titulo' => 'Agregar Cond.Iva'] ;
        echo view('header') ;
        echo view('tipores/nuevo',$data) ;
        echo view('footer') ;
    }

    public function insertar(){

        $this->tipores->save(['nombre'=> $this->request->getPost('nombre'),
        'codigo'=>$this->request->getPost('codigo')
    ]);
        return redirect()->to(base_url() .'/tipores') ;
    }

    public function editar($id) {

        $tipores = $this->tipores->where('id',$id)->first() ;
        $data = ['titulo' => 'Editar Cond.Iva','dato' => $tipores] ;
        echo view('header') ;
        echo view('tipores/editar',$data) ;
        echo view('footer') ;
    }

    public function guardar(){

        $this->tipores->update($this->request->getPost('id'), ['nombre'=> $this->request->getPost('nombre'),
        'codigo'=> $this->request->getPost('codigo')
    ]);
        return redirect()->to(base_url() .'/tipores') ;
    }

    public function eliminar($id){

        $this->tipores->update($id, ['activo'=> 0]);
        return redirect()->to(base_url() .'/tipores') ;
    }

    public function restaurar($id){

        $this->tipores->update($id, ['activo'=> 1]);
        return redirect()->to(base_url() .'/tipores') ;
    }

    public function eliminados($activo = 0) {

        $tipores = $this->tipores->where('activo',$activo)->findAll() ;
        $data = ['titulo' => 'Tipores', 'datos' => $tipores] ;

        echo view('header') ;
        echo view('tipores/eliminados',$data) ;
        echo view('footer') ;
    }

}