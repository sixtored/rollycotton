<?php

namespace App\Controllers;
use App\Controllers\BaseController ;
use App\Models\VentasModel ;
use App\Models\TemporalCompraModel ;
use App\Models\DetalleVentaModel ;
use App\Models\ProductosModel ;
use App\Models\ConfiguracionModel ;
use App\Models\ClientesModel ;
use App\Models\CajasModel ;

class Ventas extends BaseController {

    protected $ventas, $temporal_ventas, $detalle_venta, $productos, $configuracion, $cliente, $cajas, $session ;

    public function __construct()
    {
        $this->ventas = new VentasModel() ;
        $this->detalle_venta = new DetalleVentaModel() ;
        $this->configuracion = new ConfiguracionModel() ;
        $this->cliente = new ClientesModel() ;
        $this->cajas = new CajasModel() ;
        $this->session = session() ;
        helper(['form']) ;
    }

    public function index($activo = 1) {

        if(!isset($this->session->id_usuario)) {
			return redirect()->to(base_url()) ;
		}

        $datos = $this->ventas->obtener($activo) ;
        $data = ['titulo' => 'Ventas', 'datos' => $datos] ;

        echo view('header') ;
        echo view('ventas/index',$data) ;
        echo view('footer') ;
    }

    public function eliminados($activo = 0) {

        if(!isset($this->session->id_usuario)) {
			return redirect()->to(base_url()) ;
		}

        $datos = $this->ventas->obtener($activo) ;
        $data = ['titulo' => 'Ventas eliminadas', 'datos' => $datos] ;

        echo view('header') ;
        echo view('ventas/eliminados',$data) ;
        echo view('footer') ;
    }

    public function nueva() {

        if(!isset($this->session->id_usuario)) {
			return redirect()->to(base_url()) ;
		}

        echo view('header') ;
        echo view('ventas/nueva') ;
        echo view('footer') ;
    }

    public function guarda(){

        $id_venta = $this->request->getPost('id_venta') ;
        $total = preg_replace('/[\$,]/', '', $this->request->getPost('total')) ;
        $id_cliente = $this->request->getPost('id_cliente') ;
        $forma_pago = $this->request->getPost('forma_pago') ;
        $session = session() ;
        $id_usuario = $session->id_usuario ;
        $id_caja = $session->id_caja ;
        $caja = $this->cajas->where('id',$id_caja)->first() ;
        $folio = $caja['folio'] ;
        $folio = $folio + 1 ;

        $resultado = $this->ventas->insertarventas($folio, $total, $id_usuario, $id_caja, $id_cliente, $forma_pago ) ;

        if ($resultado){
            $this->temporal_compras = new TemporalCompraModel() ;
            $datos = $this->temporal_compras->porCompra($id_venta) ;
            foreach($datos as $row) {

                $this->detalle_venta->save([
                    'id_ventas' =>$resultado,
                    'id_producto' =>$row['id_producto'],
                    'codigo' =>$row['codigo'],
                    'nombre' =>$row['nombre'],
                    'cantidad'=>$row['cantidad'],
                    'precio' =>$row['precio'],
                    'subtotal'=>$row['subtotal'],
                ]) ;

                $this->productos = new ProductosModel() ;
                $this->productos->restastock($row['id_producto'], $row['cantidad']) ;
                // actulizo el consecutivo del folio de caja
                $this->cajas->update($id_caja, ['folio' => $folio]) ;
            }
            $this->temporal_compras->eliminarcompra($id_venta) ;
        }

         return redirect()->to(base_url().'/ventas/muestratiquet/'.$resultado) ;
        
    }

    public function muestratiquet($id_venta) {

        $data['id_venta'] = $id_venta ;
        echo view('header') ;
        echo view('ventas/ver_tiquet',$data) ;
        echo view('footer') ;

    }


