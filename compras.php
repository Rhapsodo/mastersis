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
                <span class="fw-bolder fs-4 p-0">Compras</span>
            </div>
            <nav class="row" aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a class="sin-linea link-warning" href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Compras</li>
                </ol>
            </nav>
        </div>

        <div class="col-auto align-self-center">
            <button type="button" class="btn btn-primary btn-sm" id="btn_ingresar_producto" onclick="window.location.href='compras_ingreso.php'">
                <i class="fas fa-cart-plus"></i>
                <span class="ms-1">Ingresar Compra</span>
            </button>

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
        $query = "SELECT COUNT(idCompras) AS total_compras FROM compras";
        $select = mysqli_query($conexion, $query);
        $fila = mysqli_fetch_array($select);
        $total_compras = $fila['total_compras'];
    ?>
    <span class="badge bg-info mt-2 id="msj_resultado_producto_busqueda">Total compras ingresados: <?=$total_compras?></span>
    
    <div class="row mt-2">
        <div class="col">
            <table class="table table-sm table-striped" id="datatable">
                <thead class="table-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Proveedor</th>
                    <th scope="col">Número</th>
                    <th scope="col">Almacén</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Moneda</th>
                    <th scope="col">Total</th>
                    <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT idCompras, proveedor, serieNumero, almacen, fechaCompra, codigoMonedas, total FROM vista_compras";
                        $select = mysqli_query($conexion, $query);
                        $i = 0;
                        while ($fila = mysqli_fetch_array($select)) {
                        $i++;
                    ?>
                    <tr>
                        <td><?=$i?></td>
                        <td><?=$fila['proveedor']?></td>
                        <td><?=$fila['serieNumero']?></td>
                        <td><?=$fila['almacen']?></td>
                        <td><?=$fila['fechaCompra']?></td>
                        <td><?=$fila['codigoMonedas']?></td>                           
                        <td><?=number_format($fila['total'], 2)?></td>              
                        <td>

                            <!-- Button trigger modal -->
                            <a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?=$fila['idCompras']?>">
                                <i class="far fa-eye"></i>
                            </a>

                            <a href="compra_modificado.php?idCompras=<?=$fila['idCompras']?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-pencil-alt"></i>
                            </a>

                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop<?=$fila['idCompras']?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title" id="staticBackdropLabel">
                                                <i class="fas fa-shopping-cart text-success"></i>
                                                <span class="ms-1">COMPRA: <?=$fila['serieNumero']?></span>
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            Detalle de compra:  
                                            <table class="table table-sm table-striped" id="datatable2">
                                                <thead class="table-dark">
                                                    <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Producto</th>
                                                    <th scope="col">Cantidad</th>
                                                    <th scope="col">Precio</th>
                                                    <th scope="col">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $idCompras = $fila['idCompras'];
                                                        $query2 = "SELECT nombre, cantidad, precio FROM compra_detalle WHERE idCompras = $idCompras";
                                                        $select2 = mysqli_query($conexion, $query2);
                                                        $j = 0;
                                                        while ($fila2 = mysqli_fetch_array($select2)) {
                                                            $j++;
                                                    ?>
                                                        <tr>
                                                            <td><?=$j?></td>
                                                            <td><?=$fila2['nombre']?></td>
                                                            <td><?=$fila2['cantidad']?></td>
                                                            <td class="text-end"><?=number_format($fila2['precio'], 2)?></td>
                                                            <td class="text-end"><?=number_format($fila2['cantidad']*$fila2['precio'], 2)?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="4" class="table-dark">Total</th>
                                                        <th class="table-dark"><?=number_format($fila['total'], 2)?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <div class="modal-footer bg-dark">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Regresar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

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