@extends('layout.layout')

@section('content')

<div class="row">
    <div class="col-xl-4 col-lg-6">
        <div class="card mb-5 shadow-sm border-0 shadow-hover">
            <div class="card-body d-flex">
                <div>
                    <div class="circle rounded-circle bg-primary align-self-center d-flex mr-3">
                        <i class="icon ion-md-cash text-primary align-self-center mx-auto lead"></i>
                    </div>
                </div>
                <div class="align-self-center">
                    <h5 class="mb-0 text-success">R$ {{ $saldo->saldo }}</h5>
                    <small class="text-muted">Dinheiro disponível</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6">
        <div class="card mb-5 shadow-sm border-0 shadow-hover">
            <div class="card-body d-flex">
                <div>
                    <div class="circle rounded-circle bg-primary align-self-center d-flex mr-3">
                        <i class="icon ion-md-cash text-primary align-self-center mx-auto lead"></i>
                    </div>
                </div>
                <div class="align-self-center">
                    <h5 class="mb-0 text-primary">R$ <?php echo isset($totalDep) ? $totalDep : '0'; ?></h5>
                    <small class="text-muted">Total depositado</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6">
        <div class="card mb-5 shadow-sm border-0 shadow-hover">
            <div class="card-body d-flex">
                <div>
                    <div class="circle rounded-circle bg-primary align-self-center d-flex mr-3">
                        <i class="icon ion-md-cash text-primary align-self-center mx-auto lead"></i>
                    </div>
                </div>
                <div class="align-self-center">
                    <h5 class="mb-0 text-danger">R$ <?php echo isset($totalSaq) ? $totalSaq : '0'; ?></h5>
                    <small class="text-muted">Total retirado</small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($valoresDeposito) : ?>
    <div id="piechart_3d" class="row" style="height: 40vh; margin:0 auto; width: 80vw; margin-left:0; margin:0 auto; "></div>
<?php endif; ?>
<?php if ($valoresSaque) : ?>
    <div id="piechart" class="row" style="height: 40vh; margin:0 auto; width: 80vw; margin-left:0; margin:0 auto;"></div>
<?php endif; ?>


<?php if ($valoresDeposito) : ?>
    <!-- GRAFICOS  -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        <?php
        $totalDep = $totalDep + $totalSaq;
        ?>

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Transação', 'valor'],
                <?php foreach ($valoresDeposito as $vd) : ?>
                    <?php foreach ($vd as $v => $d) : ?>
                        <?php $valor = $d[0]->total + 0 ?>
                        <?php echo "['$v', $valor]," ?>
                    <?php endforeach ?>
                <?php endforeach ?>
            ]);

            var options = {
                title: 'Como o seu deposito está repartido:',
                // is3D: true,
                // colors: [
                //     'red',
                //     '#32CD32'
                // ],
                backgroundColor: 'transparent',
                chartArea: {
                    width: '100%',
                    height: '75%'
                },
                legend: {
                    position: 'bottom'
                },
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);
        }

        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawChart);
    </script>
<?php endif; ?>
<!--  -->
<!--  -->
<?php if ($valoresSaque) : ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Transação', 'valor'],
                <?php foreach ($valoresSaque as $vd) : ?>
                    <?php foreach ($vd as $v => $d) : ?>
                        <?php $valor = $d[0]->total + 0 ?>
                        <?php echo "['$v', $valor]," ?>
                    <?php endforeach ?>
                <?php endforeach ?>
            ]);

            var options = {
                title: 'Como o seu saque está repartido:',
                backgroundColor: 'transparent',
                chartArea: {
                    width: '100%',
                    height: '75%'
                },
                legend: {
                    position: 'bottom'
                },
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
<?php endif; ?>


<!--  -->

@endsection