<?php

include ('../config/conexion.php');
$accion = $_POST['accion'];

if ($accion == 'agregar_pasarela_persona_direccion') {
    $idEstablecimiento = $_POST['idEstablecimiento'];
    
    $query = "SELECT count(establecimiento) AS numCasaMatriz FROM pasarela_persona_direccion WHERE idEstablecimiento = 'MA'";
    $select = mysqli_query($conexion, $query);
    $fila = mysqli_fetch_array ($select);
    $numCasaMatriz = $fila['numCasaMatriz'];

    if($numCasaMatriz >= 1 && $idEstablecimiento == 'MA') {
        echo '<script>alertify.alert("Ya ingreso la casa matriz");</script>';
    } else {
        $establecimiento = $_POST['establecimiento'];
        $direccion = strtoupper($_POST['direccion']);
        $codigoUbigeo = $_POST['codigoUbigeo'];
        $concatenado = $_POST['concatenado'];

        $query = "INSERT INTO pasarela_persona_direccion (
            idEstablecimiento,
            establecimiento,
            direccion,
            codigoUbigeo,
            concatenado
        ) VALUES (
            '$idEstablecimiento',
            '$establecimiento',
            '$direccion',
            '$codigoUbigeo',
            '$concatenado'
        )";
        $insert = mysqli_query($conexion, $query);
        if(!$insert) {
            echo 'Error de Guardado pasarela '.mysqli_errno($conexion).': '.mysqli_error($conexion).'<br>'.$query;
            return false;
        }
    }
    
}
?>


<table class="table table-sm table-striped" id="datatable">
    <thead class="table-dark">
        <tr>
        <th scope="col">#</th>
        <th scope="col">Establecimiento</th>
        <th scope="col">Ubigeo</th>
        <th scope="col" width="400px">Dirección</th>
        <th scope="col" width="80px">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT idPasarelaPersonaDireccion, idEstablecimiento, establecimiento, codigoUbigeo, concatenado, direccion FROM pasarela_persona_direccion";
        $select = mysqli_query($conexion, $query);
        while ($fila = mysqli_fetch_array($select)) {

        ?>
        <tr>
            <td><?=$fila['idPasarelaPersonaDireccion']?></td>
            <td><?=$fila['establecimiento']?></td>
            <td><?=$fila['concatenado']?></td>
            <td><?=$fila['direccion']?></td>                           
            <td class="text-end">
                <a class="btn btn-danger btn-sm btn-quitar">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
        <?php } ?>
        
    </tbody>
</table>