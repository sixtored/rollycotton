$(document).ready(function() {
    $('#datatablesSimple').DataTable( {
        buttons: [
            {
                extend: 'csv',
                text: 'Copy all data',
                exportOptions: {
                    modifier: {
                        search: 'none'
                    }
                }
            }
        ],
        select: true,
        responsive: true,
        language: {
            select: {
                rows: {
                    _: "Mostrando %d registro",
                    0: "Click para seleccionar un registro",
                    1: "1 registro seleccionado"
                }
            },
            paginate: {
                "first": "Primera",
                "last": "Ultima",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            search: "Busqueda:",
            info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
            infoEmpty: "Mostrando 0 a 0 de 0 entradas"
        }
    } );
} );


/*
$(document).ready(function() {
	$('#datatablesSimple').DataTable();
} );

*/
window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }
});
