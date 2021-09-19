<?php
    include ('config/conexion.php');
    include ('includes/header1.php');
    include ('includes/datatables.php');
?>

<!-- Sección de Scripts -->
<script type="text/javascript" src="js/alquiler.js"></script>

<?php include ('includes/header2.php'); ?>

<!-- Titulo del formulario -->
<div class="container-fluid border rounded pb-1 bg-dark text-white">
    <div class="row">

        <div class="col-auto fw-bolder fs-1">
            <i class="fas fa-warehouse text-info"></i>
        </div>

        <div class="col-auto me-auto">
            <div class="row">
                <span class="fw-bolder fs-4 p-0">Alquiler de servicios</span>
            </div>
            <nav class="row" aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a class="sin-linea link-warning" href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Alquiler de servicios</li>
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
                $query = "SELECT count(id) as libre FROM alquiler WHERE estado = 'LIBRE'";
                $select = mysqli_query($conexion, $query);
                $fila = mysqli_fetch_array($select);
                $libre = $fila['libre'];
            ?>
            <span class="fw-bolder fs-6 p-0">Boxes disponibles: <?=$libre?></span>
            <input type="hidden" id="hide_libre" value="<?=$libre?>">
            <input type="hidden" id="hide_pasarela" value="0">
        </div>
    </div>
    <div class="row-sm mt-2">
        <div class="col">
            <span class="fw-bolder fs-6 p-0">Selección de boxes</span>
        </div>
    </div>

    <div class="row justify-content-evenly">
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning" id="v1">Boxes:</span>
            <select class="form-select" name="comb_boxes" id="comb_boxes">
                <option value="0" selected>Elegir boxes</option>
                <?php
                    $query = "SELECT * FROM alquiler WHERE estado = 'LIBRE'";
                    $select = mysqli_query($conexion, $query);
                    while ($fila = mysqli_fetch_array($select)) {
                        $idAlquiler = $fila['id'];
                        $nombre = $fila['nombre'];
                        echo "<option value='$idAlquiler'>$nombre</option>";
                    }
                ?>
            </select>
        </div>
    
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning">Fecha:</span>
            <input class="form-control form-control-sm" type="date" name="txt_fecha" id="txt_fecha" value="<?php echo date("Y-m-d");?>">
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