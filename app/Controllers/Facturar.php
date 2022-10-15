<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VentasModel;
use App\Models\DetalleVentaModel;
use App\Models\ConfiguracionModel;
use App\Models\ClientesModel;

class Facturar extends BaseController
{

    protected $ventas, $cliente, $detalle_venta, $configuracion;

    public function __construct()
    {
        $this->ventas = new VentasModel();
        $this->cliente = new ClientesModel();
        $this->detalle_venta = new DetalleVentaModel();
        $this->configuracion = new ConfiguracionModel();
        helper(['form']);
    }

    public function facturar($id_venta = 1)
    {

        $datosventa = $this->ventas->where('id', $id_venta)->first();
        $datoscliente = $this->cliente->where('id', $datosventa['id_cliente'])->first();
        $detalleventa = $this->detalle_venta->select('*')->where('id_ventas', $id_venta)->findAll();
        $tiendanombre = $this->configuracion->select('valor')->where('nombre', 'tienda_nombre')->get()->getRow()->valor;
        $tiendadomicilio = $this->configuracion->select('valor')->where('nombre', 'tienda_domicilio')->get()->getRow()->valor;
        $tiendatelefono = $this->configuracion->select('valor')->where('nombre', 'tienda_telefono')->get()->getRow()->valor;
        $tiendaemail = $this->configuracion->select('valor')->where('nombre', 'tienda_email')->get()->getRow()->valor;
        $tiquetleyenda = $this->configuracion->select('valor')->where('nombre', 'tiquet_leyenda')->get()->getRow()->valor;
        $tiendarfc = $this->configuracion->select('valor')->where('nombre', 'tienda_rfc')->get()->getRow()->valor;


        date_default_timezone_set('America/Mexico_City');

        $datosFactura = array();

        $dirCfdi = APPPATH . 'Libraries/cfdi_sat/cfdi/';
        $dir = APPPATH . 'Libraries/cfdi_sat/';

        $nombre = "A1";

        //Datos generales de factura
        $datosFactura["version"] = "3.3";
        $datosFactura["serie"] = "A";
        $datosFactura["folio"] = "1";
        $datosFactura["fecha"] = date('YmdHis');
        $datosFactura["formaPago"] = "01";
        $datosFactura["noCertificado"] = "20001000000300022762";
        $datosFactura["subTotal"] = $datosventa['total'];
        $datosFactura["descuento"] = "0.00";
        $datosFactura["moneda"] = "MXN";
        $datosFactura["total"] = $datosventa['total'];
        $datosFactura["tipoDeComprobante"] = "I";
        $datosFactura["metodoPago"] = "PUE";
        $datosFactura["lugarExpedicion"] = "01000";

        //Datos del emisor
        $datosFactura['emisor']['rfc'] = $tiendarfc;
        $datosFactura['emisor']['nombre'] = $tiendanombre;
        $datosFactura['emisor']['regimen'] = '601';

        //Datos del receptor
        $datosFactura['receptor']['rfc'] = 'XAXX010101000';
        $datosFactura['receptor']['nombre'] = 'Publico en general';
        $datosFactura['receptor']['usocfdi'] = 'P01';

        foreach ($detalleventa as $row) {

            $datosFactura["conceptos"][] = array("clave" => "01010101", "sku" => $row['codigo'], "descripcion" => $row['nombre'], "cantidad" => $row['cantidad'], "claveUnidad" => "H87", "unidad" => "Pieza", "precio" => $row['precio'], "importe" => $row['subtotal'], "descuento" => "0.00", "iBase" => $row['subtotal'], "iImpuesto" => "000", "iTipoFactor" => "Tasa", "iTasaOCuota" => "0.0000", "iImporte" => "0.00");
        }

        $datosFactura['traslados']['impuesto'] = "000";
        $datosFactura['traslados']['tasa'] = "0.0000";
        $datosFactura['traslados']['importe'] = "0.00";

        $xml = new \GeneraXML();
        $xmlBase = $xml->satxmlsv33($datosFactura, '', $dir, '');

        $timbra = new \Pac();
        $cfdi = $timbra->enviar("UsuarioPruebasWS", "b9ec2afa3361a59af4b4d102d3f704eabdf097d4", $tiendarfc, $xmlBase);

        if ($xml) {
            file_put_contents($dirCfdi . $nombre . '.xml', base64_decode($cfdi->xml));

            unlink($dir . '/tmp/' . $nombre . '.xml');
        }
    }

    public function generaPdfFac($folio)
    {
        $dirCfdi = APPPATH . 'Libraries/cfdi_sat/cfdi/';
        $xml = simplexml_load_file($dirCfdi.$folio . '.xml');
        $ns = $xml->getNamespaces(true);
        $xml->registerXPathNamespace('c', $ns['cfdi']);
        $xml->registerXPathNamespace('t', $ns['tfd']);

        foreach ($xml->xpath('//cfdi:Comprobante') as $cfdicomprobante) {
            echo $cfdicomprobante['Version'].'<br>';
            echo $cfdicomprobante['Total']. '<br>';
        }

        foreach ($xml->xpath('//cfdi:Emisor') as $cfdiemisor) {
            echo $cfdiemisor['Rfc'].'<br>';
            echo $cfdiemisor['Nombre']. '<br>';
        }

        foreach ($xml->xpath('//cfdi:Receptor') as $cfdreceptor) {
            echo $cfdreceptor['Rfc'].'<br>';
            echo $cfdreceptor['Nombre']. '<br>';
        }

        foreach ($xml->xpath('//cfdi:Conceptos//cfdi:Concepto') as $cfdconcepto) {
            echo $cfdconcepto['NoIdentificacion'].'<br>';
            echo $cfdconcepto['Cantidad']. '<br>';
            echo $cfdconcepto['Descripcion']. '<br>';
            echo $cfdconcepto['ValorUnitario']. '<br>';
            echo $cfdconcepto['Importe']. '<br>';
        }

        foreach ($xml->xpath('//cfdi:Conceptos//cfdi:Concepto//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $cfdtraslado) {
            echo $cfdtraslado['Base'].'<br>';
            echo $cfdtraslado['Impuesto']. '<br>';
            echo $cfdtraslado['TipoFactor']. '<br>';
            echo $cfdtraslado['TasaOCuota']. '<br>';
            echo $cfdtraslado['Importe']. '<br>';
        }
    }
}
