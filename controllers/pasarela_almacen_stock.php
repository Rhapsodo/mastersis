<?php 
include ('../config/conexion.php'); 

$proceso = $_POST['proceso'];


if ($proceso == 'Enviar'){
    $fila = $_POST['fila'];
    $idProducto = $_POST['idProducto'];
    $stock = $_POST['stock'];
    $cantidad = floatval($_POST['cantidad']);
    $precio = floatval($_POST['precio']);
    if ($cantidad > 0) {
        $query = "INSERT INTO pasarela_almacen_traslado (fila, idProducto, stock, cantidad, precio) VALUES ($fila, $idProducto, $stock, $cantidad, $precio)";
        $insert = mysqli_query($conexion, $query);
    } else {
        echo '<div class="container"><div class="alert alert-warning alert-dismissible fade show" role="alert">'.
        '<strong>Error de envío!</strong> producto con cantidad cero.'.
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'.
        '</div></div>';
    }

    if (mysqli_errno($conexion) == 1062) {
        echo '<div class="container"><div class="alert alert-warning alert-dismissible fade show" role="alert">'.
        '<strong>Duplicado!</strong> producto ya seleccionado.'.
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'.
        '</div></div>';
        }
        /* echo '<div class="row"><div class="col alert alert-danger alert-dismissible fade show p-1 mx-3" role="alert">'.
            '<strong class="row">Error de Base de datos: </strong>'.mysqli_errno($conexion).' '.mysqli_error($conexion).
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'.
            '</div></div>'; */
}

if($_POST['proceso'] == 'Borrar') {
    $idEliminar = $_POST['fila_borrado'];
    $query = "DELETE FROM pasarela_almacen_traslado WHERE fila = $idEliminar";
    $resultado = mysqli_query($conexion, $query);
    if(!$resultado) {
        die('Borrado fallido');
    }
}
?>

<!-- Buscador de artículos -->
<div class="row mt-2 mb-2">
        <div class="col">
            <span class="fw-bolder fs-6 p-0">Listado de artículos para traslado</span>
        </div>
    </div>

<div class="col">
    <table class="table table-sm table-striped" id="datatable2">
        <thead class="table-dark">
            <tr>
            <th scope="col">#</th>
            <th scope="col" width="450px">Producto</th>
            <th scope="col" width="150px">Unidad</th>
            <th scope="col" width="150px">Stock</th>
            <th scope="col" width="120px">Moneda</th>
            <th scope="col" width="300px">Precio</th>
            <th scope="col" width="100px" class="text-warning">Cantidad</th>
            <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM pasarela_almacen_traslado";
            $select = mysqli_query($conexion, $query);
            $i = 0;
            while ($fila = mysqli_fetch_array($select)) {
                $i++;
                $row = $fila['fila'];
                $idProducto = $fila['idProducto'];
                $stock = $fila['stock'];
                $cantidad = $fila['cantidad'];
                $precio = number_format($fila['precio'], 2);
                if ($cantidad > $stock) {
                    $color_tabla = 'class="table-warning"';
                } else {
                    $color_tabla = '';
                }  
                $mostrar_quitar = 'OK';
            ?>
            <tr <?=$color_tabla?>>
                <td>
                    <?=$i?>
                    <!-- Ocultos -->
                    <input type="hidden" class="hide_fila" value="<?=$row?>">
                    <input type="hidden" class="hide_idProducto" value="<?=$idProducto?>">
                    <input type="hidden" class="hide_stock" value="<?=$stock?>">
                    <?php
                        $query_producto = "SELECT nombre1, unidad FROM vista_productos WHERE idProducto=$idProducto";
                        $select_producto = mysqli_query($conexion, $query_producto);
                        $fila_producto = mysqli_fetch_array($select_producto);
                        $nombre1 = $fila_producto['nombre1'];
                        $unidad = $fila_producto['unidad'];
                    ?>
                </td>
                <td><?= $nombre1 ?></td>
                <td><?= $unidad ?></td>
                <td><?= $stock ?></td>
                <td>PEN</td>
                <td><?=$precio?></td>
                <td>
                    <input class="form-control form-control-sm txt_cantidad_traslado" type="number" placeholder="0" min="0" max="<?=$stock?>" value="<?=$cantidad?>">
                </td>
                
                <td>
                    <a class="btn btn-danger btn-sm btn-quitar">
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

        /* Enviar */
        $('.btn-quitar').on('click', function () {
            let fila = $(this).closest('tr');
            let fila_borrado = fila.find('.hide_fila').val();
            let data_enviar = {
                'fila_borrado' : fila_borrado,
                'proceso' : 'Borrar'
            };
            $.ajax({
                type    : 'POST',
                url     : 'controllers/pasarela_almacen_stock.php',
                data    : data_enviar,
                beforeSend: function(){
                    let carga = '<div class="text-center">Cargando ...'
                        +'<div class="spinner-border text-warning" style="width: 1.5rem; height: 1.5rem;" role="status">'
                        +'<span class="visually-hidden">Loading...</span>'
                        +'</div></div>';
                    $('#div_datatable2').html(carga);
                },
                success     : function(data){
                    $('#div_datatable2').html(data);
                }
            })
        });

    } );
</script>