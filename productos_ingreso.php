<?php
    session_start();
    include ('config/conexion.php');
    include ('includes/header1.php');
?>

<!-- Sección de Scripts -->
<script type="text/javascript" src="js/productos_ingreso.js"></script>
<script type="text/javascript" src="js/guardar_formulario.js"></script>


<?php include ('includes/header2.php'); ?>

<!-- Titulo del formulario -->
<div class="container-fluid border rounded pb-1 bg-dark text-white">
    <div class="row">

        <div class="col-auto fw-bolder fs-1">
            <i class="fas fa-shopping-bag text-primary"></i>
        </div>

        <div class="col-auto me-auto">
            <div class="row">
                <span class="fw-bolder fs-4 p-0">Ingreso de productos y servicios</span>
            </div>
            <div class="row">
                <div class="card-text p-0">
                    <a href="index.php" class="link-warning" style="text-decoration: none;">Inicio</a> /
                    <a href="productos.php" class="link-warning" style="text-decoration: none;">Productos</a> / Ingreso de productos y servicios
                </div>
            </div>
        </div>

        <div class="col-auto align-self-center">
            <button type="button" class="btn btn-primary btn-sm" id="btn_ingresar_producto" onclick="window.location.href='productos.php'">
                <i class="fas fa-hand-point-left"></i>
                <span class="ms-1">Ir al listado</span>
            </button>

            <button type="button" class="btn btn-primary btn-sm" id="btn_ingresar_producto" onclick="window.location.href='productos_ingreso.php'">
                <i class="fas fa-plus"></i>
                <span class="ms-1">Limpiar campos</span>
            </button>
        </div>
    </div>
</div>

