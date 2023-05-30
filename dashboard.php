<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sicontrar";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi bem sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta para obter a quantidade de registros por usuário com seus respectivos nomes e matrículas
$query_usuarios = "SELECT u.matricula, u.nome, COUNT(*) AS total_registros FROM cadastro c JOIN usuarios u ON c.matricula = u.matricula GROUP BY u.matricula, u.nome";
$result_usuarios = $conn->query($query_usuarios);

$data_usuarios_chart = array();

while ($row = $result_usuarios->fetch_assoc()) {
    $data_usuarios_chart[] = array(
        'matricula' => $row['matricula'],
        'nome' => $row['nome'],
        'total_registros' => (int)$row['total_registros']
    );
}

// Consulta para obter a quantidade de registros por unidade arquivística
$query_unidades = "SELECT un_arq, COUNT(*) AS total_registros FROM cadastro GROUP BY un_arq";
$result_unidades = $conn->query($query_unidades);

$data_unidades_chart = array();

while ($row = $result_unidades->fetch_assoc()) {
    $data_unidades_chart[] = array(
        'un_arq' => $row['un_arq'],
        'total_registros' => (int)$row['total_registros']
    );
}

// Consulta para obter a contagem de registros por período de tempo e unidade arquivística
$query_registros = "SELECT DATE_FORMAT(data_registro, '%Y-%m') AS periodo, un_arq, COUNT(*) AS total_registros FROM cadastro GROUP BY periodo, un_arq";
$result_registros = $conn->query($query_registros);

$data_registros_chart = array();
$periodos = array();

while ($row = $result_registros->fetch_assoc()) {
    $periodo = $row['periodo'];
    $un_arq = $row['un_arq'];
    $total_registros = (int)$row['total_registros'];

    if (!in_array($periodo, $periodos)) {
        $periodos[] = $periodo;
    }

    $data_registros_chart[$un_arq][$periodo] = $total_registros;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Controle de Arquivos - Dashboard</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .chart-container {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .chart {
            flex-basis: 30%;
        }

        /* Estilo baseado no arquivo "formulario.php" */
        body {
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .chart-container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .chart {
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Sistema de Controle de Arquivos - Dashboard</h1>

        <div class="chart-container">
            <div class="chart-title">Quantidade de Registros por Usuário</div>
            <div id="chartUsuarios" class="chart"></div>
        </div>

        <div class="chart-container">
            <div class="chart-title">Quantidade de Registros por Unidade Arquivística</div>
            <div id="chartUnidades" class="chart"></div>
        </div>

        <div class="chart-container">
            <div class="chart-title">Quantidade de Registros por Período de Tempo e Unidade Arquivística</div>
            <div id="chartRegistros" class="chart"></div>
        </div>
    </div>

    <script type="text/javascript">
        google.charts.load('current', {
            packages: ['corechart']
        });

        google.charts.setOnLoadCallback(drawChartUsuarios);
        google.charts.setOnLoadCallback(drawChartUnidades);
        google.charts.setOnLoadCallback(drawChartRegistros);

        function drawChartUsuarios() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Usuário');
            data.addColumn('number', 'Total de Registros');

            <?php foreach ($data_usuarios_chart as $usuario) : ?>
                data.addRow(['<?= $usuario['nome'] ?>', <?= $usuario['total_registros'] ?>]);
            <?php endforeach; ?>

            var options = {
                title: 'Quantidade de Registros por Usuário',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('chartUsuarios'));
            chart.draw(data, options);
        }

        function drawChartUnidades() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Unidade Arquivística');
            data.addColumn('number', 'Total de Registros');

            <?php foreach ($data_unidades_chart as $unidade) : ?>
                data.addRow(['<?= $unidade['un_arq'] ?>', <?= $unidade['total_registros'] ?>]);
            <?php endforeach; ?>

            var options = {
                title: 'Quantidade de Registros por Unidade Arquivística',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('chartUnidades'));
            chart.draw(data, options);
        }

        function drawChartRegistros() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Período');
            <?php foreach ($periodos as $periodo) : ?>
                data.addColumn('number', '<?= $periodo ?>');
            <?php endforeach; ?>

            <?php foreach ($data_registros_chart as $un_arq => $periodos) : ?>
                var row = ['<?= $un_arq ?>'];
                <?php foreach ($periodos as $periodo => $total_registros) : ?>
                    row.push(<?= $total_registros ?>);
                <?php endforeach; ?>
                data.addRow(row);
            <?php endforeach; ?>

            var options = {
                title: 'Quantidade de Registros por Período de Tempo e Unidade Arquivística',
                hAxis: {
                    title: 'Período',
                    textStyle: {
                        color: '#ffffff'
                    }
                },
                vAxis: {
                    title: 'Quantidade de Registros',
                    textStyle: {
                        color: '#ffffff'
                    }
                },
                legend: {
                    position: 'top',
                    textStyle: {
                        color: '#ffffff'
                    }
                },
                chartArea: {
                    width: '80%',
                    height: '70%',
                    backgroundColor: {
                        fill: 'black'
                    }
                },
                tooltip: {
                    isHtml: true,
                    textStyle: {
                        color: '#ffffff'
                    },
                    showColorCode: true,
                    backgroundColor: {
                        fill: 'black'
                    }
                },
                backgroundColor: {
                    fill: 'black'
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('chartRegistros'));
            chart.draw(data, options);
        }
    </script>
</body>

</html>