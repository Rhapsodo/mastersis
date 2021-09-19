<?php include ('config/conexion.php'); ?>
<?php include ('includes/header1.php'); ?>
<?php include ('includes/datatables.php'); ?>
<!-- Sección de Scripts -->
<script type="text/javascript" src="js/inventario_inicial.js"></script>

<?php include ('includes/header2.php'); ?>

<!-- Cuerpo formulario -->
<div class="container-fluid border rounded pb-1 bg-dark text-white">
    <div class="row">

        <div class="col-auto fw-bolder fs-1">
            <i class="fas fa-warehouse text-info"></i>
        </div>

        <div class="col-auto me-auto">
            <div class="row">
                <span class="fw-bolder fs-4 p-0">Inventario inicial</span>
            </div>
            <nav class="row" aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a class="sin-linea link-warning" href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item"><a class="sin-linea link-warning" href="inventario.php">Inventario</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Inventario inicial</li>
                </ol>
            </nav>
        </div>

        <div class="col-auto align-self-center">
            <!-- <button type="button" class="btn btn-primary btn-sm" id="btn_ingresar_producto" onclick="window.location.href='productos_ingreso.php'">
                <i class="fas fa-plus"></i>
                <span class="ms-1">Ingresar Nuevo</span>
            </button>

            <button type="button" class="btn btn-success btn-sm" id="btn_exportar_producto">
                <i class="fas fa-file-download"></i>
                <span class="ms-1">Exportar XLS</span>
            </button>

            <button type="button" class="btn btn-success btn-sm" id="btn_importar_producto">
                <i class="fas fa-file-upload"></i>
                <span class="ms-1">Importar XLS</span>
            </button> -->
        </div>
    </div>
</div>

<!-- Cuerpo del contenido -->
<form class="container-fluid bg-white border rounded mt-3" action="" id="form_invini">

    <?php
        $query = "SELECT COUNT(idProducto) AS total_productos FROM productos WHERE estado != 'ELIMINADO'";
        $select = mysqli_query($conexion, $query);
        $fila = mysqli_fetch_array($select);
        $total_productos = $fila['total_productos'];
    ?>
    <span class="badge bg-info mt-2 id="msj_resultado_producto_busqueda">Total productos ingresados: <?=$total_productos?></span>

    <div class="row justify-content-evenly mt-2">
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning obligatorio2">Almacén:</span>
            <select class="form-select" name="comb_almacen" id="comb_almacen">
                <?php
                    $query = "SELECT * FROM almacenes";
                    $select = mysqli_query($conexion, $query);
                    echo '<option value="0" selected>Elegir Almacen</option>';
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
            <span class="input-group-text bg-warning obligatorio2">Fecha Inventario:</span>
            <input class="form-control form-control-sm" type="date" name="txt_fecha_inventario" id="txt_fecha_inventario" value="<?php echo date("Y-m-d");?>">
        </div>
        
    </div>
    
    <!-- Datatable -->
    <div class="row mt-2" id="div_datatable"></div>
</form>


<!-- Sección de Scripts -->
<script>

</script>
<?php include ('includes/footer.php'); ?>