<?php
    include ('config/conexion.php');
    include ('includes/header1.php');
    include ('includes/datatables.php');
?>

<!-- Sección de Scripts -->
<script type="text/javascript" src="js/almacen_traslado.js"></script>

<?php include ('includes/header2.php'); ?>

<!-- Titulo del formulario -->
<div class="container-fluid border rounded pb-1 bg-dark text-white">
    <div class="row">

        <div class="col-auto fw-bolder fs-1">
            <i class="fas fa-warehouse text-info"></i>
        </div>

        <div class="col-auto me-auto">
            <div class="row">
                <span class="fw-bolder fs-4 p-0">Traspasos entre almacenes</span>
            </div>
            <nav class="row" aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a class="sin-linea link-warning" href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item"><a class="sin-linea link-warning" href="almacenes.php">Almacenes</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Traspasos entre almacenes</li>
                </ol>
            </nav>
        </div>

    </div>
</div>

<!-- Cuerpo del formulario -->
<form action="" id="form_grabar" name="form_grabar" method="POST" class="container-fluid bg-white border rounded mt-3">

    <!-- Fila Almacenes-->
    <div class="row-sm mt-2">
        <div class="col">
            <?php
                $query = "SELECT correlativo FROM correlativos WHERE pagina = 'almacen_traslado.php'";
                $select = mysqli_query($conexion, $query);
                $fila = mysqli_fetch_array($select);
                $correlativo = $fila['correlativo'];
            ?>
            <span class="fw-bolder fs-6 p-0">Traslado entre almacenes número: <?=$correlativo?></span>
            <input type="hidden" id="hide_correlativo" value="<?=$correlativo?>">
            <input type="hidden" id="hide_pasarela" value="0">
        </div>
    </div>
    <div class="row-sm mt-2">
        <div class="col">
            <span class="fw-bolder fs-6 p-0">Selección de almacenes</span>
        </div>
    </div>

    <div class="row justify-content-evenly">
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning" id="v1">Almacén de origen:</span>
            <select class="form-select" name="comb_almacen_origen" id="comb_almacen_origen" onchange="reiniciar()">
            <script>
                function reiniciar() {
                    $('#comb_almacen_destino').val(0);
                }
            </script>
                <option value="0" selected>Elegir Almacén</option>
                <?php
                    $query = "SELECT idAlmacen, nombre, abreviatura FROM almacenes";
                    $select = mysqli_query($conexion, $query);
                    while ($fila = mysqli_fetch_array($select)) {
                        $idAlmacen = $fila['idAlmacen'];
                        $nombre = $fila['nombre'];
                        $abreviatura = $fila['abreviatura'];
                        echo "<option value='$idAlmacen'>$abreviatura - $nombre</option>";
                    }
                ?>
            </select>
        </div>
    
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning" id="v2">Almacén de destino:</span>
            <select class="form-select" name="comb_almacen_destino" id="comb_almacen_destino" onchange="comparar()">
            <script>
                function comparar() {
                    let almacen_destino = $('#comb_almacen_destino').val();
                    let almacen_origen = $('#comb_almacen_origen').val();
                    if (almacen_origen == almacen_destino) {
                        alertify.error("Error, almacenes iguales");
                        $('#comb_almacen_destino').val(0);
                    } else {
                        alertify.success("Correcto, almacenes diferentes");
                    }
                }
            </script>
                <option value="0" selected>Elegir Almacén</option>
                <?php
                    $query = "SELECT idAlmacen, nombre, abreviatura FROM almacenes";
                    $select = mysqli_query($conexion, $query);
                    while ($fila = mysqli_fetch_array($select)) {
                        $idAlmacen = $fila['idAlmacen'];
                        $nombre = $fila['nombre'];
                        $abreviatura = $fila['abreviatura'];
                        echo "<option value='$idAlmacen'>$abreviatura - $nombre</option>";
                    }
                ?>
            </select>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col">
            <span class="fw-bolder fs-6 p-0">Documento de referencia</span>
        </div>
    </div>

    <div class="row justify-content-evenly">
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning">Fecha de traslado:</span>
            <input class="form-control form-control-sm" type="date" name="txt_fecha_traslado" id="txt_fecha_traslado" value="<?php echo date("Y-m-d");?>">
        </div>

        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning">Guía de remisión</span>
            <select class="form-select" name="comb_guia_remision" id="comb_guia_remision">
                <option value="TRASLADO INTERNO" selected>TRASLADO INTERNO</option>
                <?php
                    $query = "SELECT * FROM documentos WHERE codigo = '09'";
                    $select = mysqli_query($conexion, $query);
                    while ($fila = mysqli_fetch_array($select)) {
                        $nombre = $fila['nombre'];
                        $correlativo = $fila['correlativo'];
                        echo "<option value='$nombre - $correlativo'>$nombre - $correlativo</option>";
                    }
                ?>
            </select>
        </div>

    </div>

    <!-- Datatable: Buscador de artículos-->
    <div class="row mt-2" id="div_datatable"></div>

    <div class="row justify-content-end mt-3 mb-2">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary btn-sm" id="btn_guardar">
                <i class="far fa-save"></i>
                <span class="ms-1">Guardar Datos</span>
            </button>
        </div>
    </div>
    <input type="hidden" name="proceso" id="proceso" value="guardar_producto">

</form>

<!-- Sección de Scripts -->
<script type="text/javascript" src="js/guardar_almacen_traslado.js"></script>

<?php include ('includes/footer.php'); ?>