<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?= $titulo; ?></h4>

            <?php if ( isset($validation) ) { ?>
            <div class="alert alert-danger">   
            <?php echo $validation->listErrors();?>
            </div>
            <?php } ?>

            <form method="POST" action="<?php echo base_url(); ?>/cajas/nuevo_arqueo" autocomplete="off">
               
                <div class="form-group">
                    <div class="row">
                    <div class="col-12 col-sm-6">
                            <label>Caja numero</label>
                            <input class="form-control" id="numero_caja" name="numero_caja" type="text" value="<?php echo $dato['numero_caja']; ?>" disabled />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Usuario nombre</label>
                            <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $session->nombre; ?>" disabled />
                        </div>
                       
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Monto inicial</label>
                            <input class="form-control" id="monto_inicial" name="monto_inicial" type="text" value="<?=number_format(0.00, 2, '.', ',');?>" required />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>*Folio</label>
                            <input class="form-control" id="folio" name="folio" type="text" value="<?= $dato['folio']; ?>" required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Fecha</label>
                            <input class="form-control" id="fecha_apertura" name="fecha_apertura" type="text" value="<?=date('Y-m-d'); ?>" disabled />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Hora</label>
                            <input class="form-control" id="hora" name="hora" type="text" value="<?= date('H:i:s'); ?>" disabled />
                        </div>
                    </div>
                </div>


                <p>
                (*) Campo obligatorio 
                </p>
                <p>   
                    <a href="<?php echo base_url(); ?>/cajas" class="btn btn-primary">Volver</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </p>
            </form>

        </div>
    </main>