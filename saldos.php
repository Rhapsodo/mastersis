<?php include ('config/conexion.php'); ?>
<?php include ('includes/header1.php'); ?>
<?php include ('includes/datatables.php'); ?>
<!-- Sección de Scripts -->
<script type="text/javascript" src="js/saldos.js"></script>

<?php include ('includes/header2.php'); ?>

<!-- Cuerpo formulario -->
<div class="container-fluid border rounded pb-1 bg-dark text-white">
    <div class="row">

        <div class="col-auto fw-bolder fs-1">
            <i class="fas fa-warehouse text-info"></i>
        </div>

        <div class="col-auto me-auto">
            <div class="row">
                <span class="fw-bolder fs-4 p-0">Saldos</span>
            </div>
            <nav class="row" aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a class="sin-linea link-warning" href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item"><a class="sin-linea link-warning" href="inventario.php">Inventario</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Saldos</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<!-- Cuerpo del contenido -->
<form class="container-fluid bg-white border rounded mt-3" action="" id="form_invini">
    <div class="col my-3">
        <table class="table table-sm table-striped" id="datatable">
            <thead class="table-dark">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Producto</th>
                <th scope="col">Und.</th>
                <th scope="col">Almacén</th>
                <th scope="col">St. Min.</th>
                <th scope="col">Stock</th>
                <th scope="col">Moneda</th>
                <th scope="col">Precio Ult.</th>
                <th scope="col">Total</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $query = "SELECT s.nombre1, s.unidad, a.nombre, s.stockMinimo, s.stock, s.codigoMonedas, s.precioUltimo FROM vista_almacen_stock s, almacenes a WHERE s.idAlmacen = a.idAlmacen ORDER BY s.nombre1 ASC";
                $select = mysqli_query($conexion, $query);
                $i = 0;
                while ($fila = mysqli_fetch_array($select)) {
                    $i++;
                    if (isset($fila)) {
                        $producto = $fila['nombre1'];
                        $unidad = $fila['unidad'];
                        $almacen = $fila['nombre'];
                        $stockMinimo = $fila['stockMinimo'];
                        $stock = $fila['stock'];
                        $moneda = $fila['codigoMonedas'];
                        $precio = $fila['precioUltimo'];
                        $total = round($stock*$precio,2);
                    }                
                ?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=$producto?></td>
                    <td><?=$unidad?></td>
                    <td><?=$almacen?></td>
                    <?php
                        if ($stock >= $stockMinimo) {
                            $color_texto = "text-primary";
                        } else {
                            $color_texto = "text-danger";
                        }
                    ?>
                    <td class="text-end"><?=$stockMinimo?></td>
                    <td class="text-end <?=$color_texto?>"><?=$stock?></td>
                    <td><?=$moneda?></td>
                    <td class="text-end"><?=number_format($precio, 2)?></td>
                    <td class="text-end"><?=number_format($total, 2)?></td>
                </tr>
                <?php } ?>
            </tbody>

            <tfoot class="table-dark">
                <tr>
                    <th colspan="2" style="text-align:left">Total:</th>
                    <th colspan="7" style="text-align:right"></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- Datatable -->
    
</form>


<!-- Sección de Scripts -->

<script>
$(document).ready( function () {
    $('#datatable').DataTable( {
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            
            function addCommas(nStr) {
                nStr += '';
                var x = nStr.split('.');
                var x1 = x[0];
                var x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                        x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2;
            }
 
            // Update footer
            $( api.column( 8 ).footer() ).html(
                'S/ '+ addCommas(pageTotal.toFixed(2)) +' ( S/ '+ addCommas(total.toFixed(2)) +' Total )'
            );
        },
        "pagingType": 'full_numbers',
        "lengthMenu": [
            [ 10, 25, 50, -1 ],
            [ '10', '25', '50', 'Todos' ]
        ],
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