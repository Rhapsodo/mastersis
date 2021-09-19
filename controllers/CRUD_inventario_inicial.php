<?php 
include ('../config/conexion.php');

    if($_POST['proceso'] == 'Guardar') {
        $idAlmacen = $_POST['idAlmacen'];
        date_default_timezone_set("America/Lima");
        $fecha = $_POST['fecha'];
        $hora = date('H:i:s');
        $fecha_inv = $fecha.' '.$hora;
        $idProducto = $_POST['idGuardar'];
        $lote = $_POST['lote'];
        $vencimiento = $_POST['vencimiento'];
        $codigoMonedas = $_POST['codigoMonedas'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
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
            idUsuario
        ) VALUES (
            $idAlmacen,
            1, 0, 'INVENTARIO INICIAL',
            '$fecha_inv',
            $idProducto,
            '$lote',
            '$vencimiento',
            '$codigoMonedas',
            $cantidad,
            $precio,
            1
        )";
        $resultado = mysqli_query($conexion, $query);
        if(!$resultado) {
            die('Guardado fallido');
        }
        return false;
    }

    if($_POST['proceso'] == 'Modificar') {
        $idModificar = $_POST['idModificar'];
        $idAlmacen = $_POST['idAlmacen'];
        $lote = $_POST['lote'];
        $vencimiento = $_POST['vencimiento'];
        $codigoMonedas = $_POST['codigoMonedas'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
        $query = "UPDATE almacen_movimientos SET 
            idAlmacen = $idAlmacen,
            lote = '$lote',
            vencimiento = '$vencimiento',
            codigoMonedas = '$codigoMonedas',
            cantidad = $cantidad,
            precio = $precio
            WHERE idAlmacenMovimientos = $idModificar";
        $resultado = mysqli_query($conexion, $query);
        if(!$resultado) {
            die('Modificación fallida');
        }
        return false;
    }

    if($_POST['proceso'] == 'Eliminar') {
        $idEliminar = $_POST['idEliminar'];
        $query = "DELETE FROM almacen_movimientos WHERE idAlmacenMovimientos = $idEliminar";
        $resultado = mysqli_query($conexion, $query);
        if(!$resultado) {
            die('Borrado fallido');
        }
        return false;
    }
?>