<?php include ('../config/conexion.php') ?>

<?php
$idAlmacen = $_POST['idAlmacen'];

if ($idAlmacen == 0) {
    echo '<h6>Seleccionar Almacén</h6>';
} else { ?>

<div class="col">
    <table class="table table-sm table-striped" id="datatable">
        <thead class="table-dark">
            <tr>
            <th scope="col">#</th>
            <th scope="col" width="300px">Producto</th>
            <th scope="col" width="120px">Unidad</th>
            <th scope="col" width="150px">Moneda</th>
            <th scope="col" width="100px" class="text-warning">Cant.</th>
            <th scope="col" width="100px" class="text-warning">Precio</th>
            <th scope="col" width="100px">Total</th>
            <th scope="col" width="150px">Lote</th>
            <th scope="col" width="50px">Vencimiento</th>
            <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query_producto = "SELECT p.idProducto, p.nombre1, p.idUnidad, u.descripcion FROM productos p, unidad u WHERE p.idUnidad = u.idUnidad AND estado != 'ELIMINADO' ORDER BY p.idProducto";
            $select_producto = mysqli_query($conexion, $query_producto);
            $i = 0;
            while ($fila_producto = mysqli_fetch_array($select_producto)) {
                $i++;
                $mostrar_guardar='OK';
                $mostrar_modificar='OK';
                $idProducto = $fila_producto['idProducto'];
                $query_existencias = "SELECT * FROM almacen_movimientos WHERE idProducto = $idProducto AND idAlmacen = $idAlmacen AND idAlmacenTransacciones = 1 AND numeroTransaccion = 0";
                $select_existencias = mysqli_query($conexion, $query_existencias);
                $fila_existencia = mysqli_fetch_array($select_existencias);
                if (isset($fila_existencia)) {
                    $idAlmMov = $fila_existencia['idAlmacenMovimientos'];
                    $cantidad = $fila_existencia['cantidad'];
                    $precio = $fila_existencia['precio'];
                    $lote = $fila_existencia['lote'];
                    $vencimiento = $fila_existencia['vencimiento'];
                    $total = number_format($cantidad * $precio, 2);
                    $codigoMonedas = $fila_existencia['codigoMonedas'];
                    $mostrar_guardar = 'd-none';
                } else {
                    $idAlmMov = '';
                    $cantidad = '';
                    $precio = '';
                    $lote = '';
                    $vencimiento = '';
                    $total = '';
                    $codigoMonedas = 'PEN';
                    $mostrar_modificar = 'd-none';
                }
                
            ?>
            <tr>
                <td>
                    <?= $i ?>
                    <!-- Ocultos -->
                    <input type="hidden" class="hide_idAlmacen" value="<?=$idAlmMov?>">
                    <input type="hidden" class="hide_idProducto" value="<?=$idProducto?>">
                </td>
                <td><?= $fila_producto['nombre1'] ?></td>
                <td><?= $fila_producto['descripcion'] ?></td>

                <td>
                    <select class="form-select form-select-sm comb_moneda">
                        <?php
                            $query = "SELECT * FROM monedas";
                            $select = mysqli_query($conexion, $query);
                            while ($fila = mysqli_fetch_array($select)) {
                                $codeMonedas = $fila['codigoMonedas'];
                                $descripcion = $fila['descripcion'];
                                if ($codeMonedas == $codigoMonedas) {
                                    echo "<option selected value='$codeMonedas'>$codeMonedas - $descripcion</option>";
                                } else {
                                    echo "<option value='$codeMonedas'>$codeMonedas - $descripcion</option>";
                                }
                            }
                        ?>
                    </select>
                </td>
                
                <td>
                    <input class="form-control form-control-sm txt_cantidad" type="number" placeholder="0" value="<?=$cantidad?>">
                </td>

                <td>
                    <input class="form-control form-control-sm txt_precio" type="number" placeholder="0.00" value="<?=$precio?>">
                </td>

                <td class="text-end txt_total"><?=$total?></td>

                <td>
                    <input class="form-control form-control-sm mayusculas txt_lote" type="text" value="<?=$lote?>">
                </td>
                <td>
                    <input class="form-control form-control-sm txt_vencimiento" type="date" value="<?=$vencimiento?>">
                </td>
                
                <td>
                    <a class="btn btn-success btn-sm btn-guardar <?=$mostrar_guardar?>">
                        <i class="fas fa-save"></i>
                    </a>
                    <a class="btn btn-warning btn-sm btn-modificar <?=$mostrar_modificar?>">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a class="btn btn-danger btn-sm btn-eliminar <?=$mostrar_modificar?>">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Sección de Scripts -->
<script>
    $(document).ready( function () {
        $('#datatable').DataTable( {
            "pagingType": 'full_numbers',
            "language": {
                "url": "modules/datatables/Spanish.json"
            }
        } );

        /* Guardar */
        $('.btn-guardar').on('click', function () {
            let fila = $(this).closest('tr');
            let id = fila.find('.hide_idProducto').val();
            let idAlmacen = $('#comb_almacen').val();
            let fecha = $('#txt_fecha_inventario').val();
            let codigoMonedas = fila.find('.comb_moneda').val();
            let cantidad = fila.find('.txt_cantidad').val();
            let precio = fila.find('.txt_precio').val();
            let lote = fila.find('.txt_lote').val();
            let vencimiento = fila.find('.txt_vencimiento').val();
            let data_enviar = {
                'idGuardar' : id,
                'idAlmacen' : idAlmacen,
                'fecha' : fecha,
                'codigoMonedas' : codigoMonedas,
                'cantidad' : cantidad,
                'precio' : precio,
                'lote' : lote,
                'vencimiento' : vencimiento,
                'proceso' : 'Guardar'
            };
            $.ajax({
                type: 'POST',
                url: 'controllers/CRUD_inventario_inicial.php',
                data: data_enviar,
                success: function (response) {
                    alertify.success("Se guardó el registro");
                    fila.find('.txt_total').html(precio*cantidad);
                    fila.find('.btn-guardar').addClass('d-none');
                    fila.find('.btn-modificar').removeClass('d-none');
                    fila.find('.btn-eliminar').removeClass('d-none');
                }
            });
        });

        /* Modificar */
        $('.btn-modificar').on('click', function () {
            let fila = $(this).closest('tr');
            let id = fila.find('.hide_idAlmacen').val();
            let idAlmacen = $('#comb_almacen').val();
            let codigoMonedas = fila.find('.comb_moneda').val();
            let cantidad = fila.find('.txt_cantidad').val();
            let precio = fila.find('.txt_precio').val();
            let lote = fila.find('.txt_lote').val();
            let vencimiento = fila.find('.txt_vencimiento').val();
            let data_enviar = {
                'idModificar' : id,
                'idAlmacen' : idAlmacen,
                'codigoMonedas' : codigoMonedas,
                'cantidad' : cantidad,
                'precio' : precio,
                'lote' : lote,
                'vencimiento' : vencimiento,
                'proceso' : 'Modificar'
            };
            $.ajax({
                type: 'POST',
                url: 'controllers/CRUD_inventario_inicial.php',
                data: data_enviar,
                success: function (response) {
                    alertify.success("Se modificó el registro");
                    fila.find('.txt_total').html(precio*cantidad);
                }
            });
        });

        /* Eliminar */
        $('.btn-eliminar').on('click', function () {
            let fila = $(this).closest('tr');
            let id = fila.find('.hide_idAlmacen').val();
            let data_enviar = {
                'idEliminar' : id,
                'proceso' : 'Eliminar'
            };
            $.ajax({
                type: 'POST',
                url: 'controllers/CRUD_inventario_inicial.php',
                data: data_enviar,
                success: function (response) {
                    alertify.error("Se eliminó el registro");
                    fila.find('.comb_moneda').val('PEN');
                    fila.find('.txt_cantidad').val('');
                    fila.find('.txt_precio').val('');
                    fila.find('.txt_total').html('');
                    fila.find('.txt_lote').val('');
                    fila.find('.txt_vencimiento').val('');
                    fila.find('.btn-guardar').removeClass('d-none');
                    fila.find('.btn-modificar').addClass('d-none');
                    fila.find('.btn-eliminar').addClass('d-none');
                }
            });
        });

    } );
</script>

<?php } ?>
