<?php
    
include ('../config/conexion.php');

$accion = $_POST['accion'];

if ($accion == 'Guardar_compra') {
    //Guardado de la cabecera de compra
    date_default_timezone_set("America/Lima");
    $codigo = $_POST['codigo'];
    $serieNumero = $_POST['serieNumero'];
    $numeroIdentidad = $_POST['numeroIdentidad'];
    $idDireccion = $_POST['idDireccion'];
    $fechaCompra = $_POST['fechaCompra'];
    $fechaVencimiento = $_POST['fechaVencimiento'];
    $codigoMonedas = $_POST['codigoMonedas'];
    $impuesto = $_POST['impuesto'];
    $estado = $_POST['estado'];
    $idAlmacen = $_POST['idAlmacen'];
    $razonSocial = $_POST['razonSocial'];

    $query = "INSERT INTO compras (
        codigo,
        serieNumero,
        numeroIdentidad,
        idDireccion,
        fechaCompra,
        fechaVencimiento,
        codigoMonedas,
        impuesto,
        estado
    ) VALUES (
        '$codigo',
        '$serieNumero',
        '$numeroIdentidad',
        $idDireccion,
        '$fechaCompra',
        '$fechaVencimiento',
        '$codigoMonedas',
        '$impuesto',
        '$estado'
    )";
    $resultado = mysqli_query($conexion, $query);
    if(!$resultado) {
        echo 'Error de Guardado cabecera '.mysqli_errno($conexion).': '.mysqli_error($conexion).'<br>'.$query;
        return false;
    }
    
    // Obtenemos el id de la compra guardada
    $idCompras = mysqli_insert_id($conexion);

    $query = "SELECT * FROM pasarela_compra";
    $select = mysqli_query($conexion, $query);
    while($fila = mysqli_fetch_array($select)) {
        $idProducto = $fila['idProducto'];
        $nombre = $fila['nombre'];
        $cantidad = $fila['cantidad'];
        $precio = $fila['precio'];
        $descuentoPorcentaje = $fila['descuentoPorcentaje'];
        $descuentoValor = $fila['descuentoValor'];
        $lote = $fila['lote'];
        $vencimiento = $fila['vencimiento'];

        // Guardado del detalle de la compra
        $query = "INSERT INTO compra_detalle (
            idCompras,
            idProducto,
            nombre,
            lote,
            vencimiento,
            codigoMonedas,
            cantidad,
            precio,
            descuentoPorcentaje,
            descuentoValor
        ) VALUES (
            $idCompras,
            $idProducto,
            '$nombre',
            '$lote',
            '$vencimiento',
            '$codigoMonedas',
            $cantidad,
            $precio,
            $descuentoPorcentaje,
            $descuentoValor
        )";
        $resultado = mysqli_query($conexion, $query);
        if(!$resultado) {
            echo 'Error de Guardado detalle '.mysqli_errno($conexion).': '.mysqli_error($conexion).'<br>'.$query;
            return false;
        }

        // Guardado de movimientos de almacén
        $query = "INSERT INTO almacen_movimientos (
            idAlmacen,
            idAlmacenTransacciones,
            numeroTransaccion,
            documentoReferencia,
            fecha,
            idProducto,
            lote,
            vencimiento,
            codigoMonedas,
            cantidad,
            precio,
            idUsuario,
            observacion
        ) VALUES (
            $idAlmacen, 2,
            '$serieNumero',
            'COMPRA',
            '$fechaCompra',
            $idProducto,
            '$lote',
            '$vencimiento',
            '$codigoMonedas',
            $cantidad,
            $precio,
            1,
            '$razonSocial'
        )";
        $resultado = mysqli_query($conexion, $query);
        if(!$resultado) {
            echo 'Error de Guardado almacén '.mysqli_errno($conexion).': '.mysqli_error($conexion).'<br>'.$query;
            return false;
        }

    }

    echo 'Se guardó la compra correctamente';
}