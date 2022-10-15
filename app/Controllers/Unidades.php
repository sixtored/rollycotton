<?php

namespace App\Controllers;
use App\Controllers\BaseController ;
use App\Models\UnidadesModel;
use CodeIgniter\Validation\Validation;

class Unidades extends BaseController {

    protected $unidades ;
    protected $reglas ;

    public function __construct()
    {
        $this->unidades = new UnidadesModel() ;
        helper(['form']) ;
        $this->reglas = ['nombre' => ['rules' =>'required','errors' => ['required' => 'El campo *{field} es obligatorio.']],
        'nombre_corto' => ['rules' =>'required','errors' => ['required' => 'El campo *Nombre corto es obligatorio.']]] ;  
    }

    public function index($activo = 1) {

        $unidades = $this->unidades->where('activo',$activo)->findAll() ;
        $data = ['titulo' => 'Unidades', 'datos' => $unidades] ;

        echo view('header') ;
        echo view('unidades/index',$data) ;
        echo view('footer') ;
    }

    public function nuevo() {

        $data = ['titulo' => 'Agregar Unidad'] ;
        echo view('header') ;
        echo view('unidades/nuevo',$data) ;
        echo view('footer') ;
    }

    public function insertar(){

        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) 
        {

        $this->unidades->save(['nombre'=> $this->request->getPost('nombre'),
        'nombre_corto' => $this->request->getPost('nombre_corto')]);
        return redirect()->to(base_url() .'/unidades') ;
        } else {

            $data = ['titulo' => 'Agregar Unidad', 'validation' => $this -> validator] ;

            echo view('header') ;
            echo view('unidades/nuevo',$data) ;
            echo view('footer') ;

        }
    }

    public function editar($id, $valid = null) {

        $unidad = $this->unidades->where('id',$id)->first() ;

        if ($valid != null) {
            $data = ['titulo' => 'Editar Unidad','dato' => $unidad, 'validation' => $valid] ;
        } else {
            $data = ['titulo' => 'Editar Unidad','dato' => $unidad] ;
        }
        echo view('header') ;
        echo view('unidades/editar',$data) ;
        echo view('footer') ;
    }

    public function guardar(){

        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) 
        {
        $this->unidades->update($this->request->getPost('id'), ['nombre'=> $this->request->getPost('nombre'),
        'nombre_corto' => $this->request->getPost('nombre_corto')]);
        return redirect()->to(base_url() .'/unidades') ;
        } else {
            return $this->editar($this->request->getPost('id'),$this->validator) ;
        }

    }

    public function eliminar($id){

        $this->unidades->update($id, ['activo'=> 0]);
        return redirect()->to(base_url() .'/unidades') ;
    }

    public function restaurar($id)
    {

        $this->unidades->update($id, ['activo' => 1]);
        return redirect()->to(base_url() . '/unidades');
    }

    public function eliminados($activo = 0) {

        $unidades = $this->unidades->where('activo',$activo)->findAll() ;
        $data = ['titulo' => 'Unidades', 'datos' => $unidades] ;

        echo view('header') ;
        echo view('unidades/eliminados',$data) ;
        echo view('footer') ;
    }

}