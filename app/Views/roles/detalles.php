<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4"><?= $titulo; ?></h4>
            <div>
                <p>
                    <a href="<?php echo base_url(); ?>/roles" class="btn btn-primary">Volver</a>
                </p>

                <form method="POST" action="<?php echo base_url();?>/roles/guardapermisos" id="form_permisos" name="form_permisos">

                <input type="hidden" id="id_rol" name="id_rol" value="<?php echo $id_rol ; ?>">

                <?php 
                foreach($permisos as $row){ ?>
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="<?=$row['id'] ;?>" name="permisos[]" <?php if (isset($asignado[$row['id']])){ echo 'checked' ; }?>> <label class="form-check-label"><?php echo $row['nombre'] ;?></label> 
                    </div>
                <?php     
                }

                ?>
                <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
            
        </div>
    </main>
    