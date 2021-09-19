<?php

//librerias de PDF Y QR
define('FPDF_FONTPATH', 'font/');
require_once('fpdf/fpdf.php');
require_once('phpqrcode/qrlib.php');
require_once('cantidad_en_letras.php');

//otras librerias
include ('config/conexion.php');

$id = $_GET['id'];

$query = "SELECT * FROM ventas WHERE id = $id";
$select = mysqli_query($conexion, $query);
$venta = mysqli_fetch_array($select);

$idemisor = $venta['idemisor'];
$query = "SELECT * FROM emisor WHERE id = $idemisor";
$select = mysqli_query($conexion, $query);
$emisor = mysqli_fetch_array($select);

$codubigeo = $emisor['ubigeo'];
$query = "SELECT * FROM ubigeo WHERE codigoUbigeo = $codubigeo";
$select = mysqli_query($conexion, $query);
$ubigeo = mysqli_fetch_array($select);

$query = "SELECT count(*) AS numrows FROM venta_detalle WHERE idventa = $id";
$select = mysqli_query($conexion, $query);
$relacion = mysqli_fetch_array($select);

$numrows = $relacion['numrows'];
$largo = (32 + $numrows * 2) * 1.7;

$pdf = new FPDF($orientation='P',$unit='mm', array(45, $largo));
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);    //Letra Arial, negrita (Bold), tam. 20

$pdf->Image('logo_empresa.jpg', 1, 2.5, 9, 9);

$pdf->SetFont('Arial', 'B', 5);
$pdf->setY(1);
$pdf->setX(10);
$pdf->Cell(5,5, $emisor['nombre_comercial'] . ' - ' . $emisor['ruc']);
$pdf->setY(3);
$pdf->setX(10);
$pdf->Cell(5, 5, $emisor['razon_social']);

$pdf->SetFont('Arial', '', 4.5);
$pdf->setY(5);
$pdf->setX(10);
$pdf->Cell(5, 5, $emisor['direccion']);
$pdf->setY(7);
$pdf->setX(10);
$pdf->Cell(5, 4, $ubigeo['distrito'].'-'.$ubigeo['provincia'].'-'.$ubigeo['departamento']);

$pdf->SetFont('Arial', '', 4);
$pdf->setY(9);
$pdf->setX(10);
$pdf->Cell(5, 4, 'TELF: 983597623 / 959365406');


$pdf->SetFont('Arial','B',5);    //Letra Arial, negrita (Bold), tam. 20
$pdf->setY(12);
$pdf->setX(2);
$pdf->Cell(5,4,'NOTA DE PEDIDO: '.$venta['serie'].'-'.$venta['correlativo']);

$pdf->SetFont('Arial','',4.5);    //Letra Arial, negrita (Bold), tam. 20
$pdf->setY(14);
$pdf->setX(2);
$pdf->Cell(5,4,'FECHA: '.$venta['fecha_emision']);

$pdf->SetFont('Arial','B',4.5);    //Letra Arial, negrita (Bold), tam. 20
$pdf->setY(17);
$pdf->setX(2);
$pdf->Cell(5,4,utf8_decode('CANT.           ARTÍCULO                 PRECIO     TOTAL'));

$posY = 17;
$pdf->SetFont('Arial', '', 4);

$query = "SELECT d.*, p.jerarquia FROM venta_detalle d, productos p WHERE d.idproducto = p.idProducto AND idventa = $id ORDER BY jerarquia";
$select = mysqli_query($conexion, $query);
while ($fila = mysqli_fetch_array($select)) {

    $pdf->setY($posY+=2);
    $pdf->setX(3);
    $pdf->Cell(5, 4, $fila['cantidad'], 0, 0, 'R', 0);
    
    $pdf->setY($posY);
    $pdf->setX(7);
    $pdf->Cell(5, 4, utf8_decode(substr($fila['descripcion'], 0, 23)), 0, 0, 'L', 0);
    
    $pdf->setY($posY);
    $pdf->setX(30);
    $pdf->Cell(5, 4, number_format($fila['importe_total']/$fila['cantidad'], 2), 0, 0, 'R', 0);
    
    $pdf->setY($posY);
    $pdf->setX(38);
    $pdf->Cell(5, 4, $fila['importe_total'],0, 0, 'R', 0);
}

$pdf->SetFont('Arial','B',4.5);    //Letra Arial, negrita (Bold), tam. 20
$pdf->setY($posY+=3);
$pdf->setX(27);
$pdf->Cell(5,2,'TOTAL:');
$pdf->setX(38);
$pdf->Cell(5,2,$venta['total'],0, 0, 'R', 0);

$pdf->SetFont('Arial', '', 3.5);
$pdf->setY($posY+=3);
$pdf->setX(2);
$letras = numtoletras($venta['total'], 'SOLES');
$pdf->MultiCell(40, 1.2, utf8_decode('SON: ' . $letras));
// $pdf->MultiCell(40, 1.2, utf8_decode('SON: NOVECIENTOS NOVENTA Y NUEVE MIL DOSCIENTOS TREINTA Y OCHO CON 45/100 SOLES' ));

$pdf->SetFont('Arial', 'B', 3.5);
$pdf->setY($posY+=3);
$pdf->setX(2);
$pdf->Cell(1,1,'GRACIAS POR TU COMPRA');

$pdf->setY($posY+=2);
$pdf->setX(2);
$pdf->SetFont('Arial', '', 3);
$pdf->Cell(1,1,'Software: www.paraderoweb.com');

$pdf->output();


?>