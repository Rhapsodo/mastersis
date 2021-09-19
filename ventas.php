<?php
    include ('config/conexion.php');
    include ('includes/header1.php');
    include ('includes/datatables.php');
    
    mysqli_query($conexion, "DELETE FROM pasarela_compra");
?>

<!-- Sección de Scripts -->
<script type="text/javascript" src="js/ventas.js"></script>

<?php include ('includes/header2.php'); ?>

<!-- Titulo del formulario -->
<div class="container-fluid border rounded pb-1 bg-dark text-white">
    <div class="row">

        <div class="col-auto fw-bolder fs-1">
            <i class="fas fa-shopping-cart text-success"></i>
        </div>

        <div class="col-auto me-auto">
            <div class="row">
                <span class="fw-bolder fs-4 p-0">Ventas</span>
            </div>
            <nav class="row" aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a class="sin-linea link-warning" href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Ventas</li>
                </ol>
            </nav>
        </div>

        <div class="col-auto align-self-center">
            <button type="button" class="btn btn-primary btn-sm" id="btn_ingresar_producto" onclick="window.location.href='ventas_ingreso.php'">
                <i class="fas fa-cart-plus"></i>
                <span class="ms-1">Ingresar Venta</span>
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
        $query = "SELECT COUNT(id) AS total_ventas FROM ventas";
        $select = mysqli_query($conexion, $query);
        $fila = mysqli_fetch_array($select);
        $total_ventas = $fila['total_ventas'];
    ?>
    <span class="badge bg-info mt-2" id="msj_resultado_producto_busqueda">Total compras ingresados: <?=$total_ventas?></span>
    
    <div class="row mt-2">
        <div class="col">
            <table class="table table-sm table-striped" id="datatable">
                <thead class="table-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Documento</th>
                    <th scope="col">Almacén</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Moneda</th>
                    <th scope="col">Total</th>
                    <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT id, razonSocial, documento, almacen, fecha_emision, codmoneda, total FROM vista_ventas ORDER BY id DESC";
                        $select = mysqli_query($conexion, $query);
                        $i = 0;
                        while ($fila = mysqli_fetch_array($select)) {
                        $i++;
                    ?>
                    <tr>
                        <td><?=$i?></td>
                        <td><?=$fila['razonSocial']?></td>
                        <td><?=$fila['documento']?></td>
                        <td><?=$fila['almacen']?></td>
                        <td><?=$fila['fecha_emision']?></td>
                        <td><?=$fila['codmoneda']?></td>                           
                        <td><?=number_format($fila['total'], 2)?></td>              
                        <td>

                            <!-- Button trigger modal -->
                            <a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?=$fila['id']?>">
                                <i class="far fa-eye"></i>
                            </a>

                            <a href="venta_modificado.php?id=<?=$fila['id']?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-pencil-alt"></i>
                            </a>

                            <a href="pdf_ticket.php?id=<?=$fila['id']?>" target="_blank" class="btn btn-secondary btn-sm">
                                <i class="far fa-file-alt"></i>
                            </a>

                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop<?=$fila['id']?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title" id="staticBackdropLabel">
                                                <i class="fas fa-shopping-cart text-success"></i>
                                                <span class="ms-1">Venta: <?=$fila['documento']?></span>
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            Detalle de Venta:  
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
                                                        $id = $fila['id'];
                                                        $query2 = "SELECT descripcion, cantidad, precio_unitario, importe_total FROM venta_detalle WHERE idventa = $id";
                                                        $select2 = mysqli_query($conexion, $query2);
                                                        $j = 0;
                                                        while ($fila2 = mysqli_fetch_array($select2)) {
                                                            $j++;
                                                    ?>
                                                        <tr>
                                                            <td><?=$j?></td>
                                                            <td><?=$fila2['descripcion']?></td>
                                                            <td><?=$fila2['cantidad']?></td>
                                                            <td class="text-end"><?=number_format($fila2['precio_unitario'], 2)?></td>
                                                            <td class="text-end"><?=number_format($fila2['importe_total'], 2)?></td>
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