<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?= $titulo; ?></h4>
            <?php if (isset($validation)) { ?>
                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>

            <div class="row justify-content-start">
                    <div class="col-4">
                        <h5><?= $cliente['nombre']; ?></h5>
                    </div>
                    <div class="col-8">
                        <h5><?= 'Saldo $ '.number_format($saldo,2,'.',','); ?></h5>
                    </div>
            </div>

            <form method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>/ctactecli/insertar" autocomplete="off">
            <input type="hidden" id="cliente_id" name="cliente_id" value="<?php echo $cliente['id']; ?>" />
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                            <label>TIPO :</label>
                                <Select class="form-select" id="tipo" name="tipo" required>
                                    <option value="1">DEBITO</option>
                                    <option value="2">CREDITO</option>
                                </Select>
                            </div>
                            
                        </div>
                    </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*DETALLE</label>
                            <input class="form-control" id="detalle" name="detalle" type="text" value="" />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>*IMPORTE</label>
                            <input class="form-control" id="importe" name="importe" type="text" required />
                        </div>
                    </div>
                </div>

                <p>
                    (*) Campo obligatorio
                </p>
                <p>
                    <a href="<?php echo base_url(); ?>/ctactecli/ctacli/<?=$cliente['id'];?>" class="btn btn-primary">Volver</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </p>
            </form>

        </div>
    </main>