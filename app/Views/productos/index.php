<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?= $titulo; ?></h4>
            <div>
                <p>
                    <a href="<?php echo base_url(); ?>/productos/nuevo" class="btn btn-info">Agregar</a>
                    <a href="<?php echo base_url(); ?>/productos/eliminados" class="btn btn-warning">Eliminados</a>
                    <a href="<?php echo base_url(); ?>/productos/muestracodigosbarra" class="btn btn-primary">codigos de barra</a>
                </p>
            </div>
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Precio venta</th>
                        <th>Precio compra</th>
                        <th>Existencia</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $dato) { ?>
                        <tr>
                            <td><?php echo $dato['codigo']; ?></td>
                            <td><?php echo $dato['nombre']; ?></td>
                            <td><?php echo $dato['precio_venta']; ?></td>
                            <td><?php echo $dato['precio_compra']; ?></td>
                            <td><?php echo $dato['existencia']; ?></td>
                            <?php 
                            $foto = 'images/productos/'.$dato['id'].'.jpg' ;
                            if (file_exists($foto)) {
                            ?>
                            <td><img src="<?php echo base_url().'/images/productos/'.$dato['id'].'.jpg';?>" class="img-responsive" width="100"/>
                            </td>
                            <?php 
                            } else {
                            ?>    
                            <td><img src="<?php echo base_url().'/images/logosr.png';?>" class="img-responsive" width="100"/>
                            </td>
                            <?php
                            }
                            ?>
                            <td>
                                <a href="<?php echo base_url(); ?>/productos/editar/<?php echo $dato['id']; ?>" title="Editar Unidad" class="btn btn-warning"><i class="far fa-edit"></i></a>    
                                <a href="#" data-href="<?php echo base_url().'/productos/eliminar/'. $dato['id']; ?>" data-bs-toggle="modal" 
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