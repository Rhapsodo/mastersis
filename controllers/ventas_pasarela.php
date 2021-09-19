<?php
    
include ('../config/conexion.php');

$accion = $_POST['accion'];

if ($accion == 'agregar_producto_pasarela') {
    $idProducto = $_POST['idProducto'];
    
    $query = "SELECT p.idProducto, p.nombre1, u.unidad, (SELECT precio FROM precio_venta WHERE idProducto = p.idProducto AND idPrecioLista = 1 AND codigoMonedas = 'PEN') AS precioventa
    FROM productos p, unidad u WHERE p.idUnidad = u.idUnidad AND p.idProducto = $idProducto";
    $select = mysqli_query($conexion, $query);
    $fila = mysqli_fetch_array($select);
    $precioUltimo = $fila['precioventa'];
    $nombre = $fila['nombre1'];

    if (!$precioUltimo) {
        $precioUltimo = 0;
    }
    $query = "INSERT INTO pasarela_venta (
        idProducto,
        nombre,
        cantidad,
        precio,
        descuentoPorcentaje,
        descuentoValor
    ) VALUES (
        $idProducto,
        '$nombre',
        1,
        $precioUltimo,
        0, 0
    )";
    $insert = mysqli_query($conexion, $query);
}

if ($accion == 'modificar_producto_pasarela') {
    $idProducto = $_POST['idProducto'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $descuentoPorcentaje = $_POST['descuentoPorcentaje'];
    $descuentoValor = $_POST['descuentoValor'];
    /* $lote = strtoupper($_POST['lote']);
    $vencimiento = $_POST['vencimiento']; */
    $lote = "";
    $vencimiento = "";
    $query = "UPDATE pasarela_venta SET cantidad = $cantidad, precio = $precio, descuentoPorcentaje = $descuentoPorcentaje, descuentoValor = $descuentoValor, lote = '$lote', vencimiento = '$vencimiento' WHERE idProducto = $idProducto";
    $update = mysqli_query($conexion, $query);
}

if ($accion == 'quitar_producto_pasarela') {
    $idProducto = $_POST['idProducto'];
    $query = "DELETE FROM pasarela_venta WHERE idProducto = $idProducto";
    $update = mysqli_query($conexion, $query);
}

?>

<div class="col">
    <table class="table table-sm table-striped" id="datatable">
        <thead class="table-dark">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Producto</th>
            <th scope="col" width="120px">Cantidad</th>
            <th scope="col" width="150px">Precio</th>
            <th scope="col" width="100px">Desc. Porcentual</th>
            <th scope="col" width="100px">Desc. Valor</th>
            <th scope="col" width="100px">Total</th>
            <!-- <th scope="col" width="100px">Lote</th>
            <th scope="col" width="50px">F. Venc.</th> -->
            <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $query_pasarela = "SELECT * FROM pasarela_venta ORDER BY nombre";
            $select_pasarela = mysqli_query($conexion, $query_pasarela);
            $total = 0;
            while ($fila_pasarela = mysqli_fetch_array($select_pasarela)) {
                $idProductoPasarela = $fila_pasarela['idProducto'];
                $cantidad = $fila_pasarela['cantidad'];
                $precio = $fila_pasarela['precio'];
                $descuentoPorcentaje = $fila_pasarela['descuentoPorcentaje'];
                $descuentoValor = $fila_pasarela['descuentoValor'];
                $nombre = $fila_pasarela['nombre'];
                $total += ($cantidad * $precio) * (1 - $descuentoPorcentaje/100) - $descuentoValor;
                $lote = $fila_pasarela['lote'];
                $vencimiento = $fila_pasarela['vencimiento'];
            ?>
            <tr>
                <td>
                    <?= $i ?>
                    <!-- Ocultos -->
                    <input type="hidden" class="hide_idProducto" value="<?=$idProductoPasarela?>">
                </td>
                <td class="cell_nombre"><?=$nombre?></td>
                <td>
                    <input class="form-control form-control-sm txt_cantidad" min="1" type="number" value="<?=$cantidad?>">
                </td>
                <td>
                    <input class="form-control form-control-sm txt_precio" type="number" value="<?=number_format($precio,2)?>">
                </td>
                <td>
                    <input class="form-control form-control-sm txt_descuentoPorcentaje" min="0" max="100" type="number" value="<?=$descuentoPorcentaje?>">
                </td>
                <td>
                    <input class="form-control form-control-sm txt_descuentoValor" min="0" max="<?=($cantidad * $precio) * (1 - $descuentoPorcentaje/100)?>" type="number" value="<?=$descuentoValor?>">
                </td>

                <td class="text-end">
                    <?= number_format(($cantidad * $precio) * (1 - $descuentoPorcentaje/100) - $descuentoValor, 2) ?>
                </td>
                <!-- <td>
                    <input class="form-control form-control-sm txt_lote" type="text" value="<?=$lote?>">
                </td>
                <td>
                    <input class="form-control form-control-sm txt_vencimiento" type="date" value="<?=$vencimiento?>">
                </td> -->
                
                <td>
                    <a class="btn btn-warning btn-sm btn-modificar d-none">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a class="btn btn-danger btn-sm btn-quitar">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
            <?php $i++; } ?>
        </tbody>
        <tfoot>
            <tr>
                <input type="hidden" id="hide_total" value="<?=$total?>">
                <td colspan="6" class="table-dark fw-bold">Total: </td><!-- colspan="8" -->
                <td class="table-light fw-bolder fs-6">Sub total:</td>
                <td class="table-light text-end" id="compra_subtotal">
                    <?=number_format(round($total/1.18, 2), 2)?>
                </td>
            </tr>

            <tr>
                <td colspan="2"></td>
                <td colspan="4"><!-- colspan="6" -->
                    <div class="row-sm input-group input-group-sm">
                        <span class="input-group-text bg-warning">Impuesto:</span>
                        <select class="form-select form-select-sm" name="comb_impuesto" id="comb_impuesto">
                            <option value="Incluido" selected>INCLUIDO IGV</option>
                            <option value="Añadido">IGV AÑADIDO</option>
                        </select>
                    </div>
                </td>
                <td class="fw-bolder fs-6">IGV (18%):</td>
                <td class="text-end" id="compra_igv">
                    <?=number_format(round($total/1.18*0.18, 2), 2)?>
                </td>
            </tr>

            <tr>
                <td colspan="2" class="table-light"></td>
                <td colspan="4" class="table-light"><!-- colspan="6" -->
                    <div class="row-sm input-group input-group-sm">
                        <span class="input-group-text bg-warning" id="v8">Almacén:</span>
                        <select class="form-select form-select-sm" name="comb_almacen" id="comb_almacen">
                            <!-- <option value="0" selected>Elegir Almacén</option> -->
                            <?php
                                $query = "SELECT idAlmacen, nombre, abreviatura FROM almacenes";
                                $select = mysqli_query($conexion, $query);
                                while ($fila = mysqli_fetch_array($select)) {
                                    $idAlmacen = $fila['idAlmacen'];
                                    if ($idAlmacen == 3) {
                                        $nombre = $fila['nombre'];
                                        $abreviatura = $fila['abreviatura'];
                                        echo "<option value='$idAlmacen' selected>$abreviatura - $nombre</option>";
                                    } else {
                                        $nombre = $fila['nombre'];
                                        $abreviatura = $fila['abreviatura'];
                                        echo "<option value='$idAlmacen'>$abreviatura - $nombre</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </td>
                <td class="table-light fw-bolder fs-6">Total:</td>
                <td class="table-light text-end fw-bolder" id="compra_total">
                    <?=number_format($total, 2)?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

<script>

function hacerMoneda(amount, decimals) {
    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto
    decimals = decimals || 2; // por si la variable no fue fue pasada
    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);
    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);
    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;
    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');
    return amount_parts.join('.');
}

$('.txt_cantidad').on('change', function() {
    let fila = $(this).closest('tr');
    //alert('estas en la fila ' + fila);
    fila.find('.btn-modificar').click();
});

$('.txt_precio').on('change', function() {
    let fila = $(this).closest('tr');
    //alert('estas en la fila ' + fila);
    fila.find('.btn-modificar').click();
});

$('.txt_descuentoPorcentaje').on('change', function() {
    let fila = $(this).closest('tr');
    //alert('estas en la fila ' + fila);
    fila.find('.btn-modificar').click();
});

$('.txt_descuentoValor').on('change', function() {
    let fila = $(this).closest('tr');
    //alert('estas en la fila ' + fila);
    fila.find('.btn-modificar').click();
});

$('.btn-modificar').on('click', function() {
    let fila = $(this).closest('tr');
    let idProducto = fila.find('.hide_idProducto').val();
    let cantidad = parseFloat(fila.find('.txt_cantidad').val());
    let precio = parseFloat(fila.find('.txt_precio').val());
    let lote = fila.find('.txt_lote').val();
    let vencimiento = fila.find('.txt_vencimiento').val();
    let descuentoPorcentaje = parseFloat(fila.find('.txt_descuentoPorcentaje').val());
    let descuentoValor = parseFloat(fila.find('.txt_descuentoValor').val());
    
    if(cantidad <= 0) {
        alertify.alert("Debe ingresar una cantidad válida");
        return false;
    }
    /* if(precio < 0) {
        alertify.alert("Debe ingresar un precio válido");
        return false;
    } */
    if(descuentoPorcentaje < 0 || descuentoValor < 0) {
        alertify.alert("Los descuentos no deben ser negativos");
        return false;
    }
    if(descuentoPorcentaje > 100) {
        alertify.alert("El descuento porcentual no debe exceder del 100%");
        return false;
    }
    if(descuentoValor > (cantidad*precio)*(1 - descuentoPorcentaje/100) && (precio>0)) {
        alertify.alert("El descuento por valor no puede exceder el total");
        return false;
    }

    let data = {
        idProducto,
        cantidad,
        precio,
        descuentoPorcentaje,
        descuentoValor,
        lote, 
        vencimiento,
        'accion' : 'modificar_producto_pasarela' 
    }

    $.ajax({
        type: "POST",
        url: "controllers/ventas_pasarela.php",
        data: data,
        success: function (response) {
            $('#div_datatable').html(response);
        }
    });
});

$('.btn-quitar').on('click', function() {
    let fila = $(this).closest('tr');
    let idProducto = fila.find('.hide_idProducto').val();
    let data = {
        idProducto,
        'accion' : 'quitar_producto_pasarela'
    }

    $.ajax({
        type: "POST",
        url: "controllers/ventas_pasarela.php",
        data: data,
        success: function (response) {
            $('#div_datatable').html(response);
        }
    });
});

$('#comb_impuesto').on('change', function() {
    /* const moneda = new Intl.NumberFormat('es-PE', {
        style: 'currency',
        currency: 'PEN',
        minimumFractionDigits: 2
    }) */
    let impuesto = $('#comb_impuesto').val();
    let totalCambiante = $('#hide_total').val();
    if (impuesto == 'Incluido') {
        $('#compra_subtotal').html(hacerMoneda(totalCambiante/1.18));
        $('#compra_igv').html(hacerMoneda(totalCambiante/1.18*0.18));
        $('#compra_total').html(hacerMoneda(totalCambiante));
    } else {
        $('#compra_subtotal').html(hacerMoneda(totalCambiante));
        $('#compra_igv').html(hacerMoneda(totalCambiante*0.18));
        $('#compra_total').html(hacerMoneda(totalCambiante*1.18));
    }
});

</script>
