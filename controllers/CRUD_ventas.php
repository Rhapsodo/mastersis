<?php
    
include ('../config/conexion.php');

$accion = $_POST['accion'];

if ($accion == 'Guardar_venta') {
    //Guardado de la cabecera de venta
    date_default_timezone_set("America/Lima");
    $tipocomp = $_POST['codigo'];
    $idserie = $_POST['serie'];

    $queryserie = "SELECT serie FROM serie WHERE id=$idserie";
    $selectserie = mysqli_query($conexion, $queryserie);
    $filaserie = mysqli_fetch_array($selectserie);
    $serie = $filaserie['serie'];

    $numero = $_POST['numero'];
    $numeroIdentidad = $_POST['numeroIdentidad'];
    $idDireccion = $_POST['idDireccion'];
    $fecha = $_POST['fechaVenta'];
    $hora = date('H:i:s');
    $fechaVenta = $fecha . ' ' . $hora;
    $fechaVencimiento = $_POST['fechaVencimiento'];
    $codigoMonedas = $_POST['codigoMonedas'];
    $impuesto = $_POST['impuesto'];
    $estado = $_POST['estado'];
    $idAlmacen = $_POST['idAlmacen'];
    $razonSocial = $_POST['razonSocial'];

    $querytotal = "SELECT sum(round((cantidad*precio*(100-descuentoPorcentaje)/100)-descuentoValor,2)) as total FROM pasarela_venta";
    $selecttotal = mysqli_query($conexion, $querytotal);
    $filatotal = mysqli_fetch_array($selecttotal);
    $total = $filatotal['total'];
    $igv = round($total,2);

    //tener en cuenta los distintos ruc
    $query = "INSERT INTO ventas (
        idemisor,
        tipocomp,
        idserie,
        serie,
        correlativo,
        fecha_emision,
        codmoneda,
        op_gravadas,
        op_exoneradas,
        op_inafectas,
        igv,
        total,
        doccliente,
        estado,
        feestado,
        modalidad,
        fechavencimiento,
        idAlmacen,
        impuesto
    ) VALUES (
        '1',
        '$tipocomp',
        $idserie,
        '$serie',
        $numero,
        '$fechaVenta',
        '$codigoMonedas',
        $igv,
        0,
        0,
        $igv,
        $total,
        '$numeroIdentidad',
        '$estado',
        '0',
        'CONTADO',
        '$fechaVencimiento',
        $idAlmacen,
        '$impuesto'
    )";
    
    $resultado = mysqli_query($conexion, $query);
    if(!$resultado) {
        echo 'Error de Guardado cabecera '.mysqli_errno($conexion).': '.mysqli_error($conexion).'<br>'.$query;
        return false;
    }
    
    // Obtenemos el id de la venta guardada
    $idVentas = mysqli_insert_id($conexion);

    $query = "SELECT * FROM pasarela_venta";
    $select = mysqli_query($conexion, $query);
    $i=0;

    while($fila = mysqli_fetch_array($select)) {
        $i++;
        $idProducto = $fila['idProducto'];
        $nombre = $fila['nombre'];
        $cantidad = $fila['cantidad'];
        $precio = $fila['precio'];
        $valorunitario = round(($precio/1.18),2);
        $igv = $precio - $valorunitario;
        $descuentoPorcentaje = $fila['descuentoPorcentaje'];
        $descuentoValor = $fila['descuentoValor'];
        $importe_total = round(($cantidad*$precio*(100-$descuentoPorcentaje)/100)-$descuentoValor, 2);
        $valor_total = round($importe_total/1.18, 2);
        $lote = $fila['lote'];
        $vencimiento = $fila['vencimiento'];

        // Guardado del detalle de la venta
        $query = "INSERT INTO venta_detalle (
            idventa,
            item,
            idProducto,
            cantidad,
            valor_unitario,
            precio_unitario,
            igv,
            porcentaje_igv,
            valor_total,
            importe_total,
            descripcion,
            estado,
            tipo_precio,
            codigoafectacion,
            descuento_porcentaje,
            descuento_valor
        ) VALUES (
            $idVentas,
            $i,
            $idProducto,
            $cantidad,
            $valorunitario,
            $precio,
            $igv,
            18,
            $valor_total,
            $importe_total,
            '$nombre',
            'ACTIVO',
            '01',
            '10',
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
            $idAlmacen, 3,
            '$serie-$numero',
            'VENTA',
            '$fechaVenta',
            $idProducto,
            '$lote',
            '$vencimiento',
            '$codigoMonedas',
            ($cantidad*-1),
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

    $sql = "UPDATE serie set correlativo = $numero+1 where id=$idserie";
    $resultado = mysqli_query($conexion, $sql);
    //MODO DE IMPRESION INICIO
    //echo "<script>window.open('./pdf_ticket.php?id=".$idVentas."','_blank')</script>";	
    //MODO DE IMPRESION FIN
    echo $idVentas;
}