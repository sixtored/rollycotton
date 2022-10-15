<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">    
            <h4 class="mt-4"><?= $titulo; ?></h4>
            <div class="row justify-content-start">
               <div class="col-10">
                    <a href="<?php echo base_url(). '/ctactecli/ctacli/'. $cliente['id'] ;?>" class="btn btn-warning">Volver</a>
                    <a href="<?php echo base_url(); ?>/clientes" class="btn btn-primary">Clientes</a>
               </div>
            </div>
         
            <div class="row justify-content-start">
                    <div class="col-4">
                        <h5><?= $cliente['nombre']; ?></h5>
                    </div>
                    <div class="col-8">
                        
                    </div>
            </div>
            <table id="datatablesSimple" class="table table-sm table-striped table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>FECHA</th>
                        <th>DETALLE</th>
                        <th>DEBITO</th>
                        <th>CREDITO</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $dato) { ?>
                        <tr>
                            <td><?php echo $dato['id']; ?></td>
                            <td><?php echo $dato['fch']; ?></td>
                            <td><?php echo $dato['detalle']; ?></td>
                            <td class="text-sm-end"><?php echo $dato['debito']; ?></td>
                            <td class="text-sm-end"><?php echo $dato['credito']; ?></td>
                            <td class="text-sm-end fw-bold"></td>
                            <td>
                                 
                                <a href="#" data-href="<?php echo base_url().'/ctactecli/restaurar/'. $dato['id']; ?>" data-bs-toggle="modal" 
                                data-bs-target="#modal-confirma" title="Restaurar Registro" class="btn btn-success"><i class="fas fa-trash-restore"></i></a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Restaurar Registro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Desea Restaurar este registro..?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger btn-ok" id="myLink" title="Click aqui para confirmar" href="#" onclick="MyFunction();return false;">Si</button>
                </div>
            </div>
        </div>
    </div>