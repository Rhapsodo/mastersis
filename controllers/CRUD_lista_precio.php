<?php 
include ('../config/conexion.php');

    if($_POST['proceso'] == 'Guardar') {
        //idPrecioLista, idProducto, codigoMonedas, precio,
        $idPrecioLista = $_POST['idPrecioLista'];
        $idProducto = $_POST['idProducto'];
        $codigoMonedas = $_POST['codigoMonedas'];
        $precio = $_POST['precio'];
        $query = "INSERT INTO precio_venta (
            idPrecioLista,
            idProducto,
            codigoMonedas,
            precio
        ) VALUES (
            $idPrecioLista,
            $idProducto,
            '$codigoMonedas',
            $precio
        )";
        $resultado = mysqli_query($conexion, $query);
        if(!$resultado) {
            die('Guardado fallido');
        }
        $idPrecioVenta = mysqli_insert_id($conexion);
        echo $idPrecioVenta;
    }

    if($_POST['proceso'] == 'Modificar') {
        $idPrecioVenta = $_POST['idPrecioVenta']; 
        $idPrecioLista = $_POST['idPrecioLista'];
        $idProducto = $_POST['idProducto'];
        $codigoMonedas = $_POST['codigoMonedas'];
        $precio = $_POST['precio'];
        $query = "UPDATE precio_venta SET 
            idPrecioLista = $idPrecioLista,
            idProducto = $idProducto,
            codigoMonedas = '$codigoMonedas',
            precio = $precio
            WHERE idPrecioVenta = $idPrecioVenta";
        $resultado = mysqli_query($conexion, $query);
        if(!$resultado) {
            die('Modificación fallida');
        }
        return false;
    }

    if($_POST['proceso'] == 'Eliminar') {
        $idPrecioVenta = $_POST['idPrecioVenta'];
        $query = "DELETE FROM precio_venta WHERE idPrecioVenta = $idPrecioVenta";
        $resultado = mysqli_query($conexion, $query);
        if(!$resultado) {
            die('Borrado fallido');
        }
        return false;
    }
?>