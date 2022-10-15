<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?= $titulo; ?></h4>

            <?php if ( isset($validation) ) { ?>
            <div class="alert alert-danger">   
            <?php echo $validation->listErrors();?>
            </div>
            <?php } ?>

            <form method="POST" action="<?php echo base_url(); ?>/cajas/guardar" autocomplete="off">
                <input type="hidden" value="<?php echo $dato['id']; ?>" name="id" />
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Nombre</label>
                            <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $dato['nombre']; ?>" autofocus required />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>*Nombre corto</label>
                            <input class="form-control" id="numero_caja" name="numero_caja" type="text" value="<?php echo $dato['numero_caja']; ?>" required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Ubicacion</label>
                            <input class="form-control" id="ubicacion" name="ubicacion" type="text" value=" <?php echo $dato['ubicacion']; ?>" required />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>*Folio</label>
                            <input class="form-control" id="folio" name="folio" type="text" value="<?= $dato['folio']; ?>" required />
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