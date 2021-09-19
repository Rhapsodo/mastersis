<?php 
include ('../config/conexion.php');

    if($_POST['proceso'] == 'Guardar') {
        $almacen_origen = $_POST['almacen_origen'];
        $almacen_destino = $_POST['almacen_destino'];
        $numeroTransaccion = $_POST['numeroTransaccion'];
        $documentoReferencia = $_POST['documentoReferencia'];
        $fecha = $_POST['fecha'];
        date_default_timezone_set("America/Lima");
        $hora = date('H:i:s');
        $fecha_traslado = $fecha.' '.$hora;

        $select = mysqli_query($conexion, "SELECT count(fila) as filas FROM pasarela_almacen_traslado");
        $fila = mysqli_fetch_array($select);
        $pasarela = $fila['filas'];
        if ($pasarela == 0) {
            echo $pasarela;
            return false;
        } else {
            echo $pasarela;
            $query = "SELECT * FROM pasarela_almacen_traslado";
            $select_pasarela = mysqli_query($conexion, $query);
            while ($fila_pasarela = mysqli_fetch_array($select_pasarela)) {
                $idProducto = $fila_pasarela['idProducto'];
                $cantidad = $fila_pasarela['cantidad'];
                $precio = $fila_pasarela['precio'];
                $stock = $fila_pasarela['stock'];
                // Si no desea generar negativos hacer if aquí
                /* if ($cantidad > $stock) {
                    echo '<script">alert("Cantidad mayor por: ' . $cantidad - $stock  . '");</script>';
                    return false;
                } */
                $query_ingreso = "INSERT INTO almacen_movimientos (
                    idAlmacen,
                    idAlmacenTransacciones,
                    numeroTransaccion,
                    documentoReferencia,
                    fecha,
                    idProducto,
                    codigoMonedas,
                    cantidad,
                    precio,
                    idUsuario
                ) VALUES (
                    $almacen_destino,
                    7, 
                    $numeroTransaccion, 
                    '$documentoReferencia',
                    '$fecha_traslado',
                    $idProducto,
                    'PEN',
                    $cantidad,
                    $precio,
                    1
                )";
                $query_salida = "INSERT INTO almacen_movimientos (
                    idAlmacen,
                    idAlmacenTransacciones,
                    numeroTransaccion,
                    documentoReferencia,
                    fecha,
                    idProducto,
                    codigoMonedas,
                    cantidad,
                    precio,
                    idUsuario
                ) VALUES (
                    $almacen_origen,
                    8, 
                    $numeroTransaccion, 
                    '$documentoReferencia',
                    '$fecha_traslado',
                    $idProducto,
                    'PEN',
                    ($cantidad*-1),
                    $precio,
                    1
                )";
                $guardar_ingreso = mysqli_query($conexion, $query_ingreso);
                $guardar_salida = mysqli_query($conexion, $query_salida);
            }

            $update = mysqli_query($conexion, "UPDATE correlativos SET correlativo = $numeroTransaccion + 1 WHERE pagina = 'almacen_traslado.php'");
        }

    }

?>