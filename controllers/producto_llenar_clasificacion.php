<?php 

include ('../config/conexion.php');

$proceso = $_POST['proceso'];

if ($proceso == 'buscar_subclase') {
    $clase = $_POST['clase'];
    $query = "SELECT DISTINCT subclase FROM productos_clasificacion WHERE clase = '$clase' ORDER BY subclase";
    $select = mysqli_query($conexion, $query);
    $llenado_combo = "<option value='0' selected>Elegir Subclase</option>";
    while ($filas = mysqli_fetch_array($select)) {
        $subclase = $filas['subclase'];
        $llenado_combo .= "<option value='$subclase'>$subclase</option>";
    }
    $salida_json = array(
        'llenado_combo' => $llenado_combo
    );
}

if ($proceso == 'buscar_grupo') {
    $clase = $_POST['clase'];
    $subclase = $_POST['subclase'];
    $query = "SELECT DISTINCT grupo FROM productos_clasificacion WHERE clase = '$clase' AND subclase = '$subclase' ORDER BY grupo";
    $select = mysqli_query($conexion, $query);
    $llenado_combo = "<option value='0' selected>Elegir Grupo</option>";
    while ($filas = mysqli_fetch_array($select)) {
        $grupo = $filas['grupo'];
        $llenado_combo .= "<option value='$grupo'>$grupo</option>";
    }
    $salida_json = array(
        'llenado_combo' => $llenado_combo
    );
}

if ($proceso == 'buscar_subgrupo') {
    $clase = $_POST['clase'];
    $subclase = $_POST['subclase'];
    $grupo = $_POST['grupo'];
    $query = "SELECT DISTINCT subgrupo FROM productos_clasificacion WHERE clase = '$clase' AND subclase = '$subclase' AND grupo = '$grupo' ORDER BY subgrupo";
    $select = mysqli_query($conexion, $query);
    $llenado_combo = "<option value='0' selected>Elegir Subgrupo</option>";
    while ($filas = mysqli_fetch_array($select)) {
        $subgrupo = $filas['subgrupo'];
        $llenado_combo .= "<option value='$subgrupo'>$subgrupo</option>";
    }
    $salida_json = array(
        'llenado_combo' => $llenado_combo
    );
}

if ($proceso == 'buscar_codigo_clasificacion') {
    $clase = $_POST['clase'];
    $subclase = $_POST['subclase'];
    $grupo = $_POST['grupo'];
    $subgrupo = $_POST['subgrupo'];
    $query = "SELECT code_AECOC FROM productos_clasificacion WHERE clase = '$clase' AND subclase = '$subclase' AND grupo = '$grupo' AND subgrupo = '$subgrupo'";
    $select = mysqli_query($conexion, $query);
    $filas = mysqli_fetch_array($select);
    $code_AECOC = $filas['code_AECOC'];
    $salida_json = array(
        'code_AECOC' => $code_AECOC
    );
}

if ($proceso == 'buscar_campos_clasificacion') {
    $code_AECOC = $_POST['code_AECOC'];
    $query = "SELECT * FROM productos_clasificacion WHERE code_AECOC = '$code_AECOC'";
    $select = mysqli_query($conexion, $query);
    $fila = mysqli_fetch_array($select);
    $clase = $fila['clase'];
    $subclase = $fila['subclase'];
    $grupo = $fila['grupo'];
    $subgrupo = $fila['subgrupo'];

    $salida_json = array(
        'clase' => $clase,
        'subclase' => $subclase,
        'grupo' => $grupo,
        'subgrupo' => $subgrupo
    );
}

echo json_encode($salida_json);
?>