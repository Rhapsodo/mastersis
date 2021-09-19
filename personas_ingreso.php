<?php
    include ('config/conexion.php');
    include ('includes/header1.php');
    mysqli_query($conexion, "DELETE FROM pasarela_persona_direccion");
    mysqli_query($conexion, "ALTER TABLE pasarela_persona_direccion AUTO_INCREMENT = 1");

    mysqli_query($conexion, "DELETE FROM pasarela_persona_contacto");
    mysqli_query($conexion, "ALTER TABLE pasarela_persona_contacto AUTO_INCREMENT = 1");
    
?>

<!-- Sección de Scripts -->
<script type="text/javascript" src="js/personas_ingreso.js"></script>


<?php include ('includes/header2.php'); ?>

<!-- Titulo del formulario -->
<div class="container-fluid border rounded pb-1 bg-dark text-white">
    <div class="row">

        <div class="col-auto fw-bolder fs-1">
            <i class="fas fa-shopping-bag text-primary"></i>
        </div>

        <div class="col-auto me-auto">
            <div class="row">
                <span class="fw-bolder fs-4 p-0">Ingreso de personas</span>
            </div>
            <nav class="row" aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a class="sin-linea link-warning" href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item"><a class="sin-linea link-warning" href="personas.php">Personas</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Listado de personas</li>
                </ol>
            </nav>
        </div>

        <div class="col-auto align-self-center">
            <button type="button" class="btn btn-primary btn-sm" id="btn_ingresar_producto" onclick="window.location.href='personas.php'">
                <i class="fas fa-hand-point-left"></i>
                <span class="ms-1">Ir al listado</span>
            </button>

            <button type="button" class="btn btn-primary btn-sm" id="btn_ingresar_producto" onclick="window.location.href='personas_ingreso.php'">
                <i class="fas fa-plus"></i>
                <span class="ms-1">Limpiar campos</span>
            </button>
        </div>
    </div>
</div>

