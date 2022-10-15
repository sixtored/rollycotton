<?php

$id_compra = uniqid();

?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">


            <form method="POST" id="form_compra" name="form_compra" action="<?php echo base_url(); ?>/compras/guarda" autocomplete="off">

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <input type="hidden" id="id_producto" name="id_producto" />
                            <input type="hidden" id="id_compra" name="id_compra" value="<?php echo $id_compra ; ?>"/>
                            <label>Codigo</label>
                            <input class="form-control" id="codigo" name="codigo" type="text" placeholder="Escribe el codigo y presione Enter" onkeyup="buscarProducto(event, this, this.value)" autofocus />
                            <label for="codigo" id="resultado_error" style="color: red"> </label>
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>Descripcion</label>
                            <input class="form-control" id="nombre" name="nombre" type="text" disabled />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>Cantidad</label>
                            <input class="form-control" id="cantidad" name="cantidad" type="text" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label>Costo</label>
                            <input class="form-control" id="costo" name="costo" type="text" />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label>Subtotal</label>
                            <input class="form-control" id="subtotal" name="subtotal" type="text" disabled />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label><br>&nbsp;</label>
                            <button id="agregar_producto" name="agregar_producto" class="btn btn-primary" type="button" onclick="AgregarProducto(id_producto.value, cantidad.value, '<?= $id_compra ?>')">Agregar producto</button>
                        </div>
                    </div>
                </div>
                <p></p>
                <div class="row">
                    <table id="tablaproductos" class="table table-dark table-hover table-striped table-sm table-responsive tablaproductos" width="10%">
                        <thead class="thead-dark">
                            <th>#</th>
                            <th>codigo</th>
                            <th>Descripcion</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Total</th>
                            <th width="5%"></th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 offset-md-6">
                        <label style="font-weight: bold; font-size: 30px; text-align: center;">Total $</label>
                        <input type="text" id="total" name="total" size="7" readonly="true" value="0.00" style="font-weight: bold; font-size: 30px; text-align: center;" />
                        <button type="button" id="completa_compra" class="btn btn-success">Completar compra</button>
                    </div>
                </div>
            </form>

        </div>
    </main>

    <script src="<?php echo base_url(); ?>/js/jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#completa_compra').click(function(){
                let nFila = $('#tablaproductos tr').length ;

                if (nFila < 2) {

                } else {
                    $('#form_compra').submit() ;

                }
            });
        });

        function buscarProducto(e, tagcodigo, codigo) {

            var enterkey = 13;
            if (codigo != '') {
                if (e.which == enterkey) {
                    $.ajax({
                        url: '<?php echo base_url(); ?>/productos/buscarporcodigo/' + codigo,
                        dataType: 'json',
                        success: function(resultado) {
                            if (resultado == 0) {
                                $(tagcodigo).val('');
                            } else {
                                $(tagcodigo).removeClass('has-error');
                                $("#resultado_error").html(resultado.error);

                                if (resultado.existe) {
                                    $("#id_producto").val(resultado.datos.id);
                                    $("#nombre").val(resultado.datos.nombre);
                                    $("#cantidad").val(1);
                                    $("#costo").val(resultado.datos.precio_compra);
                                    $("#subtotal").val(resultado.datos.precio_compra);
                                    $("#cantidad").focus();
                                } else {
                                    $("#id_producto").val('');
                                    $("#nombre").val('');
                                    $("#cantidad").val('');
                                    $("#costo").val('');
                                    $("#subtotal").val('');
                                }

                            }

                        }

                    });
                }
            }
        }


        function AgregarProducto(id_producto, cantidad, id_compra) {

            if (id_producto != null && id_producto != 0 && cantidad != 0) {
                $.ajax({
                    url: '<?php echo base_url(); ?>/TemporalCompra/insertar/' + id_producto + '/' + cantidad + '/' + id_compra,
                    success: function(resultado) {
                        if (resultado == 0) {

                        } else {

                            var resultado = JSON.parse(resultado);
                            if (resultado.error == '') {
                                $("#tablaproductos tbody").empty();
                                $("#tablaproductos tbody").append(resultado.datos);
                                $("#total").val(resultado.total);
                                $("#id_producto").val('');
                                $("#codigo").val('');
                                $("#nombre").val('');
                                $("#cantidad").val('');
                                $("#costo").val('');
                                $("#subtotal").val('');
                                $("#codigo").focus();
                            }
                        }
                    }
                });
            }
        }


        function eliminarProducto(id_producto, id_compra) {
            
            $.ajax({
                    url: '<?php echo base_url(); ?>/TemporalCompra/eliminar/' + id_producto + '/'  + '/' + id_compra,
                    success: function(resultado) {
                        if (resultado == 0) {

                        } else {

                            var resultado = JSON.parse(resultado);
                            if (resultado.error == '') {
                                $("#tablaproductos tbody").empty();
                                $("#tablaproductos tbody").append(resultado.datos);
                                $("#total").val(resultado.total);
                               
                            }
                        }
                    }
                });
        }
    </script>