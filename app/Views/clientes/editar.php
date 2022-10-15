<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?= $titulo; ?></h4>

            <form method="POST" action="<?php echo base_url(); ?>/clientes/guardar" autocomplete="off">
                <input type="hidden" value="<?php echo $dato['id']; ?>" name="id" />

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Nombre</label>
                            <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $dato['nombre']; ?>" autofocus required />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>*Domicilio</label>
                            <input class="form-control" id="domicilio" name="domicilio" type="text" value="<?php echo $dato['domicilio']; ?>" required />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>*Email</label>
                            <input class="form-control" id="email" name="email" type="text" value="<?php echo $dato['email']; ?>" required />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Celular</label>
                            <input class="form-control" id="celular" name="celular" type="text" value="<?php echo $dato['celular']; ?>" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Condicion Iva</label>
                            <select class="form-select" name="tipores" id="tipores" ?>" required>
                                <option value="">Seleccione condicion Iva</option>
                                <?php foreach ($tipoiva as $tipores) { ?>
                                    <option value="<?= $tipores['codigo']; ?>" <?php if($tipores['codigo']==$dato['tipores']){echo 'selected' ;}?> ><?= $tipores['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Tipo Docu</label>
                            <select class="form-select" name="tipodoc" id="tipodoc" ?>" required>
                                <option value="">Seleccione tipo docu</option>
                                <?php foreach ($tipodoc as $tdocu) { ?>
                                    <option value="<?= $tdocu['codigo']; ?>" <?php if($tdocu['codigo']==$dato['tipodoc']){echo 'selected' ;}?> ><?= $tdocu['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Docu</label>
                            <input class="form-control" id="docu" name="docu" type="text" value="<?php echo $dato['docu']; ?>" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Grupo</label>
                            <select class="form-select" name="grupo_id" id="grupo_id" ?>" required>
                                <option value="">Seleccione grupo</option>
                                <?php foreach ($grupos as $grupo) { ?>
                                    <option value="<?= $grupo['id']; ?>" <?php if($grupo['id']==$dato['grupo_id']){echo 'selected' ;}?> ><?= $grupo['nombre']; ?></option>
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