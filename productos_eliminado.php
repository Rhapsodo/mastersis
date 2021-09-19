<?php 
include('config/conexion.php');

    if(isset($_GET['idProducto'])) {
        $id = $_GET['idProducto'];
        date_default_timezone_set("America/Lima");
        $fechaEliminado = date('Y-m-d H:i:s');
        $query = "UPDATE productos SET 
        estado = 'ELIMINADO',
        fechaEliminado = '$fechaEliminado'
        WHERE idProducto = $id";
        $resultado = mysqli_query($conexion, $query);
        if(!$resultado) {
            die('Borrado fallido');
        }
        header("Location: productos.php");
    }
?>