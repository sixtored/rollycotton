<?php

namespace App\Controllers;
use App\Controllers\BaseController ;
use App\Models\ComprasModel;
use App\Models\TemporalCompraModel ;
use App\Models\DetalleCompraModel ;
use App\Models\ProductosModel ;
use App\Models\ConfiguracionModel ;
use CodeIgniter\HTTP\Response;
use CodeIgniter\Validation\Validation;

class Compras extends BaseController {

    protected $compras, $temporal_compras, $detalle_compra, $productos, $configuracion ;

    public function __construct()
    {
        $this->compras = new ComprasModel() ;
        $this->detalle_compra = new DetalleCompraModel() ;
        $this->configuracion = new ConfiguracionModel() ;
        helper(['form']) ;
    }

    public function index($activo = 1) {

        $compras = $this->compras->where('activo',$activo)->findAll() ;
        $data = ['titulo' => 'Compras', 'datos' => $compras] ;

        echo view('header') ;
        echo view('compras/index',$data) ;
        echo view('footer') ;
    }

    public function nuevo() {

        echo view('header') ;
        echo view('compras/nuevo') ;
        echo view('footer') ;
    }

    public function guarda(){

        $id_compra = $this->request->getPost('id_compra') ;
        $total = preg_replace('/[\$,]/', '', $this->request->getPost('total')) ;
        $session = session() ;
        $id_usuario = $session->id_usuario ;

        $resultado = $this->compras->insertarcompras($id_compra, $total, $id_usuario) ;

        if ($resultado){
            $this->temporal_compras = new TemporalCompraModel() ;
            $datos = $this->temporal_compras->porCompra($id_compra) ;
            foreach($datos as $row) {

                $this->detalle_compra->save([
                    'id_compra' =>$resultado,
                    'id_producto' =>$row['id_producto'],
                    'codigo' =>$row['codigo'],
                    'nombre' =>$row['nombre'],
                    'cantidad'=>$row['cantidad'],
                    'precio' =>$row['precio'],
                    'subtotal'=>$row['subtotal'],
                ]) ;

                $this->productos = new ProductosModel() ;
                $this->productos->agregastock($row['id_producto'], $row['cantidad']) ;
            }
            $this->temporal_compras->eliminarcompra($id_compra) ;
        }

        return redirect()->to(base_url().'/compras/muestracompraPdf/'.$resultado) ;
        
    }

    public function muestracompraPdf($id_compra) {

        $data['id_compra'] = $id_compra ;
        echo view('header') ;
        echo view('compras/ver_compra_pdf',$data) ;
        echo view('footer') ;

    }

