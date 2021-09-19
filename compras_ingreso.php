<?php
    include ('config/conexion.php');
    include ('includes/header1.php');
    include ('includes/datatables.php');
    
    mysqli_query($conexion, "DELETE FROM pasarela_compra");
?>

<!-- Sección de Scripts -->
<script type="text/javascript" src="js/compras.js"></script>

<?php include ('includes/header2.php'); ?>

<!-- Titulo del formulario -->
<div class="container-fluid border rounded pb-1 bg-dark text-white">
    <div class="row">

        <div class="col-auto fw-bolder fs-1">
            <i class="fas fa-shopping-cart text-success"></i>
        </div>

        <div class="col-auto me-auto">
            <div class="row">
                <span class="fw-bolder fs-4 p-0">Ingreso de compras</span>
            </div>
            <nav class="row" aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a class="sin-linea link-warning" href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item"><a class="sin-linea link-warning" href="compras.php">Compras</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Ingreso de compras</li>
                </ol>
            </nav>
        </div>

    </div>
</div>

<!-- Cuerpo del formulario -->
<form action="" id="form_grabar" name="form_grabar" method="POST" class="container-fluid bg-white border rounded mt-3">

    <div class="row-sm mt-2">
        <div class="col">
            <span class="fw-bolder fs-6 p-0">Cabecera de compra</span>
        </div>
    </div>

    <div class="row justify-content-evenly">
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning" id="v1">Tipo de documento:</span>
            <select class="form-select" name="comb_tipo_documento" id="comb_tipo_documento">
                <option value="0" selected>Elegir tipo de documento</option>
                <?php
                    $query = "SELECT * FROM documento_tipo WHERE accion like '%COMPRA%'";
                    $select = mysqli_query($conexion, $query);
                    while ($fila = mysqli_fetch_array($select)) {
                        $codigo = $fila['codigo'];
                        $descripcion = $fila['descripcion'];
                        echo "<option value='$codigo'>$descripcion</option>";
                    }
                ?>
            </select>
        </div>
    
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning" id="v2">Serie y número:</span>
            <input class="form-control form-control-sm" type="text" name="txt_serie_numero" id="txt_serie_numero">
        </div>

        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning" id="v3">Moneda:</span>
            <select class="form-select" name="comb_moneda" id="comb_moneda">
                <?php
                    $query = "SELECT * FROM monedas";
                    $select = mysqli_query($conexion, $query);
                    while ($fila = mysqli_fetch_array($select)) {
                        $codigoMonedas = $fila['codigoMonedas'];
                        $descripcion = $fila['descripcion'];
                        if ($codigoMonedas == 'PEN') {
                            echo "<option selected value='$codigoMonedas'>$codigoMonedas - $descripcion</option>";
                        } else {
                            echo "<option value='$codigoMonedas'>$codigoMonedas - $descripcion</option>";
                        }
                    }
                ?>
            </select>
        </div>
    </div>

    <div class="row mt-2 justify-content-evenly">
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning" id="v4">Fecha compra:</span>
            <input class="form-control form-control-sm" type="date" name="txt_fecha_compra" id="txt_fecha_compra" value="<?php echo date("Y-m-d");?>">
        </div>

        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text">Fecha pago:</span>
            <input class="form-control form-control-sm" type="date" name="txt_fecha_pago" id="txt_fecha_pago" value="<?php echo date("Y-m-d");?>">
        </div>
    </div>

    <div class="row mt-2 justify-content-evenly">
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning" id="v5">Proveedor:</span>
            <input class="form-control form-control-sm" type="text" name="txt_proveedor" id="txt_proveedor" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
            <button class="btn btn-success d-none" type="button" id="btn-guardar-proveedor">
                <i class="fas fa-save"></i>
            </button>
            <button class="btn btn-danger d-none" type="button" id="btn-buscar-proveedor">
                <i class="fas fa-user-shield"></i>
            </button>
            <button class="btn btn-primary" type="button" id="btn-proveedor">
                <i class="fas fa-search"></i>
            </button>
        </div>

        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text">Razón Social:</span>
            <input class="form-control form-control-sm" type="text" name="txt_razon_social" id="txt_razon_social" disabled>
        </div>

        <div class="row-sm mt-2 input-group input-group-sm d-none" id="proveedor_especial">
            <span class="input-group-text">Proveedor indocumentado:</span>
            <select class="form-select" id="comb_proveedor_indocumentado">
                <option value="x" selected>Elegir proveedor</option>
                <?php
                    $query = "SELECT numeroIdentidad, razonSocial FROM personas WHERE idIdentidad = 0 ORDER BY razonSocial ASC";
                    $select = mysqli_query($conexion, $query);
                    while ($fila = mysqli_fetch_array($select)) {
                        $numeroIdentidad = $fila['numeroIdentidad'];
                        $razonSocial = $fila['razonSocial'];
                        echo "<option value='$numeroIdentidad'>$razonSocial</option>";
                    }
                ?>
            </select>
        </div>

        <div class="row-sm mt-2 input-group input-group-sm">
            <span class="input-group-text bg-warning" id="v6">Dirección:</span>
            <select class="form-select" name="comb_direccion" id="comb_direccion">
                <option value="x" selected>Elegir dirección</option>
            </select>
        </div>
    </div>

    <div class="row-sm mt-2">
        <div class="col">
            <span class="fw-bolder fs-6 p-0">Detalle de compra</span>
        </div>
    </div>

    <div class="row-sm mt-0 input-group input-group-sm">
        <span class="input-group-text bg-warning" id="v7">Productos:</span>
        <select class="form-control form-control-sm" name="comb_productos" id="comb_productos">
            <option value="0" selected>Elegir Producto</option>
            <?php
                $query = "SELECT idProducto, nombre1 FROM productos WHERE estado != 'ELIMINADO' ORDER BY nombre1";
                $select = mysqli_query($conexion, $query);
                while ($fila = mysqli_fetch_array($select)) {
                    $idProducto = $fila['idProducto'];
                    $nombre1 = $fila['nombre1'];
                    echo "<option value='$idProducto'>$nombre1</option>";
                }
            ?>
        </select>
        <button class="btn btn-primary" type="button" id="btn-agregar-producto">
            <i class="fas fa-plus"></i>
        </button>
    </div>
    

    <!-- Datatable: Buscador de artículos-->
    <div class="row mt-2" id="div_datatable"></div>

    <div class="row justify-content-end mb-2">
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
<script type="text/javascript" src="js/guardar_compra.js"></script>

<?php include ('includes/footer.php'); ?>