<!-- Cuerpo del formulario -->
<form action="" id="form_grabar" name="form_grabar" method="POST" class="container-fluid bg-white border rounded mt-3">

    <!-- Datos de la documentación -->
    <div class="row mt-2">
        <div class="col">
            <span class="fw-bolder fs-6 p-0">Datos de la documentación</span>
        </div>
    </div>

    <div class="row justify-content-evenly">
        <!-- idIdentidad -->
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning obligatorio2" id="v1">Tipo de documento:</span>
            <select class="form-select" id="comb_idIdentidad">
                <option selected value="x">Seleccionar tipo de documento</option>
                <?php
                    $select = mysqli_query($conexion, "SELECT * FROM identidad WHERE estado = 'ACTIVO' ORDER BY idIdentidad");
                    while ($filas = mysqli_fetch_array($select)) {
                        $idIdentidad = $filas['idIdentidad'];
                        $descripcion = $filas['descripcion'];
                        echo "<option value='$idIdentidad'>$descripcion</option>";
                    }
                ?>
            </select>
        </div>
        <!-- numeroIdentidad -->
        <div class="col input-group input-group-sm">
            <span class="input-group-text bg-warning" id="v2">Número identidad:</span>
            <input class="form-control mayusculas" type="text" id="txt_numeroIdentidad">
        </div>
    </div>

    <!-- Datos de la persona -->
    <div class="row mt-2">
        <div class="col">
            <span class="fw-bolder fs-6 p-0">Datos de la persona</span>
        </div>
    </div>

    <div class="row justify-content-evenly">
        <!-- razonSocial -->
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning obligatorio2" id="v3">Razón Social:</span>
            <input class="form-control mayusculas" type="text" id="txt_razonSocial">
        </div>

        <!-- nombreComercial -->
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text obligatorio2">Nombre Comercial:</span>
            <input class="form-control mayusculas" type="text" id="txt_nombreComercial">
        </div>
    </div>

    <div class="row mt-2 justify-content-evenly">
        <!-- direccionLarga -->
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text bg-warning obligatorio2" id="v4">Dirección principal:</span>
            <input class="form-control mayusculas" type="text" id="txt_direccionLarga" disabled>
        </div>
    </div>

    <!-- Checks de tipo de persona -->
    <div class="row mt-1 justify-content-evenly">
        <div class="col-md row-sm">
            <div class="row justify-content-evenly">

                <div class="col">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="check_esCliente" name="check_esCliente" value="SI" checked>
                        <label class="form-check-label" for="check_esCliente">*Es Cliente</label>
                    </div>
                </div>

                <div class="col">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="check_esProveedor" name="check_esProveedor" value="SI" checked>
                        <label class="form-check-label" for="check_esProveedor">*Es Proveedor</label>
                    </div>
                </div>

                <div class="col">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="check_esPersonal" name="check_esPersonal" value="SI">
                        <label class="form-check-label" for="check_esPersonal">*Es Personal</label>
                    </div>
                </div>

                <div class="col">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="check_esBanco" name="check_esBanco" value="SI">
                        <label class="form-check-label" for="check_esBanco">*Es Banco</label>
                    </div>
                </div>
            </div>
        </div>
    </div>      
    
    <!-- Redes Sociales -->
    <div class="row mt-1 justify-content-evenly">
        <!-- telefono -->
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text obligatorio2">Teléfono:</span>
            <input class="form-control mayusculas" type="text" id="txt_telefono">
        </div>
        
        <!-- web -->
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text obligatorio2">Página web:</span>
            <input class="form-control mayusculas" type="text" id="txt_web">
        </div>

        <!-- facebook -->
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text obligatorio2">Facebook:</span>
            <input class="form-control mayusculas" type="text" id="txt_facebook">
        </div>

        <!-- instagram -->
        <div class="col-md row-sm input-group input-group-sm">
            <span class="input-group-text obligatorio2">Instagram:</span>
            <input class="form-control mayusculas" type="text" id="txt_instagram">
        </div>
    </div>

    <!-- Direcciones -->
    <div class="row mt-2">
        <div class="col">
            <span class="fw-bolder fs-6 p-0">Direcciones</span>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <select class="form-select form-select-sm" id="comb_idEstablecimiento">
            <option value="0" selected>Elegir Establecimiento</option>
            <?php
                $query = "SELECT * FROM direccion_establecimiento";
                $select = mysqli_query($conexion, $query);
                while ($fila = mysqli_fetch_array($select)) {
                    $idEstablecimiento = $fila['idEstablecimiento'];
                    $establecimiento = $fila['establecimiento'];
                    echo "<option value='$idEstablecimiento'>$establecimiento</option>";
                }
            ?>
            </select>
        </div>
        <div class="col-4">
            <select class="form-select form-select-sm" id="comb_codigoUbigeo">
            <option value="0" selected>Elegir Ubigeo</option>
            <?php
                $query = "SELECT codigoUbigeo, concatenado FROM ubigeo";
                $select = mysqli_query($conexion, $query);
                while ($fila = mysqli_fetch_array($select)) {
                    $codigoUbigeo = $fila['codigoUbigeo'];
                    $concatenado = $fila['concatenado'];
                    echo "<option value='$codigoUbigeo'>$concatenado</option>";
                }
            ?>
            </select>
        </div>
        <div class="col-md row-sm input-group input-group-sm">
            <input class="form-control form-control-sm mayusculas" type="text" id="txt_direccion" placeholder="Digita dirección">
            <a class="btn btn-primary btn-sm btn-guardar-direccion">
                <i class="fas fa-save"></i>
            </a>
        </div>
    </div>
    <!-- contenedor de las direcciones -->
    <div class="mt-2" id="filas_pasarela_personas_direccion"></div>

    <!-- Contactos -->
    <div class="row mt-2">
        <div class="col">
            <span class="fw-bolder fs-6 p-0">Contactos</span>
        </div>
    </div>
    <div class="row">
        <div class="col-5">
            <input class="form-control form-control-sm mayusculas" type="text" id="txt_nombre" placeholder="Nombre de contacto">
        </div>
        <div class="col-3">
            <input class="form-control form-control-sm mayusculas" type="text" id="txt_telefono" placeholder="Teléfono">
        </div>
        <div class="col-md row-sm input-group input-group-sm">
            <input class="form-control form-control-sm mayusculas" type="text" id="txt_correo" placeholder="Correo">
            <a class="btn btn-primary btn-sm btn-guardar-contacto">
                <i class="fas fa-save"></i>
            </a>
        </div>
    </div>
    <!-- contenedor de las direcciones -->
    <div class="mt-2" id="filas_pasarela_personas_contacto"></div>

    <!-- ---------------------------------------------------------------------------------------- -->
    
    <div class="row justify-content-end mt-3 mb-2">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary btn-sm" id="btn_guardar">
                <i class="far fa-save"></i>
                <span class="ms-1">Guardar Datos</span>
            </button>
        </div>
    </div>

</form>

<!-- Sección de Scripts -->
<script type="text/javascript" src="js/personas_ingreso_fin.js"></script>

<?php include ('includes/footer.php'); ?>