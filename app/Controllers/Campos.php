<?php

namespace App\Controllers;
use App\Controllers\BaseController ;
use App\Models\CamposModel;

class Campos extends BaseController {

    protected $campos ;

    public function __construct()
    {
        $this->campos = new CamposModel() ;
    }

    public function index($activo = 1) {

        $campos = $this->campos->where('activo',$activo)->findAll() ;
        $data = ['titulo' => 'Campos', 'datos' => $campos] ;

        echo view('header') ;
        echo view('campos/index',$data) ;
        echo view('footer') ;
    }

    public function nuevo() {

        $data = ['titulo' => 'Agregar Campo'] ;
        echo view('header') ;
        echo view('campos/nuevo',$data) ;
        echo view('footer') ;
    }

    public function insertar(){

        $this->campos->save(['nombre'=> $this->request->getPost('nombre')]);
        $this->campos->save(['ubicacion'=> $this->request->getPost('ubicacion')]);
        return redirect()->to(base_url() .'/campos') ;
    }

    public function editar($id) {

        $campo = $this->campos->where('id',$id)->first() ;
        $data = ['titulo' => 'Editar Campo','dato' => $campo] ;
        echo view('header') ;
        echo view('campos/editar',$data) ;
        echo view('footer') ;
    }

    public function guardar(){

        $this->campos->update($this->request->getPost('id'), ['nombre'=> $this->request->getPost('nombre')]);
        $this->campos->update($this->request->getPost('id'), ['ubicacion'=> $this->request->getPost('ubicacion')]);
        return redirect()->to(base_url() .'/campos') ;
    }

    public function eliminar($id){

        $this->campos->update($id, ['activo'=> 0]);
        return redirect()->to(base_url() .'/campos') ;
    }

    public function restaurar($id){

        $this->campos->update($id, ['activo'=> 1]);
        return redirect()->to(base_url() .'/campos') ;
    }

    public function eliminados($activo = 0) {

        $campos = $this->campos->where('activo',$activo)->findAll() ;
        $data = ['titulo' => 'Campos eliminados', 'datos' => $campos] ;

        echo view('header') ;
        echo view('campos/eliminados',$data) ;
        echo view('footer') ;
    }

}