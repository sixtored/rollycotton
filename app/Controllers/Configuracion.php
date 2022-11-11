<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConfiguracionModel;
use CodeIgniter\Validation\Validation;

class Configuracion extends BaseController
{

    protected $configuracion;
    protected $reglas;

    public function __construct()
    {
        $this->configuracion = new ConfiguracionModel();
        helper(['form','upload']);
        $this->reglas = [
            'tienda_nombre' => ['rules' => 'required', 'errors' => ['required' => 'El campo *nombre es obligatorio.']],
            'tienda_email' => ['rules' => 'required', 'errors' => ['required' => 'El campo *email es obligatorio.']],
            'tienda_domicilio' => ['rules' => 'required', 'errors' => ['required' => 'El campo *domicilio es obligatorio.']],
            'tienda_telefono' => ['rules' => 'required', 'errors' => ['required' => 'El campo *telefono es obligatorio.']],
            'tiquet_leyenda' => ['rules' => 'required', 'errors' => ['required' => 'El campo *Leyenda Tiquet es obligatorio.']]
        ];
    }

    public function index()
    {
        /*
        $configuracion = $this->configuracion->where('activo',$activo)->findAll() ;*/
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'LaboresCampo');
        //$acceder = true ;
        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

        $nombre = $this->configuracion->where('nombre', 'tienda_nombre')->first();
        $telfono = $this->configuracion->where('nombre', 'tienda_telefono')->first();
        $domicilio = $this->configuracion->where('nombre', 'tienda_domicilio')->first();
        $email = $this->configuracion->where('nombre', 'tienda_email')->first();
        $leyenda = $this->configuracion->where('nombre', 'tiquet_leyenda')->first();

        $data = [
            'titulo' => 'Configuracion', 'nombre' => $nombre, 'telefono' => $telfono, 'domicilio' => $domicilio,
            'email' => $email, 'leyenda' => $leyenda
        ];


        echo view('header');
        echo view('configuracion/index', $data);
        echo view('footer');
        }
    }

    public function guardar()
    {

        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {

        $this->configuracion->whereIn('nombre', ['tienda_nombre'])->set(['valor' =>  $this->request->getPost('tienda_nombre') ])->update();
        $this->configuracion->whereIn('nombre', ['tienda_telefono'])->set(['valor' =>  $this->request->getPost('tienda_telefono') ])->update();
        $this->configuracion->whereIn('nombre', ['tienda_email'])->set(['valor' =>  $this->request->getPost('tienda_email') ])->update();
        $this->configuracion->whereIn('nombre', ['tienda_domicilio'])->set(['valor' =>  $this->request->getPost('tienda_domicilio') ])->update();
        $this->configuracion->whereIn('nombre', ['tiquet_leyenda'])->set(['valor' =>  $this->request->getPost('tiquet_leyenda') ])->update();

        /* Revisar esta parte.. */
        if ($this->request->getFile('tienda_logo')) {
        $validacion = $this->validate([
            'tienda_logo' => [
                'uploaded[tienda_logo]',
                'mime_in[tienda_logo,image/png]',
                'max_size[tienda_logo, 4096]'
            ]
        ]) ;

        if ($validacion){

            $ruta_logo = 'images/logosr.png' ;
            if(file_exists($ruta_logo)){
                unlink($ruta_logo) ;
            }

            $img = $this->request->getFile('tienda_logo');
            $img->move('./images', 'logosr.png') ;

        } else {
            echo 'ERROR en validacion de la Imagen' ;
            exit ;
        }
    }
   
        /*
        $img->move(WRITEPATH .'/uploads') ;
        
        echo $img->getName() ;
        echo $img->getSize() ;
        
        exit ;
        */

            return redirect()->to(base_url() . '/configuracion');
        } /*else {
            return $this->editar($this->request->getPost('id'),$this->validator) ;
        }*/
    }
}
