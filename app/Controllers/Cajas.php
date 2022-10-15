<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CajasModel;
use App\Models\ArqueoCajasModel;
use App\Models\VentasModel ;
use CodeIgniter\Validation\Validation;

class Cajas extends BaseController
{

    protected $cajas, $arqueocaja, $ventas;
    protected $reglas;

    public function __construct()
    {
        $this->cajas = new CajasModel();
        $this->arqueocaja = new ArqueoCajasModel();
        $this->ventas = new VentasModel() ;
        helper(['form']);
        $this->reglas = [
            'nombre' => ['rules' => 'required', 'errors' => ['required' => 'El campo *{field} es obligatorio.']],
            'numero_caja' => ['rules' => 'required', 'errors' => ['required' => 'El campo *Numero caja es obligatorio.']]
        ];
    }

    public function index($activo = 1)
    {

        $cajas = $this->cajas->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Cajas', 'datos' => $cajas];

        echo view('header');
        echo view('cajas/index', $data);
        echo view('footer');
    }

    public function nuevo()
    {

        $data = ['titulo' => 'Agregar Caja'];
        echo view('header');
        echo view('cajas/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {

        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
            $numero = $this->request->getPost('numero_caja');
            $anumero = str_pad($numero, 8, "0", STR_PAD_LEFT);

            $this->cajas->save([
                'nombre' => $this->request->getPost('nombre'),
                'numero_caja' => $anumero,
                'ubicacion' => $this->request->getPost('ubicacion'),
                'folio' => $this->request->getPost('folio')
            ]);

            return redirect()->to(base_url() . '/cajas');
        } else {

            $data = ['titulo' => 'Agregar Caja', 'validation' => $this->validator];

            echo view('header');
            echo view('cajas/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid = null)
    {

        $unidad = $this->cajas->where('id', $id)->first();

        if ($valid != null) {
            $data = ['titulo' => 'Editar Caja', 'dato' => $unidad, 'validation' => $valid];
        } else {
            $data = ['titulo' => 'Editar Caja', 'dato' => $unidad];
        }
        echo view('header');
        echo view('cajas/editar', $data);
        echo view('footer');
    }

    public function guardar()
    {

        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {
            $numero = $this->request->getPost('numero_caja');
            $anumero = str_pad($numero, 8, "0", STR_PAD_LEFT);

            $this->cajas->update($this->request->getPost('id'), [
                'nombre' => $this->request->getPost('nombre'),
                'nuemro_caja' => $anumero,
                'ubicacion' => $this->request->getPost('ubicacion'),
                'folio' => $this->request->getPost('folio')
            ]);
            return redirect()->to(base_url() . '/cajas');
        } else {
            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {

        $this->cajas->update($id, ['activo' => 0]);
        return redirect()->to(base_url() . '/cajas');
    }

    public function restaurar($id)
    {

        $this->cajas->update($id, ['activo' => 1]);
        return redirect()->to(base_url() . '/cajas');
    }

    public function eliminados($activo = 0)
    {

        $cajas = $this->cajas->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Cajas Eliminadas', 'datos' => $cajas];

        echo view('header');
        echo view('cajas/eliminados', $data);
        echo view('footer');
    }

    public function arqueo($id_caja)
    {

        $arqueocaja = $this->arqueocaja->getdatos($id_caja);
        $data = ['titulo' => 'Cierres de Caja', 'datos' => $arqueocaja];
        echo view('header');
        echo view('cajas/arqueos', $data);
        echo view('footer');
    }

    public function nuevo_arqueo()
    {

        $session = session();

        $existe = 0;
        $existe = $this->arqueocaja->where(['id_caja' => $session->id_caja, 'estado' => 1])->countAllResults();
        if ($existe > 0) {
            echo 'La caja ya esta Abierta..';
            exit;
        }

        if ($this->request->getMethod() == 'post') {

            $fecha = date('Y-m-d H:i:s');


            $this->arqueocaja->save([
                'id_caja' => $session->id_caja,
                'id_usuario' => $session->id_usuario,
                'fecha_apertura' => $fecha,
                'monto_inicial' => $this->request->getPost('monto_inicial'),
                'estado' => 1
            ]);

            return redirect()->to(base_url() . '/cajas');
        } else {
            $caja = $this->cajas->where('id', $session->id_caja)->first();
            $data = ['titulo' => 'Apertura de Caja', 'dato' => $caja, 'session' => $session];
            echo view('header');
            echo view('cajas/nuevo_arqueo', $data);
            echo view('footer');
        }
    }

    public function cerrar_arqueo($id_arqueo = 0)
    {

        $session = session();

        $existe = 0;
        $existe = $this->arqueocaja->where(['id' => $id_arqueo, 'estado' => 0])->countAllResults();
        if ($existe > 0) {
            echo 'Ya esta Cerrada la caja';
            exit;
        }

        if ($this->request->getMethod() == 'post') {

            $fecha = date('Y-m-d H:i:s');


            $this->arqueocaja->update($this->request->getPost('id_arqueo'),[
                'fecha_cierre' => $fecha,
                'monto_final' => $this->request->getPost('monto_final'),
                'total_ventas' => $this->request->getPost('total_ventas'),
                'estado' => 0
            ]);

            return redirect()->to(base_url() . '/cajas');
        } else {
            $caja = $this->cajas->where('id', $session->id_caja)->first();
            $arqueo = $this->arqueocaja->Where('id',$id_arqueo)->first() ;
            $fchdesde = DATE($arqueo['fecha_apertura']) ;
            $fchhasta = date('Y-m-d') ;
            $totalventas = $this->ventas->total_ventas_desdehasta($fchdesde,$fchhasta,$session->id_usuario) ;

            //print_r($this->arqueocaja->getlastQuery($arqueo)) ;

            $data = ['titulo' => 'Cerrar Caja', 'dato' => $caja, 'session' => $session, 'arqueo' =>$arqueo, 'totalventas'=>$totalventas];
            echo view('header');
            echo view('cajas/cerrar_arqueo', $data);
            echo view('footer');
        }
    }
}
