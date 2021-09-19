<?php
    
include ('../config/conexion.php');

$accion = $_POST['accion'];

if($accion == 'buscar_id_especial') {
    $query = "SELECT correlativo FROM correlativos WHERE pagina = 'personas_ingreso.php'";
    $select = mysqli_query($conexion, $query);
    $fila = mysqli_fetch_array($select);
    $correlativo = $fila['correlativo'];
    echo 'PE'.str_pad($correlativo, 3, '0', STR_PAD_LEFT);
}

if ($accion == 'Guardar_persona') {
    //Guardado tabla personas
    $idIdentidad = $_POST['idIdentidad'];
    $numeroIdentidad = strtoupper($_POST['numeroIdentidad']);
    $razonSocial = strtoupper($_POST['razonSocial']);
    $nombreComercial = strtoupper($_POST['nombreComercial']);
    $direccionLarga = strtoupper($_POST['direccionLarga']);
    $estado = 'ACTIVO';

    if ($_POST['esCliente'] == 'true') {
        $esCliente = 'SI';
    } else {
        $esCliente = 'NO';
    }
    if ($_POST['esProveedor'] == 'true') {
        $esProveedor = 'SI';
    } else {
        $esProveedor = 'NO';
    }
    if ($_POST['esPersonal'] == 'true') {
        $esPersonal = 'SI';
    } else {
        $esPersonal = 'NO';
    }
    if ($_POST['esBanco'] == 'true') {
        $esBanco = 'SI';
    } else {
        $esBanco = 'NO';
    }

    $telefonoCliente = $_POST['telefono'];
    $web = $_POST['web'];
    $facebook = $_POST['facebook'];
    $instagram = $_POST['instagram'];
    date_default_timezone_set("America/Lima");
    $fechaAlta = date('Y-m-d H:i:s');

    $query = "INSERT INTO personas (
        idIdentidad,
        numeroIdentidad,
        razonSocial,
        nombreComercial,
        direccionLarga,
        estado,
        esCliente,
        esProveedor,
        esPersonal,
        esBanco,
        telefono,
        web,
        facebook,
        instagram,
        fechaAlta
    ) VALUES (
        '$idIdentidad',
        '$numeroIdentidad',
        '$razonSocial',
        '$nombreComercial',
        '$direccionLarga',
        '$estado',
        '$esCliente',
        '$esProveedor',
        '$esPersonal',
        '$esBanco',
        '$telefonoCliente',
        '$web',
        '$facebook',
        '$instagram',
        '$fechaAlta'
    )";
    $resultado = mysqli_query($conexion, $query);
    if(!$resultado) {
        echo 'Error de Guardado tabla personas '.mysqli_errno($conexion).': '.mysqli_error($conexion).'<br>'.$query;
        return false;
    }
    
    // Obtenemos el id de la compra guardada
    $idPersona = mysqli_insert_id($conexion);

    /* Actualizamos el contador del cliente indocumentado */
    if ($idIdentidad == 0) {
        $query = "UPDATE correlativos SET correlativo = correlativo + 1 WHERE pagina = 'personas_ingreso.php'";
        $update = mysqli_query($conexion, $query);
        if(!$update) {
            echo 'Error de Guardado correlativo '.mysqli_errno($conexion).': '.mysqli_error($conexion).'<br>'.$query;
            return false;
        }
    }

    $query = "SELECT * FROM pasarela_persona_direccion";
    $select = mysqli_query($conexion, $query);
    while($fila = mysqli_fetch_array($select)) {
        $idEstablecimiento = $fila['idEstablecimiento'];
        $codigoUbigeo = $fila['codigoUbigeo'];
        $direccion = $fila['direccion'];

        // Guardado de la direccion
        $query = "INSERT INTO persona_direccion (
            idPersona,
            idEstablecimiento,
            codigoUbigeo,
            direccion           
        ) VALUES (
            $idPersona,
            '$idEstablecimiento',
            '$codigoUbigeo',
            '$direccion'
        )";
        $resultado = mysqli_query($conexion, $query);
        echo $query;
        return false;
        if(!$resultado) {
            echo 'Error de Guardado direccion '.mysqli_errno($conexion).': '.mysqli_error($conexion).'<br>'.$query;
            return false;
        }
    }

    $query = "SELECT * FROM pasarela_persona_contacto";
    $select = mysqli_query($conexion, $query);
    while($fila = mysqli_fetch_array($select)) {
        $nombre = $fila['nombre'];
        $telefono = $fila['telefono'];
        $correo = $fila['correo'];

        // Guardado del contacto
        $query = "INSERT INTO persona_contacto (
            idPersona,
            nombre,
            telefono,
            correo            
        ) VALUES (
            $idPersona,
            '$nombre',
            '$telefono',
            '$correo' 
        )";
        $resultado = mysqli_query($conexion, $query);
        if(!$resultado) {
            echo 'Error de Guardado contacto '.mysqli_errno($conexion).': '.mysqli_error($conexion).'<br>'.$query;
            return false;
        }
    }

    echo 'Se guardó la persona correctamente';
}