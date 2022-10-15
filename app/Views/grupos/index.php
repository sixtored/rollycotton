<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?= $titulo; ?></h4>
            <div>
                <p>
                    <a href="<?php echo base_url();?>/grupos/nuevo" class="btn btn-info">Agregar</a>
                    <a href="<?php echo base_url();?>/grupos/eliminados" class="btn btn-warning">Eliminados</a>
                </p>
            </div>
                <table id="datatablesSimple" class="table table-sm table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($datos as $dato) { ?>
                        <tr>
                            <td><?php echo $dato['id'];?></td>
                            <td><?php echo $dato['nombre'] ;?></td>
                            <td>
                            <a href="<?php echo base_url();?>/grupos/editar/<?php echo $dato['id'];?>" class="btn btn-warning" title="Editar Registro"><i class="far fa-edit"></i></a>
                            <a href="#" data-href="<?php echo base_url().'/grupos/eliminar/'. $dato['id']; ?>" data-bs-toggle="modal" 
                                data-bs-target="#modal-confirma" title="Eliminar Registro" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
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