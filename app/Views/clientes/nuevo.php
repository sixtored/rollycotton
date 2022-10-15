<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?= $titulo; ?></h4>
            <?php echo \config\Services::validation()->listErrors(); ?>
            <?php echo csrf_field(); ?>

            <form method="POST" action="<?php echo base_url(); ?>/clientes/insertar" autocomplete="off">

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Nombre</label>
                            <input class="form-control" id="nombre" name="nombre" type="text" autofocus required />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>*Domicilio</label>
                            <input class="form-control" id="domicilio" name="domicilio" type="text" required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Email</label>
                            <input class="form-control" id="email" name="email" type="text" required />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Celular</label>
                            <input class="form-control" id="celular" name="celular" type="text" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Condicion Iva</label>
                            <select class="form-select" name="tipores" id="tipores" required>
                                <option value="">Seleccione condicion Iva</option>
                                <?php foreach ($tipoiva as $tipores) { ?>
                                    <option value="<?= $tipores['codigo']; ?>"><?= $tipores['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                    <div class="col-12 col-sm-6">
                            <label>Tipo Docu</label>
                            <select class="form-select" name="tipodoc" id="tipodoc" required>
                                <option value="">Seleccione Tipo docu</option>
                                <?php foreach ($tipodoc as $tdocu) { ?>
                                    <option value="<?= $tdocu['codigo']; ?>"><?= $tdocu['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Docu</label>
                            <input class="form-control" id="docu" name="docu" type="text" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Grupo</label>
                            <select class="form-select" name="grupo_id" id="gurpo_id" required>
                                <option value="">Seleccione Grupo</option>
                                <?php foreach ($grupos as $grupo) { ?>
                                    <option value="<?= $grupo['id']; ?>"><?= $grupo['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                    </div>
                </div>

                <p>
                    (*) Campo obligatorio
                </p>
                <p>
                    <a href="<?php echo base_url(); ?>/clientes" class="btn btn-primary">Volver</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </p>
            </form>

        </div>
    </main>