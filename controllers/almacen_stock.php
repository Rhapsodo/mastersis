<?php include ('../config/conexion.php') ?>

<?php
$idAlmacen = $_POST['idAlmacen'];

if ($idAlmacen == 0) {
    echo '<h6>Seleccionar Almacén</h6>';
} else { ?>

<!-- Buscador de artículos -->
<div class="row my-2">
    <div class="col">
        <span class="fw-bolder fs-6 p-0">Buscador de artículos</span>
    </div>
</div>

<div class="col">
    <table class="table table-sm table-striped" id="datatable">
        <thead class="table-dark">
            <tr>
            <th scope="col">#</th>
            <th scope="col" width="450px">Producto</th>
            <th scope="col" width="150px">Unidad</th>
            <th scope="col" width="150px">Stock Mínimo</th>
            <th scope="col" width="150px">Stock</th>
            <th scope="col" width="120px">Moneda</th>
            <th scope="col" width="300px" class="text-warning">Precio</th>
            <th scope="col" width="100px" class="text-warning">Cantidad</th>
            <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            mysqli_query($conexion, "DELETE FROM pasarela_almacen_traslado");
            mysqli_query($conexion, "ALTER TABLE pasarela_almacen_traslado AUTO_INCREMENT = 1");
            $query = "SELECT * FROM vista_almacen_stock WHERE idAlmacen = $idAlmacen";
            $select = mysqli_query($conexion, $query);
            $i = 0;
            while ($fila = mysqli_fetch_array($select)) {
                $i++;
                $mostrar_enviar = 'OK';
                $idProducto = $fila['idProducto'];
                $nombre1 = $fila['nombre1'];
                $unidad = $fila['descripcion'];
                $stockMinimo = $fila['stockMinimo'];
                $stock = $fila['stock'];
                $moneda = $fila['codigoMonedas'];
                $precioUltimo = floatval($fila['precioUltimo']);
                $precioMinimo = floatval($fila['precioMinimo']);
                $precioMaximo = floatval($fila['precioMaximo']);
                $precioPromedio = floatval($fila['precioPromedio']);
                if ($stock <= $stockMinimo) {
                    $color_tabla = 'class="table-danger"';
                } else {
                    $color_tabla = '';
                }         
            ?>
            <tr <?=$color_tabla?>>
                <td>
                    <?=$i?>
                    <!-- Ocultos -->
                    <input type="hidden" class="hide_fila" value="<?=$i?>">
                    <input type="hidden" class="hide_idProducto" value="<?=$idProducto?>">
                    <input type="hidden" class="hide_stock" value="<?=$stock?>">
                </td>
                <td><?= $nombre1 ?></td>
                <td><?= $unidad ?></td>
                <td><?= $stockMinimo ?></td>
                <td><?= $stock ?></td>
                <td><?= $moneda ?></td>
                <td>
                    <select class="form-select form-select-sm comb_precio">
                        <option selected value="<?=$precioUltimo?>">Último: <?=number_format($precioUltimo,2)?></option>
                        <option value="<?=$precioMinimo?>">Mínimo: <?=number_format($precioMinimo,2)?></option>
                        <option value="<?=$precioMaximo?>">Máximo: <?=number_format($precioMaximo,2)?></option>
                        <option value="<?=$precioPromedio?>">Promedio: <?=number_format($precioPromedio,2)?></option>
                    </select>
                </td>
                <td>
                    <input class="form-control form-control-sm txt_cantidad" type="number" placeholder="0" min="0">
                </td>
                
                <td>
                    <a class="btn btn-info btn-sm btn-enviar <?=$mostrar_enviar?>" id="envio_<?=$i?>">
                        <i class="fas fa-paper-plane"></i>
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Datatable2 -->
    <div class="row mt-2" id="div_datatable2"></div>
</div>

<!-- Sección de Scripts -->
<script>
    $(document).ready( function () {
        $('#datatable').DataTable( {
            "responsive": 'true',
            "pagingType": 'full_numbers',
            "language": {
                "url": "modules/datatables/Spanish.json"
            }
        } );

        /* Enviar */
        $('.btn-enviar').on('click', function () {
            let fila = $(this).closest('tr');
            let row = fila.find('.hide_fila').val();
            let idProducto = fila.find('.hide_idProducto').val();
            let stock = fila.find('.hide_stock').val();
            let cantidad = fila.find('.txt_cantidad').val();
            if (cantidad > stock) {
                alertify.alert("Advertencia esta enviando una cantidad mayor a la del stock");
            }
            let precio = fila.find('.comb_precio').val();
            let data_enviar = {
                'fila' : row,
                'idProducto' : idProducto,
                'stock' : stock,
                'cantidad' : cantidad,
                'precio' : precio,
                'proceso' : 'Enviar'
            };
            //alert(data_enviar['fila']);
            $.ajax({
                type: 'POST',
                url: 'controllers/pasarela_almacen_stock.php',
                data: data_enviar,
                beforeSend : function(){
                    let carga = '<div class="text-center">Cargando ...'
                        +'<div class="spinner-border text-warning" style="width: 1.5rem; height: 1.5rem;" role="status">'
                        +'<span class="visually-hidden">Loading...</span>'
                        +'</div></div>';
                    $('#div_datatable2').html(carga);
                },
                success : function(data){
                    $('#div_datatable2').html(data);
                }
            })
        });

    } );
</script>

<?php } ?>
