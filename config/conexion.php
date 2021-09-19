<?php
    //session_start();
    $hostserver = 'localhost:3306';
    
    //pruebas locales
    $usuario = 'root';
    $clave = 'mck7895123';
    $BD = 'db_paraderoweb';

    

    $conexion = mysqli_connect($hostserver, $usuario, $clave, $BD);
    mysqli_set_charset($conexion,'utf8');
?>