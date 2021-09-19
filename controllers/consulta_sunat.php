<?php
include ('../config/conexion.php');

$tipoDocumento = $_POST['tipoDocumento'];
$numeroIdentidad = $_POST['numeroIdentidad'];
/* $tipoDocumento = 'RUC';
$numeroIdentidad = '20601250269'; */
$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Im1pZ3VlbEBwYXJhZGVyb3dlYi5jb20ifQ.7lzolz5isC2P3pDqRaTqL-KeRCdmYvYdKzjQ-RtuiBA';

if ($tipoDocumento == 'Especial') {
    $query = "SELECT razonSocial FROM personas WHERE numeroIdentidad = '$numeroIdentidad'";
    $select = mysqli_query($conexion,  $query);
    $fila = mysqli_fetch_array($select);
    $razonSocial = $fila['razonSocial'];
    if ($razonSocial) {
        $json = '{';
        $json .= '"mensaje" : "Encontrado en la base de datos",';
        $json .= '"razon_social" : "'.$razonSocial.'",';
        $json .= '"direccion" : {';
            $query_direccion = "SELECT idDireccion, direccion, concatenado FROM vista_persona_direcciones WHERE numeroIdentidad = '$numeroIdentidad'";
            $select_direccion = mysqli_query($conexion, $query_direccion);
            $i=1;
            $total_items = mysqli_num_rows($select_direccion);
            while ($fila_direccion = mysqli_fetch_array($select_direccion)) {
                $direccion = $fila_direccion['direccion'];
                $concatenado = $fila_direccion['concatenado'];
                $json .= '"'.$i.'" : "'.$direccion.' ('.$concatenado.')"';
                $i++;
                if($i <= $total_items) {
                    $json .= ',';
                }
            }
        $json .= '}}';
        echo $json;
    }
};

if ($tipoDocumento == 'RUC') {
    $query = "SELECT razonSocial FROM personas WHERE numeroIdentidad = '$numeroIdentidad'";
    $select = mysqli_query($conexion,  $query);
    $fila = mysqli_fetch_array($select);
    $razonSocial = $fila['razonSocial'];
    if ($razonSocial) {
        $json = '{';
        $json .= '"mensaje" : "Encontrado en la base de datos",';
        $json .= '"razon_social" : "'.$razonSocial.'",';
        $json .= '"direccion" : {';
            $query_direccion = "SELECT idDireccion, direccion, concatenado FROM vista_persona_direcciones WHERE numeroIdentidad = '$numeroIdentidad'";
            $select_direccion = mysqli_query($conexion, $query_direccion);
            $i=1;
            $total_items = mysqli_num_rows($select_direccion);
            while ($fila_direccion = mysqli_fetch_array($select_direccion)) {
                $direccion = $fila_direccion['direccion'];
                $concatenado = $fila_direccion['concatenado'];
                $json .= '"'.$i.'" : "'.$direccion.' ('.$concatenado.')"';
                $i++;
                if($i <= $total_items) {
                    $json .= ',';
                }
            }
        $json .= '}}';
        echo $json;
    } else {
        $data = file_get_contents("https://dniruc.apisperu.com/api/v1/ruc/".$numeroIdentidad."?token=".$token);
        $info = json_decode($data, true);

        $json = '{';
        $json .= '"mensaje" : "Obtenido de internet",';
        $json .= '"razon_social" : "'.$info['razonSocial'].'",';
        $json .= '"direccion" : "'.$info['direccion'].' ('.$info['distrito'].'-'.$info['provincia'].'-'.$info['departamento'].')"}';
        echo $json;
    }
}

if ($tipoDocumento == 'DNI') {
    $query = "SELECT razonSocial FROM personas WHERE numeroIdentidad = '$numeroIdentidad'";
    $select = mysqli_query($conexion,  $query);
    $fila = mysqli_fetch_array($select);
    $razonSocial = $fila['razonSocial'];
    if ($razonSocial) {
        $json = '{';
        $json .= '"mensaje" : "Encontrado en la base de datos",';
        $json .= '"razon_social" : "'.$razonSocial.'",';
        $json .= '"direccion" : {';
            $query_direccion = "SELECT idDireccion, direccion, concatenado FROM vista_persona_direcciones WHERE numeroIdentidad = '$numeroIdentidad'";
            $select_direccion = mysqli_query($conexion, $query_direccion);
            $i=1;
            $total_items = mysqli_num_rows($select_direccion);
            while ($fila_direccion = mysqli_fetch_array($select_direccion)) {
                $direccion = $fila_direccion['direccion'];
                $concatenado = $fila_direccion['concatenado'];
                $json .= '"'.$i.'" : "'.$direccion.' ('.$concatenado.')"';
                $i++;
                if($i <= $total_items) {
                    $json .= ',';
                }
            }
        $json .= '}}';
        echo $json;
    } else {
        $data = file_get_contents("https://dniruc.apisperu.com/api/v1/dni/".$numeroIdentidad."?token=".$token);
        $info = json_decode($data, true);
        
        $json = '{';
        $json .= '"mensaje" : "Obtenido de internet",';
        $json .= '"razon_social" : "'.$info['apellidoPaterno'].' '.$info['apellidoMaterno'].' '.$info['nombres'].'",';
        $json .= '"direccion" : "- (--)"}';
        echo $json;
    }
}


?>