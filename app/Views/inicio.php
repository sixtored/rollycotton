<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">


            <br />

            <div class="row">
                <div class="col-4">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                           <?= $tproductos ;?> Productos registrados
                        </div>
                        <a class="card-footer text-white" href="<?php echo base_url();?>/productos">Ver detalles</a>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                           <?= '$ '.$ventasdia['total'] ;?> Total de ventas del dia
                        </div>
                        <a class="card-footer text-white" href="<?php echo base_url();?>/ventas">Ver detalles</a>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                           <?= $pstock_min ;?> Productos sin stock
                        </div>
                        <a class="card-footer text-white" href="<?php echo base_url();?>/productos/muestrastockminimo">Ver detalles</a>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-4">
                    <canvas id="myChart" width="400" height="400"></canvas>
                </div>

                <div class="col-4">
                   <a href="<?php echo base_url();?>/inicio/excel" class="btn btn-primary">Generar excel</a>
                </div>
            </div>

        </div>

    </main>

    <script>
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>