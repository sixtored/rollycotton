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
                    <h5><?= 'Total Monto  '.number_format($total,2,'.',','); ?></h5>
                    </div>
                    <div class="col-4">
                        <h5><?= 'Total Litros  '.number_format($litros,2,'.',','); ?></h5>
                    </div>
            </div>

            <form method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>/rlaboreos/insertar1" autocomplete="off">
           
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                            <label>*Cliente</label>
                            <select class="form-select" name="cliente_id" id="cliente_id" required>
                                <option value="">Seleccione cliente</option>
                                <?php foreach ($clientes as $cliente) { ?>
                                    <option value="<?= $cliente['id']; ?>"><?= $cliente['nombre']; ?></option>
                                <?php } ?>
                            </select>
                            </div>

                            <div class="col-12 col-sm-6">
                            <label>*Operacion</label>
                            <select class="form-select" name="op_id" id="op_id" required>
                                <option value="">Seleccione Operacion</option>
                                <?php foreach ($toper as $row) { ?>
                                    <option value="<?= $row['id']; ?>"><?= $row['nombre']; ?></option>
                                <?php } ?>
                            </select>
                            </div>
                            
                        </div>
                    </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*DETALLE</label>
                            <input class="form-control" id="detalle" name="detalle" type="text" value="<?= set_value('detalle') ?>" />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>*Campo</label>
                            <select class="form-select" name="id_campo" id="id_campo" >
                                <option value="">Seleccione Campo</option>
                                <?php foreach ($campo as $row) { ?>
                                    <option value="<?= $row['id']; ?>"><?= $row['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div> 
                        
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*MONTO</label>
                            <input class="form-control" id="monto" name="monto" type="text" value="<?= set_value('monto') ?>" />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>LITROS</label>
                            <input class="form-control" id="litros" name="litros" type="text" value="<?= set_value('litros') ?>" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-6 col-sm-4">
                        <label>Foto</label><br>
                       
                        <input type="file" id="img_rlaboreo" name="img_rlaboreo" accept="image/*"/>
                        <p class="text-danger">cargar imagen en formato jpg/jpeg Maximo 400 x 400 pixeles</p> 
                        </div>
                    </div>
                </div>

                <p>
                    (*) Campo obligatorio
                </p>
                <p>
                    <a href="<?php echo base_url(); ?>/rlaboreos/index" class="btn btn-primary">Volver</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </p>
            </form>

        </div>
    </main>