<!-- Cuerpo del formulario -->
<form action="" id="form_grabar" name="form_grabar" method="POST" class="container-fluid bg-white border rounded mt-3">

    <!-- Mensaje con ultimo producto creado -->
    <?php
        if (isset($_SESSION['mensaje']) && $_SESSION['mensaje'] == 'Producto guardado correctamente: ') {
            echo '<span class="badge bg-success mt-2" id="msj_resultado_producto_ultimo">';
            echo $_SESSION['mensaje'];
            echo $_SESSION['ultimo_producto'];
            echo '</span>';
            unset($_SESSION['$mensaje']);
            unset($_SESSION['$ultimo_producto']);
            session_destroy();
        }
    ?>

    <!-- Fila nombre y descripcion -->
    <div class="row mt-1">
        <div class="col">
            <span class="fw-bolder fs-6 p-0">Nombres y descripción</span>
        </div>
    </div>

    <div class="row justify-content-evenly">
        <div class="col-md row-sm">
            <div class="row">
                <div class="col input-group input-group-sm">
                    <span class="input-group-text bg-warning obligatorio1">Nombre 1:</span>
                    <input class="form-control mayusculas" type="text" name="txt_nombre1" id="txt_nombre1">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col input-group input-group-sm">
                    <span class="input-group-text">Nombre 2:</span>
                    <input class="form-control mayusculas" type="text" name="txt_nombre2" id="txt_nombre2">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col input-group input-group-sm">
                    <span class="input-group-text">Nombre 3:</span>
                    <input class="form-control mayusculas" type="text" name="txt_nombre3" id="txt_nombre3">
                </div>
            </div>
        </div>

        <div class="col">
            <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" name="area_descripcion" id="area_descripcion" style="height: 110px"></textarea>
                <label for="area_descripcion" class="text-muted fs-6">Descripción</label>
            </div>
        </div>
    </div>

    <!-- Fila Clasificación-->
    <div class="row-sm mt-2">
        <div class="col">
            <span class="fw-bolder fs-6 p-0">Clasificación</span>
        </div>
    </div>

    <div class="row-sm mb-1">
        <select class="form-select" name="comb_clasificacion" id="comb_clasificacion">
            <option selected value="0">Ingresar criterio de busqueda</option>
            <?php
                $select = mysqli_query($conexion, "SELECT * FROM productos_clasificacion ORDER BY clase, subclase, grupo, subgrupo");
                while ($filas = mysqli_fetch_array($select)) {
                    $code_AECOC = $filas['code_AECOC'];
                    $clase = $filas['clase'];
                    $subclase = $filas['subclase'];
                    $grupo = $filas['grupo'];
                    $subgrupo = $filas['subgrupo'];
                    echo "<option value='$code_AECOC'>$clase / $subclase / $grupo / $subgrupo</option>";
                }
            ?>
        </select>
    </div>

    <div class="row justify-content-evenly">
        <!-- Cargar combo de clase -->
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning obligatorio2">Clase:</span>
            <select class="form-select" name="comb_clase" id="comb_clase">
                <option value="0" selected>Elegir Clase</option>
                <?php
                    $query = "SELECT DISTINCT clase FROM productos_clasificacion";
                    $select = mysqli_query($conexion, $query);
                    while ($fila = mysqli_fetch_array($select)) {
                        $clase = $fila['clase'];
                        echo "<option value='$clase'>$clase</option>";
                    }
                ?>
            </select>
        </div>
        <!-- Cargar combo subclase -->
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning obligatorio3">Subclase:</span>
            <select class="form-select" name="comb_subclase" id="comb_subclase">
                <option selected value="0">Elegir Subclase</option>
            </select>
        </div>
        <!-- Cargar combo de grupo -->
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning obligatorio4">Grupo:</span>
            <select class="form-select" name="comb_grupo" id="comb_grupo">
                <option selected value="0">Elegir Grupo</option>
            </select>
        </div>
        <!-- Cargar combo subgrupo -->
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning obligatorio5">Subgrupo:</span>
            <select class="form-select" name="comb_subgrupo" id="comb_subgrupo">
                <option selected value="0">Elegir Subgrupo</option>
            </select>
        </div>
        <!-- Almacenaremos el campo code_AECOC -->
        <input type="hidden" name="hide_code_aecoc" id="hide_code_aecoc">

    </div>

    <!-- Fila Afectacion de IGV, Código barra, Código interno -->
    <div class="row mt-2">
        <div class="col">
            <span class="fw-bolder fs-6 p-0">Códigos y afectación impuesto</span>
        </div>
    </div>

    <div class="row justify-content-evenly">
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text">Código de Barras:</span>
            <input class="form-control" type="text" name="txt_codigo_barra" id="txt_codigo_barra">
        </div>

        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text">Código Interno:</span>
            <input class="form-control" type="text" name="txt_interno" id="txt_interno">
        </div>

        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning">IGV:</span>
            <select class="form-select" name="comb_afectacion_igv" id="comb_afectacion_igv">
                <?php
                    $query = "SELECT * FROM afectacion_igv";
                    $select = mysqli_query($conexion, $query);
                    while ($fila = mysqli_fetch_array($select)) {
                        $idAfectacionIGV = $fila['idAfectacionIGV'];
                        $descripcion = $fila['descripcion'];
                        if ($idAfectacionIGV == '10') {
                            echo "<option selected value='$idAfectacionIGV'>$descripcion</option>";
                        } else {
                            echo "<option value='$idAfectacionIGV'>$descripcion</option>";
                        }
                    }
                ?>
            </select>
        </div>
    </div>

    <!-- Fila marca, modelo y unidad -->
    <div class="row mt-2">
        <div class="col">
            <span class="fw-bolder fs-6 p-0">Marca, modelo y medida</span>
        </div>
    </div>

    <div class="row justify-content-evenly">
        <div class="col-md row-sm">
            <div class="col input-group input-group-sm">
                <span class="input-group-text">Marca:</span>
                <input class="form-control mayusculas" type="text" name="txt_marca" id="txt_marca">
            </div>
        </div>

        <div class="col-md row-sm">
            <div class="col input-group input-group-sm">
                <span class="input-group-text">Modelo:</span>
                <input class="form-control mayusculas" type="text" name="txt_modelo" id="txt_modelo">
            </div>
        </div>

        <div class="col-md row-sm">
            <div class="col input-group input-group-sm">
                <span class="input-group-text bg-warning">Unidad:</span>
                <select class="form-select" name="comb_unidad" id="comb_unidad">
                    <?php
                        $query = "SELECT * FROM unidad";
                        $select = mysqli_query($conexion, $query);
                        while ($fila = mysqli_fetch_array($select)) {
                            $idUnidad = $fila['idUnidad'];
                            $descripcion = $fila['descripcion'];
                            $unidad = $fila['unidad'];
                            echo "<option value='$idUnidad'>$unidad - $descripcion</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
    </div>

    <!-- Fila stocks, operatividad -->
    <div class="row mt-2">
        <div class="col">
            <span class="fw-bolder fs-6 p-0">Stocks y acciones</span>
        </div>
    </div>
    <div class="row justify-content-evenly">
        <div class="col-md row-sm">
            <div class="col input-group input-group-sm">
                <span class="input-group-text bg-warning obligatorio6">Stock Mínimo:</span>
                <input class="form-control" type="number" name="txt_stock_minimo" id="txt_stock_minimo" value="0.00">
            </div>
        </div>

        <div class="col-md row-sm">
            <div class="col input-group input-group-sm">
                <span class="input-group-text">Stock Máximo:</span>
                <input class="form-control" type="number" name="txt_stock_maximo" id="txt_stock_maximo" value="0.00">
            </div>
        </div>

        <div class="col-md row-sm">
            <div class="row justify-content-evenly">
                <div class="col">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="check_ventas" name="check_ventas" value="SI" checked>
                        <label class="form-check-label" for="check_ventas">*Mueve Ventas</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="check_almacen" name="check_almacen" value="SI" checked>
                        <label class="form-check-label" for="check_almacen">*Mueve Almacén</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Peso y registro sanitario -->
    <div class="row mt-2">
        <div class="col">
            <span class="fw-bolder fs-6 p-0">Peso y registro sanitario</span>
        </div>
    </div>
    <div class="row justify-content-evenly">
        <div class="col-md row-sm">
            <div class="col input-group input-group-sm">
                <span class="input-group-text">Peso Neto:</span>
                <input class="form-control" type="number" name="txt_peso_neto" id="txt_peso_neto" value="0.00">
            </div>
        </div>

        <div class="col-md row-sm">
            <div class="col input-group input-group-sm">
                <span class="input-group-text">Peso Bruto:</span>
                <input class="form-control" type="number" name="txt_peso_bruto" id="txt_peso_bruto" value="0.00">
            </div>
        </div>

        <div class="col-md row-sm">
            <div class="col input-group input-group-sm">
                <span class="input-group-text">Registro Sanitario:</span>
                <input class="form-control mayusculas" type="text" name="txt_registro_sanitario" id="txt_registro_sanitario">
            </div>
        </div>
    </div>

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
<script>

</script>
<?php include ('includes/footer.php'); ?>