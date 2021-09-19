<?php

include ('../config/conexion.php');
$accion = $_POST['accion'];

if ($accion == 'agregar_pasarela_persona_contacto') {
    $nombre = strtoupper($_POST['nombre']);
    $telefono = $_POST['telefono'];
    $correo =  strtolower($_POST['correo']);

    $query = "INSERT INTO pasarela_persona_contacto (
        nombre,
        telefono,
        correo
    ) VALUES (
        '$nombre',
        '$telefono',
        '$correo'
    )";
    $insert = mysqli_query($conexion, $query);
    if(!$insert) {
        echo 'Error de Guardado pasarela contacto '.mysqli_errno($conexion).': '.mysqli_error($conexion).'<br>'.$query;
        return false;
    }
    
}
?>

<table class="table table-sm table-striped" id="datatable">
    <thead class="table-dark">
        <tr>
        <th scope="col">#</th>
        <th scope="col" width="400px">Nombre</th>
        <th scope="col">Teléfono</th>
        <th scope="col" width="400px">Correo</th>
        <th scope="col" width="80px">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT idPasarelaPersonaContacto, nombre, telefono, correo FROM pasarela_persona_contacto";
        $select = mysqli_query($conexion, $query);
        while ($fila = mysqli_fetch_array($select)) {

        ?>
        <tr>
            <td><?=$fila['idPasarelaPersonaContacto']?></td>
            <td><?=$fila['nombre']?></td>
            <td><?=$fila['telefono']?></td>
            <td><?=$fila['correo']?></td>                           
            <td class="text-end">
                <a class="btn btn-danger btn-sm btn-quitar">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
        <?php } ?>
        
    </tbody>
</table>