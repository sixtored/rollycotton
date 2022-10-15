<?php

namespace App\Controllers;
use App\Controllers\BaseController ;
use App\Models\RolesModel;
use App\Models\DetalleModel ;
use App\Models\PermisosModel ;
use CodeIgniter\Validation\Validation;

class Roles extends BaseController {

    protected $roles, $permisos, $detalleper;
    protected $reglas ;

    public function __construct()
    {
        $this->roles = new RolesModel() ;
        $this->detalleper = new DetalleModel() ;
        $this->permisos = new PermisosModel() ;
        helper(['form']) ;
        $this->reglas = ['nombre' => ['rules' => 'required|is_unique[roles.nombre,id,{id}]', 
        'errors' => ['required' => 'El campo *{field} es obligatorio.',
        'is_unique' => 'El campo *{field} debe ser unico.']],
        'rol' => ['rules' =>'required','errors' => ['required' => 'El campo *{field} es obligatorio.']]] ;  
    }

    public function index($activo = 1) {

        $roles = $this->roles->where('activo',$activo)->findAll() ;
        $data = ['titulo' => 'Roles', 'datos' => $roles] ;

        echo view('header') ;
        echo view('roles/index',$data) ;
        echo view('footer') ;
    }

    public function nuevo() {

        $data = ['titulo' => 'Agregar Rol'] ;
        echo view('header') ;
        echo view('roles/nuevo',$data) ;
        echo view('footer') ;
    }

    public function insertar(){

        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) 
        {

        $this->roles->save(['nombre'=> $this->request->getPost('nombre'),
        'rol' => $this->request->getPost('rol'),
        'nota' => $this->request->getPost('nota')]);
        return redirect()->to(base_url() .'/roles') ;
        } else {

            $data = ['titulo' => 'Agregar Rol', 'validation' => $this -> validator] ;

            echo view('header') ;
            echo view('roles/nuevo',$data) ;
            echo view('footer') ;

        }
    }

    public function editar($id, $valid = null) {

        $unidad = $this->roles->where('id',$id)->first() ;

        if ($valid != null) {
            $data = ['titulo' => 'Editar Rol','dato' => $unidad, 'validation' => $valid] ;
        } else {
            $data = ['titulo' => 'Editar Rol','dato' => $unidad] ;
        }
        echo view('header') ;
        echo view('roles/editar',$data) ;
        echo view('footer') ;
    }

    public function guardar(){

        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) 
        {
        $this->roles->update($this->request->getPost('id'), ['nombre'=> $this->request->getPost('nombre'),
        'rol' => $this->request->getPost('rol'), 
        'nota' => $this->request->getPost('nota')]);
        return redirect()->to(base_url() .'/roles');
        } else {
            return $this->editar($this->request->getPost('id'),$this->validator) ;
        }

    }

    public function eliminar($id){

        $this->roles->update($id, ['activo'=> 0]);
        return redirect()->to(base_url() .'/roles') ;
    }

    public function restaurar($id){

        $this->roles->update($id, ['activo'=> 1]);
        return redirect()->to(base_url() .'/roles') ;
    }

    public function eliminados($activo = 0) {

        $roles = $this->roles->where('activo',$activo)->findAll() ;
        $data = ['titulo' => 'Roles Eliminados', 'datos' => $roles] ;

        echo view('header') ;
        echo view('roles/eliminados',$data) ;
        echo view('footer') ;
    }

    public function detalles($id_rol) {

        $menus = $this->permisos->findAll() ;
        $perasign = $this->detalleper->where('id_rol',$id_rol)->findAll() ;
        $datos = array() ;
        foreach ($perasign as $pasign) {
            $datos[$pasign['id_permiso']] = true ;
        }

       // print_r($datos) ;
        
        $data = ['titulo'=> 'Asignar Permisos', 'permisos' => $menus,'id_rol' => $id_rol, 'asignado' => $datos] ;
        echo view('header') ;
        echo view('roles/detalles',$data) ;
        echo view('footer') ;
    }

    public function guardapermisos(){

        if ($this->request->getMethod() == "post") {

            $id_rol = $this->request->getPost('id_rol') ;
            $permisos = $this->request->getPost('permisos') ;
            $this->detalleper->where('id_rol',$id_rol)->delete() ;

            foreach($permisos as $permiso) {

                $this->detalleper->save([
                    'id_rol' => $id_rol ,
                    'id_permiso' => $permiso
                ]) ;

            }
            return redirect()->to(base_url() .'/roles') ;

        }
       
    }

}