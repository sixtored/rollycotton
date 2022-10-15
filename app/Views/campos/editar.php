<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?= $titulo; ?></h4>

            <form method="POST" action="<?php echo base_url(); ?>/campos/guardar" autocomplete="off">
                <input type="hidden" value="<?php echo $dato['id']; ?>" name="id" />
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Nombre</label>
                            <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $dato['nombre']; ?>" autofocus required />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Ubicacion</label>
                            <input class="form-control" id="ubicacion" name="ubicacion" type="text" value="<?php echo $dato['ubicacion']; ?>" />
                        </div>
                    </div>
                </div>
                <p>
                (*) Campo obligatorio 
                </p>
                <p>   
                <a href="<?php echo base_url(); ?>/campos" class="btn btn-primary">Volver</a>
                <button type="submit" class="btn btn-success">Guardar</button>
                </p>
            </form>

        </div>
    </main>