<?php include ('config/conexion.php'); ?>
<?php include ('includes/header1.php'); ?>
<?php include ('includes/datatables.php'); ?>
<!-- Sección de Scripts -->
<script type="text/javascript" src="js/productos_lista.js"></script>

<?php include ('includes/header2.php'); ?>

<!-- Cuerpo formulario -->
<div class="container-fluid border rounded pb-1 bg-dark text-white">
    <div class="row">

        <div class="col-auto fw-bolder fs-1">
            <i class="fas fa-shopping-bag text-primary"></i>
        </div>

        <div class="col-auto me-auto">
            <div class="row">
                <span class="fw-bolder fs-4 p-0">Listado de productos y servicios</span>
            </div>
            <nav class="row" aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a class="sin-linea link-warning" href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Productos</li>
                </ol>
            </nav>
        </div>

        <div class="col-auto align-self-center">
            <button type="button" class="btn btn-primary btn-sm" id="btn_ingresar_producto" onclick="window.location.href='productos_ingreso.php'">
                <i class="fas fa-plus"></i>
                <span class="ms-1">Ingresar Nuevo</span>
            </button>

            <!-- <button type="button" class="btn btn-success btn-sm" id="btn_exportar_producto">
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
<div class="container-fluid bg-white border rounded mt-3">
    <!-- <div class="row mt-3">
        <div class="col input-group input-group-sm">
            <span class="input-group-text">Producto o servicio:</span>
            <input class="form-control form-control-sm" type="text" id="txt_buscador_producto" name="txt_buscador_producto">
            <button type="button" class="btn btn-primary" id="">
                <i class="fas fa-search"></i>
                <span class="ms-1">Buscar</span>
            </button>
        </div>
    </div> -->
    <?php
        $query = "SELECT COUNT(idProducto) AS total_productos FROM productos WHERE estado != 'ELIMINADO'";
        $select = mysqli_query($conexion, $query);
        $fila = mysqli_fetch_array($select);
        $total_productos = $fila['total_productos'];
    ?>
    <span class="badge bg-info mt-2 id="msj_resultado_producto_busqueda">Total productos ingresados: <?=$total_productos?></span>
    
    <div class="row mt-2">
        <div class="col">
            <table class="table table-sm table-striped" id="datatable">
                <thead class="table-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Clasificación</th>
                    <th scope="col">Stock Minimo</th>
                    <th scope="col">Alta</th>
                    <th scope="col">Presentaciones</th>
                    <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT idProducto, nombre1, code_AECOC, stockMinimo, fechaAlta FROM productos WHERE estado != 'ELIMINADO'";
                        $select = mysqli_query($conexion, $query);
                        $i = 0;
                        while ($fila = mysqli_fetch_array($select)) {
                        $i++;
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $fila['nombre1'] ?></td>
                        <td><?= $fila['code_AECOC'] ?></td>
                        <td><?= $fila['stockMinimo'] ?></td>
                        <td><?= $fila['fechaAlta'] ?></td>
                        <td><?= 'NO' ?></td>                           
                        <td>
                            <a href="productos_modificado.php?idProducto=<?=$fila['idProducto']?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-pencil-alt"></i>
                            </a>

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?=$fila['idProducto']?>">
                            <i class="fas fa-trash-alt"></i>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop<?=$fila['idProducto']?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title" id="staticBackdropLabel">
                                                <i class="fas fa-trash-alt text-danger"></i>
                                                <span class="ms-1">ELIMINADO DE ÍTEM</span>
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Esta seguro de eliminar el ítem seleccionado? 
                                            <br><?=$fila['nombre1']?>
                                        </div>
                                        <div class="modal-footer bg-dark">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <a type="button" href="productos_eliminado.php?idProducto=<?=$fila['idProducto']?>" class="btn btn-danger">Eliminar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button class="btn btn-success btn-sm">
                                <i class="fas fa-sitemap"></i>
                            </button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Sección de Scripts -->
<script>
    $(document).ready( function () {
        $('#datatable').DataTable( {
            "pagingType": 'full_numbers',
            "language": {
                "url": "modules/datatables/Spanish.json"
            },
            //Habilitar cuando se usará botones
            /* dom: 'Bfrtilp', 
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    titleAttr: 'Exportar a Excel',
                    className: 'btn btn-success btn-sm'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    titleAttr: 'Exportar a PDF',
                    className: 'btn btn-danger btn-sm'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Imprimir',
                    titleAttr: 'Imprimir',
                    className: 'btn btn-secondary btn-sm'
                }
            ] */
        } );

    } );

</script>
<?php include ('includes/footer.php'); ?>