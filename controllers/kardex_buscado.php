<?php include ('../config/conexion.php') ?>

<?php
$idProducto = $_POST['idProducto'];
$idAlmacen = $_POST['idAlmacen'];
?>

<div class="col">
    <table class="table table-sm table-striped" id="datatable">
        <thead class="table-dark">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Fecha</th>
            <th scope="col">Transacción</th>
            <th scope="col">Documento</th>
            <th scope="col">Cliente / Proveedor</th>
            <th scope="col">Cant.</th>
            <th scope="col">Precio</th>
            <th scope="col">Total</th>
            
            </tr>
        </thead>

        <tbody>
            <?php
            $query = "SELECT fecha, documentoReferencia, numeroTransaccion, observacion, cantidad, precio FROM almacen_movimientos WHERE idProducto = $idProducto AND idAlmacen = $idAlmacen ORDER BY fecha ASC";
            $select = mysqli_query($conexion, $query);
            $i = 0;
            while ($fila = mysqli_fetch_array($select)) {
                $i++;
                if (isset($fila)) {
                    $fecha = date('d-m-Y', strtotime($fila['fecha']));
                    $documentoReferencia = $fila['documentoReferencia'];
                    $numeroTransaccion = $fila['numeroTransaccion'];
                    $observacion = $fila['observacion'];
                    $cantidad = $fila['cantidad'];
                    $precio = $fila['precio'];
                }                
            ?>
            <tr>
                <td><?=$i?></td>
                <td><?=$fecha?></td>
                <td><?=$documentoReferencia?></td>
                <td><?=$numeroTransaccion?></td>
                <td><?=$observacion?></td>
                <?php
                    if ($cantidad >= 0) {
                        $color_texto = "text-primary";
                    } else {
                        $color_texto = "text-danger";
                    }
                ?>
                <td class="<?=$color_texto?>"><?=$cantidad?></td>
                <td class="text-end <?=$color_texto?>"><?=number_format($precio, 2)?></td>
                <td class="text-end <?=$color_texto?>"><?=number_format($cantidad*$precio, 2)?></td>
            </tr>
            <?php } ?>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="5" class="table-dark fw-bolder fs-6">Total:</td>
                <?php
                    $query = "SELECT sum(cantidad) as total, sum(cantidad*precio) as precio_total FROM almacen_movimientos WHERE idProducto = $idProducto AND idAlmacen = $idAlmacen";
                    $select = mysqli_query($conexion, $query);
                    $fila = mysqli_fetch_array($select);
                    if ($fila['total'] >= 0) {
                        $color_texto = "text-primary";
                    } else {
                        $color_texto = "text-danger";
                    }
                ?>
                <td class="table-dark text-end fw-bolder <?=$color_texto?>" id="compra_total">
                    <?=$fila['total'];?>
                </td>
                <td colspan="2" class="table-dark text-end fw-bolder <?=$color_texto?>"><?=number_format($fila['precio_total'], 2)?></td>
            </tr>
        </tfoot>
    </table>
</div>

<!-- Sección de Scripts -->
<script>
</script>


