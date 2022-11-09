<footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; Sixtored <?php echo date('Y'); ?>
                    <a href="https://www.facebook.com/sixtoredsoftware" target="_blank">facebook</a>
                    &middot;
                    <a href="https://www.sixtored.com.ar/" target="_blank">WebSite</a>
                </div>
            </div>
        </div>
    </footer>
</div>
</div>

<script src="<?php echo base_url(); ?>/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>/js/scripts.js"></script>


<script type="text/javascript" src="<?php echo base_url(); ?>/datatables/jQuery-3.6.0/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/datatables/Bootstrap-5-5.1.3/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/datatables/DataTables-1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/datatables/DataTables-1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/datatables/Buttons-2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/datatables/Buttons-2.2.3/js/buttons.bootstrap5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/datatables/Buttons-2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/datatables/Buttons-2.2.3/js/buttons.print.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/datatables/AutoFill-2.4.0/js/dataTables.autoFill.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/datatables/AutoFill-2.4.0/js/autoFill.bootstrap5.min.js"></script>



<script type="text/javascript" src="<?php echo base_url(); ?>/datatables/ColReorder-1.5.6/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/datatables/Responsive-2.3.0/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/datatables/Responsive-2.3.0/js/responsive.bootstrap5.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/datatables/Scroller-2.0.7/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/datatables/Select-1.4.0/js/dataTables.select.min.js"></script>
<script src="<?php echo base_url(); ?>/datatables/datatablescargar.js"></script>

<script>

$(".btn-ok").click(function(event) {
  var href= $(this).attr('href');
  window.location.href = href;
  event.preventDefault();
});    

$('#modal-confirma').on('show.bs.modal', function(e) {
		$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
		$('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
	}); 

</script>

</body>
</html>