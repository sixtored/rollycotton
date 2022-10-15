<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?= $titulo; ?></h4>
            <div>
                <p>
                    <a href="<?php echo base_url(); ?>/cajas/nuevo_arqueo" class="btn btn-info">Agregar</a>
                    <a href="<?php echo base_url(); ?>/cajas/eliminados" class="btn btn-warning">Eliminados</a>
                </p>
            </div>
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Fecha apertura</th>
                        <th>Fecha cierre</th>
                        <th>Monto Inicial</th>
                        <th>Monto Final</th>
                        <th>Total Ventas</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $dato) { ?>
                        <tr>
                            <td><?php echo $dato['id']; ?></td>
                            <td><?php echo $dato['fecha_apertura']; ?></td>
                            <td><?php echo $dato['fecha_cierre']; ?></td>
                            <td><?php echo $dato['monto_inicial']; ?></td>
                            <td><?php echo $dato['monto_final']; ?></td>
                            <td><?php echo $dato['total_ventas']; ?></td>
                            <?php if ($dato['estado'] == 1) { ?>
                                <td>Abierta</td>
                                <td>
                                    <a href="<?php echo base_url(); ?>/cajas/cerrar_arqueo/<?php echo $dato['id']; ?>" title="Cerrar Caja" class="btn btn-danger"><i class="fas fa-door-closed"></i></a>
                                </td>
                            <?php } else { ?>

                                <td>Cerrada</td>
                                <td>
                                    <a href="<?php echo base_url(); ?>/cajas/cerrar_arqueo/<?php echo $dato['id']; ?>" title="Imprimir cierre" class="btn btn-success"><i class="far fa-file-alt"></i></a>
                                </td>



                            <?php } ?>
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