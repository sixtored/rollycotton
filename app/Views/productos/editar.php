<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?= $titulo; ?></h4>

            <?php if (isset($validation)) { ?>
                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>

            <form method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>/productos/guardar" autocomplete="off">
                <input type="hidden" value="<?php echo $dato['id']; ?>" name="id" />

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Codigo</label>
                            <input class="form-control" id="codigo" name="codigo" type="text" value="<?php echo $dato['codigo']; ?>" autofocus required />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>*Nombre</label>
                            <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $dato['nombre']; ?>" required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Unidad</label>
                            <select class="form-select" name="id_unidad" id="id_unidad" ?>" required>
                                <option value="">Seleccione Unidad</option>
                                <?php foreach ($unidades as $unidad) { ?>
                                    <option value="<?= $unidad['id']; ?>" <?php if($unidad['id']==$dato['id_unidad']){echo 'selected' ;}?> ><?= $unidad['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>*Categoria</label>
                            <select class="form-select" name="id_categoria" id="id_categoria" required>
                                <option value="">Seleccione Categoria</option>
                                <?php foreach ($categorias as $categoria) { ?>
                                    <option value="<?= $categoria['id']; ?>" <?php if($categoria['id']==$dato['id_categoria']) {echo 'selected' ;} ?>><?= $categoria['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Precio compra</label>
                            <input class="form-control" id="precio_compra" name="precio_compra" type="text" value="<?php echo $dato['precio_compra']; ?>" required />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>*Precio venta</label>
                            <input class="form-control" id="precio_venta" name="precio_venta" type="text" value="<?php echo $dato['precio_venta']; ?>" required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Existencia</label>
                            <input class="form-control" id="existencia" name="existencia" type="text" value="<?php echo $dato['existencia']; ?>" />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Stock Minimo</label>
                            <input class="form-control" id="stock_min" name="stock_min" type="text" value="<?php echo $dato['stock_min']; ?>" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Controla Stock..?</label>
                            <select class="form-select" name="controla_stock" id="controla_stock" value="<?php echo $dato['controla_stock']; ?>" required>
                                <option value="1" <?php if($dato['controla_stock']==1) {echo 'selected' ;} ?> >SI</option>
                                <option value="0" <?php if($dato['controla_stock']==0) {echo 'selected' ;} ?> >NO</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6">

                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-6 col-sm-4">
                        <label>Imagen</label><br>

                        <img src="<?php echo base_url().'/images/productos/'.$dato['id'].'.jpg';?>" class="img-responsive" width="200"/>
                        <input type="file" id="img_producto" name="img_producto" accept="image/*"/>
                        <p class="text-danger">cargar imagen en formato jpg de 150x150 pixeles</p> 
                        </div>
                    </div>
                </div>


                <p>
                    (*) Campo obligatorio
                </p>
                <p>
                    <a href="<?php echo base_url(); ?>/productos" class="btn btn-primary">Volver</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </p>
            </form>

        </div>
    </main>