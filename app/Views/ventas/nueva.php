<?php $idventatmp = uniqid(); ?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <br>

            <form method="POST" id="form_venta" name="form_venta" class="form-horizontal" action="<?= base_url(); ?>/ventas/guarda" autocomplete="off">
                <input type="hidden" id="id_venta" name="id_venta" value="<?php echo $idventatmp; ?>" />

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="ui-widget">
                                <label>Cliente :</label>
                                <input type="hidden" id="id_cliente" name="id_cliente" value="1" />
                                <input class="form-control" type="text" id="cliente" name="cliente" placeholder="Escribe el nombre del cliente" value="Consumidor final" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Forma de pago :</label>
                            <Select class="form-select" id="forma_pago" name="forma_pago" required>
                                <option value="001">Efectivo</option>
                                <option value="002">Tarjeta</option>
                                <option value="003">Transferencia</option>
                            </Select>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <input type="hidden" id="id_producto" name="id_producto" />
                            <label>Codigo</label>
                            <input class="form-control" id="codigo" name="codigo" type="text" placeholder="Escribe el codigo y presione Enter" onkeyup="AgregarProducto(event, this.value, 1, <?php echo $idventatmp; ?>)" autocomplete="off" autofocus />
                        </div>
                        <div class="col-sm-2">
                            <label for="codigo" id="resultado_error" style="color: red"> </label>
                        </div>

                        <div class="col-12 col-sm-2">
                            <label style="font-weight: bold; font-size: 30px; text-align: center;">Total $</label>
                            <input type="text" id="total" name="total" size="7" readonly="true" value="0.00" style="font-weight: bold; font-size: 30px; text-align: center;" />
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <button type="button" id="completa_venta" class="btn btn-success">Completar venta</button>
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

            </form>
        </div>
    </main>

    <script>
        $(function() {
            $("#cliente").autocomplete({
                source: "<?php echo base_url(); ?>/clientes/autocompletedata",
                minLength: 3,
                select: function(event, ui) {
                    event.preventDefault();
                    $("#id_cliente").val(ui.item.id);
                    $("#cliente").val(ui.item.value);
                }
            });
        });

        $(function() {
            $("#codigo").autocomplete({
                source: "<?php echo base_url(); ?>/productos/autocompletedata",
                minLength: 3,
                select: function(event, ui) {
                    event.preventDefault();
                    $("#id_producto").val(ui.item.id);
                    $("#codigo").val(ui.item.value);
                    setTimeout(
                        function() {
                            e = jQuery.Event("keypress");
                            e.which = 13;
                            AgregarProducto(e, ui.item.id, 1, '<?php echo $idventatmp; ?>');
                        }
                    )
                }
            });
        });


        function AgregarProducto(e, id_producto, cantidad, id_venta) {

            let entrekey = 13;
            if (codigo != '') {
                if (e.which == entrekey) {
                    if (id_producto != null && id_producto != 0 && cantidad != 0) {
                        $.ajax({
                            url: '<?php echo base_url(); ?>/TemporalCompra/insertar/' + id_producto + '/' + cantidad + '/' + id_venta,
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
            }
        }

        function eliminarProducto(id_producto, id_venta) {

            $.ajax({
                url: '<?php echo base_url(); ?>/TemporalCompra/eliminar/' + id_producto + '/' + '/' + id_venta,
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


        $(function() {
            $('#completa_venta').click(function(){
                let nFila = $('#tablaproductos tr').length ;

                if (nFila < 2) {
                        alert("Debe Agregar un producto..")
                } else {
                    $('#form_venta').submit() ;

                }
            });
        });

    </script>