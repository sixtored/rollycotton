<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DetalleModel;
use App\Models\LogsModel;
use App\Models\UsuariosModel;

class Logs extends BaseController
{

    protected $logs, $usuarios, $session, $accesos, $db, $query, $collumns;

    public function __construct()
    {
        $this->session = session();
        $this->logs = new LogsModel();
        $this->usuarios = new UsuariosModel() ;
        $this->accesos = new DetalleModel();
        $this->db = \Config\Database::connect();

        /* AGREGAMOS CAMPOS FALTANTES EN LA BASE
        */
        $query = "SHOW COLUMNS FROM `logs` WHERE Field = 'tipo'" ;
        $collumns = $this->db->query($query)->getNumRows() ;
        if ($collumns == 0) {
            $query =   "ALTER TABLE logs ADD tipo VARCHAR(50) DEFAULT '' AFTER detalles" ;
            $this->db->query($query) ;
        }


    }

    public function index()
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'LogsLista');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $registros = $this->logs->traerlogs() ; 
            $data = ['titulo' => 'Logs', 'datos' => $registros];

            echo view('header');
            echo view('logs/index', $data);
            echo view('footer');
        }
    }

}
