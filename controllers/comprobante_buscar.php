<?php 

include ('../config/conexion.php');

$proceso = $_POST['proceso'];

if ($proceso == 'buscar_serie') {
    $documento = $_POST['documento'];
    $query = "SELECT id, descripcion FROM serie WHERE tipocomp = $documento and estado = '1'";
    $select = mysqli_query($conexion, $query);
    $llenado_combo = "<option value='x' selected>Elegir serie</option>";
    while ($filas = mysqli_fetch_array($select)) {
        $id = $filas['id'];
        $descripcion = $filas['descripcion'];
        $llenado_combo .= "<option value='$id'>$descripcion</option>";
    }
    $salida_json = array(
        'llenado_combo' => $llenado_combo
    );
}

if ($proceso == 'buscar_correlativo') {
    $serie = $_POST['serie'];
    $query = "SELECT correlativo FROM serie WHERE id = $serie";
    $select = mysqli_query($conexion, $query);
    $filas = mysqli_fetch_array($select);
    $correlativo = $filas['correlativo'];
    $salida_json = array(
        'correlativo' => $correlativo
    );
}



echo json_encode($salida_json);
?>