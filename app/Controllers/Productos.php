<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriasModel;
use App\Models\ProductosModel;
use App\Models\UnidadesModel;
use App\Models\DetalleModel;
use CodeIgniter\Validation\Validation;

class Productos extends BaseController
{

    protected $productos, $accesos ;
    protected $reglas;

    public function __construct()
    {
        $this->productos = new ProductosModel();
        $this->unidades = new UnidadesModel();
        $this->categorias = new CategoriasModel();
        $this->accesos = new DetalleModel() ;
        $this->session = session() ;

        helper(['form']);
        $this->reglas = [
            'codigo' => [
                'rules' => 'required|is_unique[productos.codigo]',
                'errors' => [
                    'required' => 'El campo *{field} es obligatorio.',
                    'is_unique' => 'El campo *{field} debe ser unico.'
                ]
            ],
            'nombre' => ['rules' => 'required', 'errors' => ['required' => 'El campo *Nombre es obligatorio.']]
        ];
    }

    public function index($activo = 1)
    {
        $acceder = $this->accesos->verificapermisos($this->session->id_rol,'ProductosCatalogo') ;
        //$acceder = true ;

        if (!$acceder){
            echo 'No tienes permisos para este modulo' ;
            echo view('header') ;
		    echo view('notienepermiso');
		    echo view('footer') ;
        } else {

        $productos = $this->productos->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Productos', 'datos' => $productos];
        echo view('header');
        echo view('productos/index', $data);
        echo view('footer');
        }
    }

