<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?= $titulo; ?></h4>
            <?php if (isset($validation)) { ?>
                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>

            <form method="POST" action="<?php echo base_url(); ?>/usuarios/actuliza_contrasenia" autocomplete="off">
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Usuario</label>
                            <input class="form-control" id="usuario" name="usuario" type="text" value="<?php echo $dato['usuario']; ?>" disabled/>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>*Nombre</label>
                            <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $dato['nombre']; ?>" disabled />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Password</label>
                            <input class="form-control" id="password" name="password" type="password" required />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>*Repite password</label>
                            <input class="form-control" id="password" name="rpassword" type="password" required />
                        </div>
                    </div>
                </div>
                <p>
                    (*) Campo obligatorio
                </p>
                <p>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </p>
                <?php if (isset($mensaje)) { ?>
                <div class="alert alert-success">
                    <?php echo $mensaje; ?>
                </div>
            <?php } ?>
            </form>

        </div>
    </main>