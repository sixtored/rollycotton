<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">    
            <h4 class="mt-4"><?= $titulo; ?></h4>
            <div class="row justify-content-start">
               <div class="col-10">
                    <a href="<?php echo base_url().'/ctactecli/nuevo/'. $cliente['id'] ;?>" class="btn btn-info">Agregar</a>
                    <a href="<?php echo base_url().'/ctactecli/eliminados/'. $cliente['id'] ;?>" class="btn btn-warning">Eliminados</a>
                    <a href="<?php echo base_url(); ?>/clientes" class="btn btn-primary">Volver</a>
               </div>
            </div>
         
            <div class="row justify-content-start">
                    <div class="col-4">
                        <h5><?= $cliente['nombre']; ?></h5>
                    </div>
                    <div class="col-8">
                        <h5><?= 'Saldo $ '.number_format($saldo,2,'.',','); ?></h5>
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
                        <th>SALDO</th>
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
                            <td class="text-sm-end fw-bold"><?php echo $dato['saldo']; ?></td>
                            <td>
                                <a href="<?php echo base_url(); ?>/ctactecli/editar/<?php echo $dato['id']; ?>" title="Editar registro" class="btn btn-warning"><i class="far fa-edit"></i></a>    
                                <a href="#" data-href="<?php echo base_url().'/ctactecli/eliminar/'. $dato['id']; ?>" data-bs-toggle="modal" 
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
                    <p>??Desea eliminar este registro..?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger btn-ok" id="myLink" title="Click aqui para confirmar" href="#" onclick="MyFunction();return false;">Si</button>
                </div>
            </div>
        </div>
    </div>