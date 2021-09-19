<?php
session_start();
include ('../config/conexion.php');

$proceso = $_POST['proceso'];

if ($proceso == 'guardar_producto') {
    $code_AECOC = $_POST['hide_code_aecoc'];
    $idAfectacionIGV = $_POST['comb_afectacion_igv'];
    $idUnidad = $_POST['comb_unidad'];
    $codigoBarra = strtoupper($_POST['txt_codigo_barra']);
    $codigoInterno = strtoupper($_POST['txt_interno']);
    $nombre1 = strtoupper($_POST['txt_nombre1']);
    $nombre2 = strtoupper($_POST['txt_nombre2']);
    $nombre3 = strtoupper($_POST['txt_nombre3']);
    $descripcion = $_POST['area_descripcion'];
    $marca = strtoupper($_POST['txt_marca']);
    $modelo = strtoupper($_POST['txt_modelo']);
    $stockMinimo = $_POST['txt_stock_minimo'];
    $stockMaximo = $_POST['txt_stock_maximo'];
    $estado = 'ACTIVO';
    if (isset($_POST['check_ventas'])) {
        $paraVenta = 'SI';
    } else {
        $paraVenta = 'NO';
    }
    if (isset($_POST['check_almacen'])) {
        $paraAlmacen = 'SI';
    } else {
        $paraAlmacen = 'NO';
    }
    $pesoNeto = $_POST['txt_peso_neto'];
    $pesoBruto = $_POST['txt_peso_bruto'];
    $jerarquia = 1;
    $registroSanitario = strtoupper($_POST['txt_registro_sanitario']);
    date_default_timezone_set("America/Lima");
    $fechaAlta = date('Y-m-d H:i:s');

    $query = "INSERT INTO productos (
        code_AECOC, 
        idAfectacionIGV,
        idUnidad,
        codigoBarra,
        codigoInterno,
        nombre1,
        nombre2,
        nombre3,
        descripcion,
        marca,
        modelo,
        stockMinimo,
        stockMaximo,
        estado,
        paraVenta,
        paraAlmacen,
        pesoNeto,
        pesoBruto,
        jerarquia,
        registroSanitario,
        fechaAlta
    ) VALUES (
        '$code_AECOC', 
        '$idAfectacionIGV',
        $idUnidad,
        '$codigoBarra',
        '$codigoInterno',
        '$nombre1',
        '$nombre2',
        '$nombre3',
        '$descripcion',
        '$marca',
        '$modelo',
        $stockMinimo,
        $stockMaximo,
        '$estado',
        '$paraVenta',
        '$paraAlmacen',
        $pesoNeto,
        $pesoBruto,
        $jerarquia,
        '$registroSanitario',
        '$fechaAlta'
    )";
    
    //echo $query;
    
    $insert = mysqli_query($conexion, $query);
    if (!$insert) {
        echo $query;
        die('Inserción no valida: '.mysql_error());
    } else {
        $_SESSION['ultimo_producto'] = $nombre1;
        $_SESSION['mensaje'] = 'Producto guardado correctamente: ';
        
        header("location: ../productos_ingreso.php");
    }
}
?>