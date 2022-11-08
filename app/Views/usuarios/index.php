<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?= $titulo; ?></h4>
            <div>
                <p>
                    <a href="<?php echo base_url(); ?>/usuarios/nuevo" class="btn btn-info">Agregar</a>
                    <a href="<?php echo base_url(); ?>/usuarios/eliminados" class="btn btn-warning">Eliminados</a>
                </p>
            </div>
            <table id="datatablesSimple" class="table table-sm table-success table-striped table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>usuario</th>
                        <th>nombre</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $dato) { ?>
                        <tr>
                            <td><?php echo $dato['id']; ?></td>
                            <td><?php echo $dato['usuario']; ?></td>
                            <td><?php echo $dato['nombre']; ?></td>
                            <td>
                                <a href="<?php echo base_url(); ?>/usuarios/editar/<?php echo $dato['id']; ?>" title="Editar perfil" class="btn btn-warning"><i class="far fa-edit"></i></a>    
                                <a href="#" data-href="<?php echo base_url().'/usuarios/eliminar/'. $dato['id']; ?>" data-bs-toggle="modal" 
                                data-bs-target="#modal-confirma" title="Eliminar Registro" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
                            </td>
                            <td>
                            <a href="<?php echo base_url(); ?>/usuarios/cambiar_contrasenia/<?=$dato['id'] ;?>" title="Cambiar Contraseña" class="btn btn-primary"><i class="fas fa-key"></i></a>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
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