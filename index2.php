<?php include ('config/conexion.php'); ?>
<?php include ('includes/header1.php'); ?>
<?php require_once ('index.php'); ?>

<!-- Sección de Scripts -->
<script>
    $(function(){
                            
    })
</script>

<?php include ('includes/header2.php'); ?>

<div class="container">
    <div class="row d-flex justify-content-evenly">

        <div class="card p-0" style="width: 19rem;">
            <img src="images/productos.jpg" class="card-img-top" alt="Productos">
            <div class="card-body p-4">
                <div class="row">
                    <h5 class="col card-title">PRODUCTOS Y SERVICIOS</h5>
                    <div class="col-auto fs-3 m-0">
                        <i class="fas fa-shopping-bag text-primary"></i>
                    </div>
                </div>
                <p class="card-text">Listado de todos los productos ingresados, acciones agregar, modificar y eliminar.</p>
                <a href="javascript:void(0)" onclick="AbrirRegistroProductos()" class="btn btn-primary">Listado ...</a>
            </div>
        </div>

        <div class="card p-0" style="width: 19rem;">
            <img src="images/personas.jpg" class="card-img-top" alt="Productos">
            <div class="card-body p-4">
                <div class="row">
                    <h5 class="col card-title">PERSONAS</h5>
                    <div class="col-auto fs-3 m-0">
                        <i class="fas fa-users text-danger"></i>
                    </div>
                </div>
                <p class="card-text">Listado de clientes, proveedores, personal de la empresa y registro de bancos.</p>
                <a href="personas.php" class="btn btn-danger">Listado ...</a>
            </div>
        </div>

        <div class="card p-0" style="width: 19rem;">
            <img src="images/ventas.jpg" class="card-img-top" alt="Productos">
            <div class="card-body p-4">
                <div class="row">
                    <h5 class="col card-title">VENTAS</h5>
                    <div class="col-auto fs-4 m-0">
                        <i class="fas fa-shopping-cart text-warning"></i>
                    </div>
                </div>
                <p class="card-text">Registro de todas las ventas: facturas, boletas y ventas internas. Incluye notas de crédito y débito.</p>
                <a href="ventas.php" class="btn btn-warning">Ventas</a>
                <a href="lista_precio.php" class="btn btn-warning">Lista precio</a>
            </div>
        </div>
    
        <div class="card p-0" style="width: 19rem;">
            <img src="images/almacen.jpg" class="card-img-top" alt="Productos">
            <div class="card-body p-4">
                <div class="row">
                    <h5 class="col card-title">ALMACENES</h5>
                    <div class="col-auto fs-4 m-0">
                        <i class="fas fa-warehouse text-info"></i>
                    </div>
                </div>
                <p class="card-text">Ingreso inicial valorizado de las existencias de los almacenes registrados.</p>
                <a href="inventario_inicial.php" class="btn btn-info">Inventario inicial</a>
                <a href="kardex.php" class="btn btn-info">Kárdex</a>
                <a href="saldos.php" class="btn btn-info mt-1">Saldos</a>
            </div>
        </div>

        <div class="card p-0" style="width: 19rem;">
            <img src="images/traslados.jpg" class="card-img-top" alt="Productos">
            <div class="card-body p-4">
                <div class="row">
                    <h5 class="col card-title">TRASLADOS</h5>
                    <div class="col-auto fs-4 m-0">
                        <i class="fas fa-warehouse text-info"></i>
                    </div>
                </div>
                <p class="card-text">Traslados entre los diferentes almacenes de nuestra empresa, respetando los stocks.</p>
                <a href="almacen_traslado.php" class="btn btn-info">Traslados</a>
            </div>
        </div>

        <div class="card p-0" style="width: 19rem;">
            <img src="images/compras.jpg" class="card-img-top" alt="Productos">
            <div class="card-body p-4">
                <div class="row">
                    <h5 class="col card-title">COMPRAS</h5>
                    <div class="col-auto fs-4 m-0">
                        <i class="fas fa-shopping-cart text-success"></i>
                    </div>
                </div>
                <p class="card-text">En este módulo, ingresamos todas las compras hechas por la empresa, facturas y boletas, esta acción carga el stock.</p>
                <a href="compras.php" class="btn btn-success">Compras</a>
            </div>
        </div>

    </div>
</div>

<!-- Sección de Scripts -->
<script>
    
</script>

<?php include ('includes/footer.php'); ?>