<?php
include ('../config/conexion.php');

$proceso = $_POST['proceso'];

if ($proceso == 'actualizar_producto') {
    $idProducto = $_POST['hide_idproducto'];
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
    $estado = 'MODIFICADO';
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
    $fechaModificado = date('Y-m-d H:i:s');

    $query = "UPDATE productos SET 
    code_AECOC = '$code_AECOC',
    idAfectacionIGV = '$idAfectacionIGV',
    idUnidad = $idUnidad,
    codigoBarra = '$codigoBarra',
    codigoInterno = '$codigoInterno',
    nombre1 = '$nombre1',
    nombre2 = '$nombre2',
    nombre3 = '$nombre3',
    descripcion = '$descripcion',
    marca = '$marca',
    modelo = '$modelo',
    stockMinimo = $stockMinimo,
    stockMaximo = $stockMaximo,
    estado = '$estado',
    paraVenta = '$paraVenta',
    paraAlmacen = '$paraAlmacen',
    pesoNeto = $pesoNeto,
    pesoBruto = $pesoBruto,
    registroSanitario = '$registroSanitario',
    fechaModificado = '$fechaModificado'
    WHERE idProducto = $idProducto";

    //echo $query;
    $update = mysqli_query($conexion, $query);
    if (!$update) {
        echo $query;
        die('Inserción no valida: '.mysql_error());
    } else {
        header("location: ../productos.php");
    }
}
?>