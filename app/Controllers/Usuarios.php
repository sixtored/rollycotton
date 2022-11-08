<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CajasModel;
use App\Models\DetalleModel;
use App\Models\RolesModel;
use App\Models\UsuariosModel;
use App\Models\LogsModel;
use CodeIgniter\Validation\Validation;

class Usuarios extends BaseController
{

    protected $usuarios, $logs, $session, $accesos;
    protected $reglas, $reglaslogin, $reglascambia, $reglasguarda;

    public function __construct()
    {
        $this->session = session();
        $this->usuarios = new UsuariosModel();
        $this->cajas = new CajasModel();
        $this->roles = new RolesModel();
        $this->logs = new LogsModel();
        $this->accesos = new DetalleModel();

        helper(['form']);
        $this->reglas = [
            'usuario' => [
                'rules' => 'required|is_unique[usuarios.usuario,id,{id}]',
                'errors' => [
                    'required' => 'El campo *usuario22 es obligatorio.',
                    'is_unique' => 'El campo *{field} debe ser unico.'
                ]
            ],
            'nombre' => ['rules' => 'required', 'errors' => ['required' => 'El campo *Nombre es obligatorio.']],
            'email'  => [
                'rules' => 'required|valid_email[usuarios.email,id,{id}]',
                'errors' => [
                    'required' => 'El campo *{field} es obligatorio.',
                    'valid_email' => 'debe introducir un email valido.'
                ]
            ],
            'password'  => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo *{field} es obligatorio.'
                ]
            ],
            'rpassword'  => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'El campo *{field} es obligatorio.',
                    'matches' => 'Los password no coinciden ..'
                ]
            ]
        ];

        $this->reglasguarda = [
            'usuario' => [
                'rules' => 'required|is_unique[usuarios.usuario,id,{id}]',
                'errors' => [
                    'required' => 'El campo *usuario22 es obligatorio.',
                    'is_unique' => 'El campo *{field} debe ser unico.'
                ]
            ],
            'nombre' => ['rules' => 'required', 'errors' => ['required' => 'El campo *Nombre es obligatorio.']],
            'email'  => [
                'rules' => 'required|valid_email[usuarios.email,id,{id}]',
                'errors' => [
                    'required' => 'El campo *{field} es obligatorio.',
                    'valid_email' => 'debe introducir un email valido.'
                ]
            ],

        ];

        $this->reglaslogin = [
            'usuario' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo *{field} es obligatorio.'
                ]
            ],
            'password' => ['rules' => 'required', 'errors' => ['required' => 'El campo *{field} es obligatorio.']]
        ];


        $this->reglascambia = [
            'password'  => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo *{field} es obligatorio.'
                ]
            ],
            'rpassword'  => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'El campo *{field} es obligatorio.',
                    'matches' => 'Los password no coinciden ..'
                ]
            ]
        ];
    }

    public function index($activo = 1)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'UsuariosLista');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {
            $usuarios = $this->usuarios->where('activo', $activo)->findAll();
            $data = ['titulo' => 'Usuarios', 'datos' => $usuarios];
            echo view('header');
            echo view('usuarios/index', $data);
            echo view('footer');
        }
    }

    public function nuevo()
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'UsuariosEditar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {
            $cajas = $this->cajas->where('activo', 1)->findAll();
            $roles = $this->roles->where('activo', 1)->findAll();

            $data = ['titulo' => 'Agregar Usuario', 'cajas' => $cajas, 'roles' => $roles];
            echo view('header');
            echo view('usuarios/nuevo', $data);
            echo view('footer');
        }
    }

    public function insertar()
    {

        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {

            $hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

            $this->usuarios->save([
                'usuario' => $this->request->getPost('usuario'),
                'nombre' => $this->request->getPost('nombre'),
                'email' => $this->request->getPost('email'),
                'password' => $hash,
                'id_rol' => $this->request->getPost('id_rol'),
                'id_caja' => $this->request->getPost('id_caja')
            ]);
            return redirect()->to(base_url() . '/usuarios');
        } else {

            $cajas = $this->cajas->where('activo', 1)->findAll();
            $roles = $this->roles->where('activo', 1)->findAll();

            $data = ['titulo' => 'Agregar Usuario', 'cajas' => $cajas, 'roles' => $roles, 'validation' => $this->validator];
            echo view('header');
            echo view('usuarios/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid = null)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'UsuariosEditar');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $cajas = $this->cajas->where('activo', 1)->findAll();
            $roles = $this->roles->where('activo', 1)->findAll();
            $usuario = $this->usuarios->where('id', $id)->first();
            if ($valid != null) {
                $data = ['titulo' => 'Editar Usuario', 'dato' => $usuario, 'cajas' => $cajas, 'roles' => $roles, 'validation' => $valid];
            } else {
                $data = ['titulo' => 'Editar Usuario', 'dato' => $usuario, 'cajas' => $cajas, 'roles' => $roles];
            }

            echo view('header');
            echo view('usuarios/editar', $data);
            echo view('footer');
        }
    }

    public function perfil($id, $valid = null)
    {

        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'UsuariosPerfil');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $cajas = $this->cajas->where('activo', 1)->findAll();
            $roles = $this->roles->where('activo', 1)->findAll();
            // $usuario = $this->usuarios->where('id', $id)->first();
            $usuario = $this->usuarios->traerusuario($id);
            if ($valid != null) {
                $data = ['titulo' => 'Editar Usuario', 'dato' => $usuario, 'cajas' => $cajas, 'roles' => $roles, 'validation' => $valid];
            } else {
                $data = ['titulo' => 'Editar Usuario', 'dato' => $usuario, 'cajas' => $cajas, 'roles' => $roles];
            }

            echo view('header');
            echo view('usuarios/perfil', $data);
            echo view('footer');
        }
    }

    public function guardar()
    {

        if ($this->request->getMethod() == 'post' && $this->validate($this->reglasguarda)) {

            //$hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

            $this->usuarios->update(
                $this->request->getPost('id'),
                [
                    'usuario' => $this->request->getPost('usuario'),
                    'nombre' => $this->request->getPost('nombre'),
                    'email' => $this->request->getPost('email'),
                    'id_rol' => $this->request->getPost('id_rol'),
                    'id_caja' => $this->request->getPost('id_caja')
                ]
            );
            $session = session();
            if ($session->id_usuario == $this->request->getPost('id')) {
            $session->nombre = $this->request->getPost('nombre');
            $session->usuario =  $this->request->getPost('usuario');
            }
            return redirect()->to(base_url().'/inicio');
        } else {
            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {

        $this->usuarios->update($id, ['activo' => 0]);
        return redirect()->to(base_url() . '/usuarios');
    }

    public function restaurar($id)
    {

        $this->usuarios->update($id, ['activo' => 1]);
        return redirect()->to(base_url() . '/usuarios');
    }

    public function eliminados($activo = 0)
    {

        $usuarios = $this->usuarios->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Usuarios Eliminados', 'datos' => $usuarios];
        echo view('header');
        echo view('usuarios/eliminados', $data);
        echo view('footer');
    }

    public function login()
    {
        echo view('login');
    }

    public function valida()
    {

        if ($this->request->getMethod() == 'post' && $this->validate($this->reglaslogin)) {

            $usuario = $this->request->getPost('usuario');
            $password = $this->request->getPost('password');
            $datosUsuario = $this->usuarios->where('usuario', $usuario)->first();

            if ($datosUsuario != null) {

                if (password_verify($password, $datosUsuario['password'])) {
                    $datosSesion = [
                        'id_usuario' => $datosUsuario['id'],
                        'usuario'   => $datosUsuario['usuario'],
                        'nombre'   => $datosUsuario['nombre'],
                        'id_caja'   => $datosUsuario['id_caja'],
                        'id_rol'   => $datosUsuario['id_rol']
                    ];

                    $ip = $_SERVER['REMOTE_ADDR'];
                    // obtiene ip
                    $detalles = $_SERVER['HTTP_USER_AGENT'];
                    // se obitene el dispositivo desde donde se loguea
                    //echo $_SERVER['HTTP_USER_AGENT'] ."\n\n" ;


                    $this->logs->save([
                        'id_usuario' => $datosUsuario['id'],
                        'evento' => 'Inicio de session',
                        'ip' => $ip,
                        'detalles' => $detalles
                    ]);

                    $session = session();
                    $session->set($datosSesion);
                    return redirect()->to(base_url() . '/inicio');
                } else {
                    $data['error'] = 'El password no es correcto..';
                    echo view('login', $data);
                }
            } else {
                $data['error'] = 'El usuario no existe..';
                echo view('login', $data);
            }
        } else {
            $data = ['validation' => $this->validator];
            echo view('login', $data);
        }
    }

    public function logout()
    {

        $session = session();
        $session->destroy();
        return redirect()->to(base_url());
    }

    public function cambiar_contrasenia($id)
    {
        if (!isset($this->session->id_usuario)) {
            return redirect()->to(base_url());
        }

        $acceder = $this->accesos->verificapermisos($this->session->id_rol, 'UsuariosCambiarContrasenia');
        //$acceder = true ;

        if (!$acceder) {
            echo 'No tienes permisos para este modulo';
            echo view('header');
            echo view('notienepermiso');
            echo view('footer');
        } else {

            $usuario = $this->usuarios->where('id', $id)->first();

            $data = ['titulo' => 'Cambiar Password', 'dato' => $usuario];
            echo view('header');
            echo view('usuarios/cambiar_contrasenia', $data);
            echo view('footer');
        }
    }

    public function actuliza_contrasenia()
    {
            $iduser = $this->request->getPost('iduser') ;
        if ($this->request->getMethod() == 'post' && $this->validate($this->reglascambia)) {

            $hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

            $this->usuarios->update($iduser, ['password' => $hash]);

            $usuario = $this->usuarios->where('id', $iduser)->first();

            $data = ['titulo' => 'Cambiar Password', 'dato' => $usuario, 'mensaje' => 'Password modificada correctamente..'];
            echo view('header');
            echo view('usuarios/cambiar_contrasenia', $data);
            echo view('footer');
        } else {

            $usuario = $this->usuarios->where('id', $iduser)->first();

            $data = ['titulo' => 'Cambiar Password', 'dato' => $usuario, 'validation' => $this->validator];
            echo view('header');
            echo view('usuarios/cambiar_contrasenia', $data);
            echo view('footer');
        }
    }
}
