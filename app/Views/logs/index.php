<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?= $titulo; ?></h4>
            <div>
            </div>
                <table id="datatablesSimple" class="table table-sm table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Tipo</th>
                            <th>Evento</th>
                            <th>Detalles</th>
                            <th>Ip</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($datos as $dato) { ?>
                        <tr>
                            <td><?php echo $dato['created_at'];?></td>
                            <td><?php echo $dato['usuario'] ;?></td>
                            <td><?php echo $dato['tipo'] ;?></td>
                            <td><?php echo $dato['evento'] ;?></td>
                            <td><?php echo $dato['detalles'] ;?></td>
                            <td><?php echo $dato['ip'] ;?></td>
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