<?php

namespace App\Controllers;
use App\Controllers\BaseController ;
use App\Models\GruposModel;

class Grupos extends BaseController {

    protected $grupos ;

    public function __construct()
    {
        $this->grupos = new GruposModel() ;
    }

    public function index($activo = 1) {

        $grupos = $this->grupos->where('activo',$activo)->findAll() ;
        $data = ['titulo' => 'Grupos', 'datos' => $grupos] ;

        echo view('header') ;
        echo view('grupos/index',$data) ;
        echo view('footer') ;
    }

    public function nuevo() {

        $data = ['titulo' => 'Agregar Grupo'] ;
        echo view('header') ;
        echo view('grupos/nuevo',$data) ;
        echo view('footer') ;
    }

    public function insertar(){

        $this->grupos->save(['nombre'=> $this->request->getPost('nombre')]);
        return redirect()->to(base_url() .'/grupos') ;
    }

    public function editar($id) {

        $grupo = $this->grupos->where('id',$id)->first() ;
        $data = ['titulo' => 'Editar Grupo','dato' => $grupo] ;
        echo view('header') ;
        echo view('grupos/editar',$data) ;
        echo view('footer') ;
    }

    public function guardar(){

        $this->grupos->update($this->request->getPost('id'), ['nombre'=> $this->request->getPost('nombre')]);
        return redirect()->to(base_url() .'/grupos') ;
    }

    public function eliminar($id){

        $this->grupos->update($id, ['activo'=> 0]);
        return redirect()->to(base_url() .'/grupos') ;
    }

    public function restaurar($id){

        $this->grupos->update($id, ['activo'=> 1]);
        return redirect()->to(base_url() .'/grupos') ;
    }

    public function eliminados($activo = 0) {

        $grupos = $this->grupos->where('activo',$activo)->findAll() ;
        $data = ['titulo' => 'Grupos eliminados', 'datos' => $grupos] ;

        echo view('header') ;
        echo view('grupos/eliminados',$data) ;
        echo view('footer') ;
    }

}