    public function generacomprapdf($id_compra){

        $datoscompra = $this->compras->where('id',$id_compra)->first() ;
        $detallecompra = $this->detalle_compra->select('*')->where('id_compra', $id_compra)->findAll() ;
        $tiendanombre = $this->configuracion->select('valor')->where('nombre','tienda_nombre')->get()->getRow()->valor ;
        $tiendadomicilio = $this->configuracion->select('valor')->where('nombre','tienda_domicilio')->get()->getRow()->valor ;
        $tiendatelefono = $this->configuracion->select('valor')->where('nombre','tienda_telefono')->get()->getRow()->valor ;
        $tiendaemail = $this->configuracion->select('valor')->where('nombre','tienda_email')->get()->getRow()->valor ;
        $tiquetleyenda = $this->configuracion->select('valor')->where('nombre','tiquet_leyenda')->get()->getRow()->valor ;

        $pdf = new \FPDF('P','mm','A4');
        $pdf->AddPage() ;
        $pdf->SetMargins(10, 10, 10) ;
        $pdf->SetTitle('Compra') ;
        $pdf->SetFont('Arial','B',11) ;

        $pdf->Cell(195, 5,'Entrada de Productos',0,1,'C') ;
        $pdf->SetFont('Arial','B',9) ;
        $pdf->Image(base_url() . '/images/logosr.png', 170,6, 25, 30, 'PNG') ;
        $pdf->Cell(50, 5,$tiendanombre,0,1,'L') ;
        $pdf->Cell(25, 5,utf8_decode('Direccion :'),0,0,'L') ;
        $pdf->SetFont('Arial','',9) ;
        $pdf->Cell(50, 5,$tiendadomicilio,0,1,'L') ;
        $pdf->SetFont('Arial','B',9) ;
        $pdf->Cell(25, 5,utf8_decode('Telefono :'),0,0,'L') ;
        $pdf->SetFont('Arial','',9) ;
        $pdf->Cell(50, 5,$tiendatelefono,0,1,'L') ;
        $pdf->SetFont('Arial','B',9) ;
        $pdf->Cell(25, 5,utf8_decode('Email :'),0,0,'L') ;
        $pdf->SetFont('Arial','',9) ;
        $pdf->Cell(50, 5,$tiendaemail,0,1,'L') ;

        $pdf->SetFont('Arial','B',9) ;
        $pdf->Cell(25, 5,utf8_decode('Fecha y Hora :'),0,0,'L') ;
        $pdf->SetFont('Arial','',9) ;
        $pdf->Cell(50, 5,$datoscompra['created_at'],0,1,'L') ;

        $pdf->Ln() ;

        $pdf->SetFont('Arial','B',8) ;
        $pdf->SetFillColor(128, 135, 130) ;
        $pdf->SetTextColor(255,255,255) ;

        $pdf->Cell(196,5,'Detalle de Productos',1,1,'C',1) ;

        $pdf->SetTextColor(0,0,0) ;

        $pdf->Cell(14,5,'No',1,0,'L',0) ;
        $pdf->Cell(25,5,'Codigo',1,0,'L',0) ;
        $pdf->Cell(77,5,'Nombre',1,0,'L',0) ;
        $pdf->Cell(25,5,'Cantidad',1,0,'L',0) ;
        $pdf->Cell(25,5,'Precio',1,0,'L',0) ;
        $pdf->Cell(30,5,'Importe',1,1,'L',0) ;

        $pdf->SetFont('Arial','',8) ;
        $ii = 1 ;
        foreach($detallecompra as $row) {
            $pdf->Cell(14,5,$ii,1,0,'L',0) ;
            $pdf->Cell(25,5,$row['codigo'],1,0,'L',0) ;
            $pdf->Cell(77,5,$row['nombre'],1,0,'L',0) ;
            $pdf->Cell(25,5,$row['cantidad'],1,0,'R',0) ;
            $pdf->Cell(25,5,$row['precio'],1,0,'R',0) ;
            $pdf->Cell(30,5,'$ '.$row['subtotal'],1,1,'R',0) ;
            $ii ++ ;
        }

        $pdf->Ln() ;

        $pdf->SetFont('Arial','B',8) ;
        $pdf->Cell(14,5,'',0,0,'L',0) ;
        $pdf->Cell(25,5,'',0,0,'L',0) ;
        $pdf->Cell(77,5,'',0,0,'L',0) ;
        $pdf->Cell(25,5,'',0,0,'R',0) ;
        $pdf->Cell(25,5,'Total ',0,0,'R',0) ;
        $pdf->Cell(30,5,'$ '.$datoscompra['total'],1,1,'R',0) ;
        


       $this->response->setHeader('Content-Type','application/pdf') ; 

        $pdf->Output('comprapdf.pdf','I') ;


    }

   
    public function eliminar($id){

        $this->compras->update($id, ['activo'=> 0]);
        return redirect()->to(base_url() .'/compras') ;
    }

    public function restaurar($id)
    {

        $this->compras->update($id, ['activo' => 1]);
        return redirect()->to(base_url() . '/compras');
    }

    public function eliminados($activo = 0) {

        $compras = $this->compras->where('activo',$activo)->findAll() ;
        $data = ['titulo' => 'Compras', 'datos' => $compras] ;

        echo view('header') ;
        echo view('compras/eliminados',$data) ;
        echo view('footer') ;
    }

}