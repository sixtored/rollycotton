<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?= $titulo; ?></h4>
            <?php if (isset($validation)) { ?>
                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>

            <form method="POST" action="<?php echo base_url(); ?>/usuarios/guardar" autocomplete="off">
                <input type="hidden" value="<?php echo $dato['id']; ?>" name="id" />
                <input type="hidden" value="<?php echo $dato['id_caja']; ?>" name="id_caja" />
                <input type="hidden" value="<?php echo $dato['id_rol']; ?>" name="id_rol" />

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Usuario</label>
                            <input class="form-control" id="usuario" name="usuario" type="text" value="<?php echo $dato['usuario']; ?>"autofocus required/>
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
                            <label>Caja</label>
                           <input class="form-control" id="caja" name="caja" type="text" value="<?= $dato['caja']; ?>" disabled />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Rol</label>
                            <input class="form-control" id="rol" name="rol" type="text" value="<?= $dato['rol'] ;?>" disabled />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Email</label>
                            <input class="form-control" id="email" name="email" type="email" value="<?php echo $dato['email']; ?>" required />
                        </div>
                    </div>
                </div>

                <!--

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
                               
            -->


                <p>
                    (*) Campo obligatorio
                </p>
                <p>
                    <a href="<?php echo base_url(); ?>/usuarios" class="btn btn-primary">Volver</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </p>
            </form>

        </div>
    </main>