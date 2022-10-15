<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?= $titulo; ?></h4>
            <?php if (isset($validation)) { ?>
                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>

            <form method="POST" action="<?php echo base_url(); ?>/usuarios/insertar" autocomplete="off">

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Usuario</label>
                            <input class="form-control" id="usuario" name="usuario" type="text" autofocus />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>*Nombre</label>
                            <input class="form-control" id="nombre" name="nombre" type="text" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Caja</label>
                            <select class="form-select" name="id_caja" id="id_caja" required>
                                <option value="">Seleccione Caja</option>
                                <?php foreach ($cajas as $caja) { ?>
                                    <option value="<?= $caja['id']; ?>"><?= $caja['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>*Rol</label>
                            <select class="form-select" name="id_rol" id="id_rol" required>
                                <option value="">Seleccione Rol</option>
                                <?php foreach ($roles as $rol) { ?>
                                    <option value="<?= $rol['id']; ?>"><?= $rol['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Email</label>
                            <input class="form-control" id="email" name="email" type="email" required />
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
                    <a href="<?php echo base_url(); ?>/usuarios" class="btn btn-primary">Volver</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </p>
            </form>

        </div>
    </main>