    public function generatiquet($id_venta){

        $datosventa = $this->ventas->where('id',$id_venta)->first() ;
        $datoscliente = $this->cliente->where('id',$datosventa['id_cliente'])->first();
        $detalleventa = $this->detalle_venta->select('*')->where('id_ventas', $id_venta)->findAll() ;
        $tiendanombre = $this->configuracion->select('valor')->where('nombre','tienda_nombre')->get()->getRow()->valor ;
        $tiendadomicilio = $this->configuracion->select('valor')->where('nombre','tienda_domicilio')->get()->getRow()->valor ;
        $tiendatelefono = $this->configuracion->select('valor')->where('nombre','tienda_telefono')->get()->getRow()->valor ;
        $tiendaemail = $this->configuracion->select('valor')->where('nombre','tienda_email')->get()->getRow()->valor ;
        $tiquetleyenda = $this->configuracion->select('valor')->where('nombre','tiquet_leyenda')->get()->getRow()->valor ;

        $pdf = new \FPDF('P','mm', array(80,270));
        $pdf->AddPage() ;
        $pdf->SetMargins(5, 5, 5) ;
        $pdf->SetTitle('Venta') ;
        $pdf->SetFont('Arial','B',11) ;
        /*
        $pdf->Cell(50, 5,'Venta de Productos',0,1,'L') ;
        */
        $pdf->SetFont('Arial','B',9) ;

        
        $pdf->Image(base_url() . '/images/logosr.png', 65,4, 8, 15, 'PNG') ;
        
        $pdf->Cell(50, 2,$tiendanombre,0,1,'L') ;
        $pdf->SetFont('Arial','',9) ;
        $pdf->Cell(50, 4,$tiendadomicilio,0,1,'L') ;
        $pdf->SetFont('Arial','',9) ;
        $pdf->Cell(50, 4,$tiendaemail,0,1,'L') ;

        $pdf->SetFont('Arial','B',9) ;
        $pdf->Cell(25, 4,utf8_decode('Cliente :'),0,0,'L') ;
        $pdf->SetFont('Arial','',9) ;
        $pdf->Cell(50, 4,$datoscliente['nombre'],0,1,'L') ;

        $pdf->SetFont('Arial','B',9) ;
        $pdf->Cell(25, 4,utf8_decode('Fecha y Hora :'),0,0,'L') ;
        $pdf->SetFont('Arial','',9) ;
        $pdf->Cell(50, 4,$datosventa['created_at'],0,1,'L') ;

        $pdf->SetFont('Arial','B',9) ;
        $pdf->Cell(25, 4,utf8_decode('Factura :'),0,0,'L') ;
        $pdf->SetFont('Arial','',9) ;
        $pdf->Cell(50, 4,$datosventa['folio'],0,1,'L') ;

        $pdf->Ln() ;

       
        $pdf->Cell(8,5,'Cant',1,0,'L',0) ;
        $pdf->Cell(35,5,'Descrip',1,0,'L',0) ;
        $pdf->Cell(15,5,'Precio',1,0,'L',0) ;
        $pdf->Cell(15,5,'Importe',1,1,'L',0) ;

        $pdf->SetFont('Arial','',8) ;
        $ii = 1 ;
        foreach($detalleventa as $row) {
            $pdf->Cell(15,5,$row['cantidad'].' x ',0,0,'L',0) ;
            $pdf->Cell(35,5,$row['precio'],0,1,'L',0) ;
            $pdf->Cell(35,3,$row['nombre'],0,0,'L',0) ;
            $pdf->Cell(35,3,'$ '.$row['subtotal'],0,1,'R',0) ;
            $ii ++ ;
        }

        $pdf->Ln() ;

        $pdf->SetFont('Arial','B',9) ;
        $pdf->Cell(25,5,'Total ',0,0,'L',0) ;
        $pdf->Cell(45,5,'$ '.$datosventa['total'],0,1,'R',0) ;

        $pdf->Ln() ;

        $pdf->SetFont('Arial','',9) ;
        $pdf->MultiCell(70, 4,$tiquetleyenda,0,'C',0) ;

        


       $this->response->setHeader('Content-Type','application/pdf') ; 

        $pdf->Output('ventas.pdf','I') ;

    }


    public function eliminar($id){

        $productos = $this->detalle_venta->where('id_ventas',$id)->findAll() ;

        foreach($productos as $row) {
            $this->productos = new ProductosModel() ;
            $this->productos->agregastock($row['id_producto'], $row['cantidad']) ;
        }

        $this->ventas->update($id, ['activo' => 0]) ;
        $this->detalle_venta->whereIn('id_ventas', [$id])->set(['activo' => 0 ])->update();
        return redirect()->to(base_url().'/ventas') ;
    }

}