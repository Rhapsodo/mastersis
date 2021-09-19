<?php include ('../config/conexion.php') ?>

<?php
$idPrecioLista = $_POST['idPrecioLista'];

if ($idPrecioLista == 0) {
    echo '<h6>Seleccionar lista de precios</h6>';
} else { ?>

<div class="col">
    <table class="table table-sm table-striped" id="datatable">
        <thead class="table-dark">
            <tr>
            <th scope="col" width="50px">#</th>
            <th scope="col">Producto</th>
            <th scope="col" width="120px">Unidad</th>
            <th scope="col" width="120px">Moneda</th>
            <th scope="col" width="150px" class="text-warning">Precio</th>
            <th scope="col" width="100px">Acciones</th>
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
                $mostrar_modificar_eliminar='OK';
                $idProducto = $fila_producto['idProducto'];
                $query_existencias = "SELECT * FROM precio_venta WHERE idProducto = $idProducto AND idPrecioLista = $idPrecioLista";
                $select_existencias = mysqli_query($conexion, $query_existencias);
                $fila_existencia = mysqli_fetch_array($select_existencias);
                if (isset($fila_existencia)) {
                    $idPrecioVenta = $fila_existencia['idPrecioVenta'];
                    $codigoMonedas = $fila_existencia['codigoMonedas'];
                    $precio = $fila_existencia['precio'];
                    $mostrar_guardar = 'd-none';
                } else {
                    $idPrecioVenta = '0';
                    $codigoMonedas = 'PEN';
                    $precio = '0';
                    $mostrar_modificar_eliminar = 'd-none';
                }
                
            ?>
            <tr>
                <td>
                    <?= $i ?>
                    <!-- Ocultos -->
                    <input type="hidden" class="hide_idPrecioVenta" value="<?=$idPrecioVenta?>">
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
                    <input class="form-control form-control-sm txt_precio" type="number" placeholder="0.00" value="<?=$precio?>">
                </td>
                
                <td>
                    <a class="btn btn-success btn-sm btn-guardar <?=$mostrar_guardar?>">
                        <i class="fas fa-save"></i>
                    </a>
                    <a class="btn btn-warning btn-sm btn-modificar <?=$mostrar_modificar_eliminar?>">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a class="btn btn-danger btn-sm btn-eliminar <?=$mostrar_modificar_eliminar?>">
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
            let idPrecioVenta = fila.find('.hide_idPrecioVenta').val();
            let idPrecioLista = $('#comb_lista_precio').val();
            let idProducto = fila.find('.hide_idProducto').val();
            let codigoMonedas = fila.find('.comb_moneda').val();
            let precio = fila.find('.txt_precio').val();
            let data_enviar = {
                idPrecioVenta,idPrecioLista, idProducto, codigoMonedas, precio,
                'proceso' : 'Guardar'
            };
            $.ajax({
                type: 'POST',
                url: 'controllers/CRUD_lista_precio.php',
                data: data_enviar,
                success: function (response) {
                    alertify.success("Se guardó el registro");
                    fila.find('.btn-guardar').addClass('d-none');
                    fila.find('.btn-modificar').removeClass('d-none');
                    fila.find('.btn-eliminar').removeClass('d-none');
                    fila.find('.hide_idPrecioVenta').val(response);
                }
            });
        });

        /* Modificar */
        $('.btn-modificar').on('click', function () {
            let fila = $(this).closest('tr');
            let idPrecioVenta = fila.find('.hide_idPrecioVenta').val();
            let idPrecioLista = $('#comb_lista_precio').val();
            let idProducto = fila.find('.hide_idProducto').val();
            let codigoMonedas = fila.find('.comb_moneda').val();
            let precio = fila.find('.txt_precio').val();
            let data_enviar = {
                idPrecioVenta, idPrecioLista, idProducto, codigoMonedas, precio,
                'proceso' : 'Modificar'
            };
            //alert(Object.values(data_enviar));
            $.ajax({
                type: 'POST',
                url: 'controllers/CRUD_lista_precio.php',
                data: data_enviar,
                success: function (response) {
                    alertify.success("Se modificó el registro");
                }
            });
        });

        /* Eliminar */
        $('.btn-eliminar').on('click', function () {
            let fila = $(this).closest('tr');
            let idPrecioVenta = fila.find('.hide_idPrecioVenta').val();
            let data_enviar = {
                idPrecioVenta,
                'proceso' : 'Eliminar'
            };
            $.ajax({
                type: 'POST',
                url: 'controllers/CRUD_lista_precio.php',
                data: data_enviar,
                success: function (response) {
                    alertify.error("Se eliminó el registro");
                    fila.find('.comb_moneda').val('PEN');
                    fila.find('.txt_precio').val('');
                    fila.find('.btn-guardar').removeClass('d-none');
                    fila.find('.btn-modificar').addClass('d-none');
                    fila.find('.btn-eliminar').addClass('d-none');
                }
            });
        });

    } );
</script>

<?php } ?>
