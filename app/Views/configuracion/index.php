<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?= $titulo; ?></h4>
            <?php if (isset($validation)) { ?>
                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>


            <form method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>/configuracion/guardar" autocomplete="off">

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Nombre de la tienda</label>
                            <input class="form-control" id="tienda_nombre" name="tienda_nombre" type="text" value="<?php echo $nombre['valor']; ?>" autofocus required />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>*Email</label>
                            <input class="form-control" id="tienda_email" name="tienda_email" type="text" value="<?php echo $email['valor']; ?>" required />
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Telefono</label>
                            <input class="form-control" id="tienda_telefono" name="tienda_telefono" type="text" value="<?php echo $telefono['valor']; ?>" required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>*Domicilio</label>
                            <textarea class="form-control" id="tienda_domicilio" name="tienda_domicilio" required><?php echo $domicilio['valor']; ?></textarea>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Leyenda del tiquet</label>
                            <textarea class="form-control" id="tiquet_leyenda" name="tiquet_leyenda" required><?php echo $leyenda['valor']; ?></textarea>
                        </div>

                    </div>

                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6 col-sm-4">
                        <label>Logo del negocio</label><br>
                        <img src="<?php echo base_url();?>/images/logosr.png" class="img-responsive" width="200"/>
                        <input type="file" id="tienda_logo" name="tienda_logo" accept="image/png"/>
                        <p class="text-danger">cargar imagen en formato png de 150x150 pixeles</p> 
                        </div>
                    </div>
                </div>
                <p>
                    (*) Campo obligatorio
                </p>
                <p>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </p>
            </form>

        </div>
    </main>
    <div class="modal fade" id="modal-confirma" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Desea eliminar este registro..?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger btn-ok" id="myLink" title="Click aqui para confirmar" href="#" onclick="MyFunction();return false;">Si</button>
                </div>
            </div>
        </div>
    </div>