    public function nuevo()
    {


        $unidades = $this->unidades->where('activo', 1)->findAll();
        $categorias = $this->categorias->where('activo', 1)->findAll();

        $data = ['titulo' => 'Agregar Producto', 'unidades' => $unidades, 'categorias' => $categorias];
        echo view('header');
        echo view('productos/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {

        if ($this->request->getMethod() == 'post' && $this->validate($this->reglas)) {

            $this->productos->save([
                'codigo' => $this->request->getPost('codigo'),
                'nombre' => $this->request->getPost('nombre'),
                'id_unidad' => $this->request->getPost('id_unidad'),
                'id_categoria' => $this->request->getPost('id_categoria'),
                'precio_venta' => $this->request->getPost('precio_venta'),
                'precio_compra' => $this->request->getPost('precio_compra'),
                'existencia' => $this->request->getPost('existencia'),
                'stock_min' => $this->request->getPost('stock_min'),
                'controla_stock' => $this->request->getPost('controla_stock')
            ]);

            $id = $this->productos->InsertID();
            /* PARA CARGAR MULTIPLES IMAGENES 
            if ($imagefile = $this->request->getFiles()) {
                $contador = 1 ;
                foreach ($imagefile['img_producto'] as $img) {

                    $ruta = "images/productos/".$id ;
                    if (!file_exists($ruta)){
                        mkdir($ruta,0777,true) ;
                    }

                    if ($img->isValid() && !$img->hasMoved()) {

                        $img->move('./images/productos/'.$id, '/foto_'.$contador.'.jpg');
                        
                        //$newName = $img->getRandomName();
                        //$img->move(WRITEPATH . 'uploads', $newName);
                        
                        $contador ++ ;
                    }
                }
            }
            */  //HASTA AQUI PARA CARGAR MULTIPLES IMAGENES 

                    $validacion = $this->validate([
                        'img_producto' => [
                            'uploaded[img_producto]',
                            'mime_in[img_producto,image/jpg,image/jpeg]',
                            'max_size[img_producto, 4096]'
                        ]
                    ]);

                    if ($validacion) {

                        $ruta_logo = "images/productos/".$id.".jpg";
                        if (file_exists($ruta_logo)) {
                            unlink($ruta_logo);
                        }

                        $img = $this->request->getFile('img_producto');
                        $img->move('./images/productos', $id.'.jpg');
                    } else {
                        echo 'ERROR en validacion de la Imagen';
                        exit;
                    }
                    

            return redirect()->to(base_url() . '/productos');
        } else {

            $unidades = $this->unidades->where('activo', 1)->findAll();
            $categorias = $this->categorias->where('activo', 1)->findAll();

            $data = ['titulo' => 'Agregar Producto', 'unidades' => $unidades, 'categorias' => $categorias, 'validation' => $this->validator];

            echo view('header');
            echo view('productos/nuevo', $data);
            echo view('footer');
        }
    }

    public function editar($id, $valid = null)
    {

        $unidades = $this->unidades->where('activo', 1)->findAll();
        $categorias = $this->categorias->where('activo', 1)->findAll();
        $producto = $this->productos->where('id', $id)->first();
        if ($valid != null) {
            $data = [
                'titulo' => 'Editar Producto', 'dato' => $producto, 'unidades' => $unidades,
                'categorias' => $categorias, 'validation' => $valid
            ];
        } else {
            $data = ['titulo' => 'Editar Producto', 'dato' => $producto, 'unidades' => $unidades, 'categorias' => $categorias];
        }


        echo view('header');
        echo view('productos/editar', $data);
        echo view('footer');
    }

    public function guardar()
    {

        $this->productos->update(
            $this->request->getPost('id'),
            [
                'codigo' => $this->request->getPost('codigo'),
                'nombre' => $this->request->getPost('nombre'),
                'id_unidad' => $this->request->getPost('id_unidad'),
                'id_categoria' => $this->request->getPost('id_categoria'),
                'precio_venta' => $this->request->getPost('precio_venta'),
                'precio_compra' => $this->request->getPost('precio_compra'),
                'existencia' => $this->request->getPost('existencia'),
                'stock_min' => $this->request->getPost('stock_min'),
                'controla_stock' => $this->request->getPost('controla_stock')
            ]
        );
        return redirect()->to(base_url() . '/productos');
    }

    public function eliminar($id)
    {

        $this->productos->update($id, ['activo' => 0]);
        return redirect()->to(base_url() . '/productos');
    }

    public function restaurar($id)
    {

        $this->productos->update($id, ['activo' => 1]);
        return redirect()->to(base_url() . '/productos');
    }

    public function eliminados($activo = 0)
    {

        $productos = $this->productos->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Productos Eliminados', 'datos' => $productos];
        echo view('header');
        echo view('productos/eliminados', $data);
        echo view('footer');
    }

    public function buscarporcodigo($codigo)
    {
        $this->productos->select('*');
        $this->productos->where('codigo', $codigo);
        $this->productos->where('activo', 1);
        $datos = $this->productos->get()->getRow();

        $res['existe'] = false;
        $res['datos'] = '';
        $res['error'] = '';

        if ($datos) {
            $res['datos'] = $datos;
            $res['existe'] = true;
        } else {
            $res['error'] = 'No existe el producto..';
            $res['existe'] = false;
        }

        echo json_encode($res);
    }

    public function autocompletedata()
    {
        $returnData = array();
        $valor = $this->request->getGet('term');
        $productos = $this->productos->like('codigo', $valor)->where('activo', 1)->findAll();
        if (!empty($productos)) {
            foreach ($productos as $row) {
                $data['id'] = $row['id'];
                $data['value'] = $row['codigo'];
                $data['label'] = $row['codigo'] . '-' . $row['nombre'];
                array_push($returnData, $data);
            }
        }

        echo json_encode($returnData);
    }
/// INFORME DE CODIGOS DE BARRAS
    public function generabarras(){

        $pdf = new \FPDF('P','mm','A4');
        $pdf->AddPage() ;
        $pdf->SetMargins(10, 10, 10) ;
        $pdf->SetTitle('Codigos de Barras') ;
        $pdf->SetFont('Arial','',8) ;

        $productos = $this->productos->where('activo',1)->findAll() ;
        foreach($productos as $row) {
        
            $codigo = $row['codigo'] ;
            $nombre = $row['nombre'] ;
        $generabarcode = new \barcode_genera() ;
        $generabarcode->barcode("images/barcode/".$codigo.".png",$codigo,"20","horizontal","code128", true) ;
        
        $pdf->Cell(70,5,$nombre,0,0,'L',0) ;
        $pdf->Ln() ;
        $pdf->Image("images/barcode/".$codigo.".png");
        unlink("images/barcode/".$codigo.".png") ;

        }
        $this->response->setHeader('Content-Type','application/pdf') ; 

        $pdf->Output('codigosbarra.pdf','I') ;
    }

    public function muestracodigosbarra() {

        echo view('header') ;
        echo view('productos/ver_codigosbarra') ;
        echo view('footer') ;

    }

    /// INFORME DE STOCK MINIMO
    public function muestrastockminimo() {

        echo view('header') ;
        echo view('productos/ver_sminimos') ;
        echo view('footer') ;

    }

    public function generastockminimo(){

        $pdf = new \FPDF('P','mm','A4');
        $pdf->AddPage() ;
        $pdf->SetMargins(10, 10, 10) ;
        $pdf->SetTitle('Productos con Stock Minimo') ;
        $pdf->SetFont('Arial','B',10) ;

        $pdf->Image(base_url() . '/images/logosr.png', 10,4, 20) ;

       $pdf->Cell(0,5,'Listado de Productos con stock minimo',0,1,'C');
       $pdf->Ln(15) ;

       $pdf->Cell(20,5,'Codigo',1,0,'C') ;
       $pdf->Cell(90,5,'Descripcion',1,0,'C') ;
       $pdf->Cell(25,5,'Stock',1,0,'C') ;
       $pdf->Cell(25,5,'StockMin',1,0,'C') ;
       $pdf->Cell(25,5,'Costo',1,1,'C') ;

       $pdf->SetFont('Arial','',9) ;
       $where = "stock_min >= existencia AND controla_stock = 1 AND activo = 1" ;
       $productos = $this->productos->where($where)->findAll();

       foreach($productos as $row) {
           $pdf->Cell(20,5,$row['codigo'],1,0,'L') ;
           $pdf->Cell(90,5,$row['nombre'],1,0,'L') ;
           $pdf->Cell(25,5,$row['existencia'],1,0,'L') ;
           $pdf->Cell(25,5,$row['stock_min'],1,0,'L') ;
           $pdf->Cell(25,5,$row['precio_compra'],1,1,'L') ;
       }


        $this->response->setHeader('Content-Type','application/pdf') ; 

        $pdf->Output('productostockminimo.pdf','I') ;
    }

}
