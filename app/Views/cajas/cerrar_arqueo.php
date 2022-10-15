<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?= $titulo; ?></h4>

            <?php if ( isset($validation) ) { ?>
            <div class="alert alert-danger">   
            <?php echo $validation->listErrors();?>
            </div>
            <?php } ?>

            <form method="POST" action="<?php echo base_url(); ?>/cajas/cerrar_arqueo" autocomplete="off">
                
                <input type="hidden" id="id_arqueo", name="id_arqueo" value="<?= $arqueo['id'] ; ?>"/>
                <input type="hidden" id="total_ventas", name="total_ventas" value="<?=$totalventas['total'] ; ?>"/>
               
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
                            <label>Monto inicial</label>
                            <input class="form-control" id="monto_inicial" name="monto_inicial" type="text" value="<?=$arqueo['monto_inicial'] ?>" disabled />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>*Monto final</label>
                            <input class="form-control" id="monto_final" name="monto_final" type="text" value="<?=number_format(0.00, 2, '.', ',');?>" autofocus required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Fecha Apertura</label>
                            <input class="form-control" id="fecha_apertura" name="fecha_apertura" type="text" value="<?=$arqueo['fecha_apertura']; ?>" disabled />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Fecha Cierre</label>
                            <input class="form-control" id="fecha_cierre" name="fecha_cierre" type="text" value="<?= date('Y-m-d H:i:s'); ?>" disabled />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Total Ventas</label>
                            <input class="form-control" id="total_ventas1" name="total_ventas1" type="text" value="<?=$totalventas['total'] ; ?>" disabled/>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Total cierre</label>
                            <input class="form-control" id="total_cierre" name="total_cierre" type="text" value="<?= $arqueo['fecha_cierre']; ?>" disabled />
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