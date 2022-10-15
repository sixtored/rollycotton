<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?= $titulo; ?></h4>
            <div>
                <p>
                    <a href="<?php echo base_url(); ?>/ventas" class="btn btn-primary">Volver</a>
                </p>
            </div>
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Fecha y Hora</th>
                        <th>Folio</th>
                        <th>Cliente</th>
                        <th>Cajero</th>
                        <th>F.Pago</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $dato) { ?>
                        <tr>
                            <td><?php echo $dato['created_at']; ?></td>
                            <td><?php echo $dato['folio']; ?></td>
                            <td><?php echo $dato['cliente']; ?></td>
                            <td><?php echo $dato['cajero']; ?></td>
                            <td><?php echo $dato['forma_pago']; ?></td>
                            <td><?php echo $dato['total']; ?></td>
                            <td>
                                <a href="<?php echo base_url(); ?>/ventas/muestratiquet/<?php echo $dato['id']; ?>" class="btn btn-primary" title="Ver tiquet"><i class="fas fa-file-alt"></i></a>
                                <!--
                                <a href="#" data-href="<?php echo base_url() . '/ventas/restaurar/' . $dato['id']; ?>" data-bs-toggle="modal" 
                                data-bs-target="#modal-confirma" title="Restaurar Registro" class="btn btn-danger"><i class="far fa-trash-alt"></i></a> 
                    -->
                            
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
                    <p>¿Desea restaurar este registro..?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger btn-ok" id="myLink" title="Click aqui para confirmar" href="#" onclick="MyFunction();return false;">Si</button>
                </div>
            </div>
        </div>
    </div>
<!--
    <script>
        $(document).ready(function() {
            $('#datatablesSimple').DataTable();
        });
    </script>
    -->   