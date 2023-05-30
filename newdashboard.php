<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sicontrar";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Consulta para obter os dados dos gráficos
// Total de registros por usuário
$usuariosQuery = "SELECT matricula, COUNT(*) as total_registros FROM cadastro GROUP BY matricula";
$usuariosResult = $conn->query($usuariosQuery);

$usuariosLabels = [];
$usuariosData = [];

if ($usuariosResult->num_rows > 0) {
    while ($row = $usuariosResult->fetch_assoc()) {
        $usuariosLabels[] = $row['matricula'];
        $usuariosData[] = $row['total_registros'];
    }
}

// Gerar um array de cores aleatórias com base no número de usuários
$usuariosColors = [];
for ($i = 0; $i < count($usuariosLabels); $i++) {
    $usuariosColors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

// Total de registros por unidade arquivística
$unidadesQuery = "SELECT un_arq, COUNT(*) as total_registros FROM cadastro GROUP BY un_arq";
$unidadesResult = $conn->query($unidadesQuery);

$unidadesLabels = [];
$unidadesData = [];

if ($unidadesResult->num_rows > 0) {
    while ($row = $unidadesResult->fetch_assoc()) {
        $unidadesLabels[] = $row['un_arq'];
        $unidadesData[] = $row['total_registros'];
    }
}

// Gerar um array de cores aleatórias com base no número de un_arq
$un_arqColors = [];
for ($i = 0; $i < count($unidadesLabels); $i++) {
    $un_arqColors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

// Total de registros por dependência antes e após as 12h00
$periodos = ['Antes das 12h00', 'Após as 12h00'];
$dependenciasQuery = "SELECT un_arq, SUM(CASE WHEN hora_registro < '12:00:00' THEN 1 ELSE 0 END) as antes_12h00, SUM(CASE WHEN hora_registro >= '12:00:00' THEN 1 ELSE 0 END) as apos_12h00 FROM cadastro GROUP BY un_arq";
$dependenciasResult = $conn->query($dependenciasQuery);

$dependenciasLabels = [];
$dependenciasData = [
    'antes' => [],
    'apos' => []
];

if ($dependenciasResult->num_rows > 0) {
    while ($row = $dependenciasResult->fetch_assoc()) {
        $dependenciasLabels[] = $row['un_arq'];
        $dependenciasData['antes'][] = $row['antes_12h00'];
        $dependenciasData['apos'][] = $row['apos_12h00'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Controle de Arquivos - Novo Dashboard</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="box4">
        <div class="row">
            <form action="login.php" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend><b>DASHBOARD</b></legend>
                    <br>
                    <div class="column">
                        <div class="container">
                            <div class="column4">
                                <div class="chart-container">
                                    <canvas id="usuarios-chart" width="1024" height="768"></canvas>
                                </div>
                            </div>
                            <div class="column">
                                <div class="chart-container">
                                    <canvas id="unidades-chart" width="1024" height="768"></canvas>
                                </div>
                            </div>
                            <div class="column">
                                <div class="chart-container">
                                    <canvas id="dependencias-chart" width="1024" height="768"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="voltar">
                            <?php
                            if (isset($_COOKIE['tipo'])) {
                                if ($_COOKIE['tipo'] == 'cadastrante') {
                                    echo '<button type="button" onclick="location.href=\'cadastrante.php\'">Ir para a página de cadastro</button>';
                                } else if ($_COOKIE['tipo'] == 'gestor') {
                                    echo '<button type="button" onclick="location.href=\'formulario.php\'">Ir para a página de cadastro</button>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

    <script>
        // Função para gerar uma cor aleatória em formato hexadecimal
        function getRandomColor() {
            $characters = '0123456789ABCDEF';
            $color = '#';
            for ($i = 0; $i < 6; $i++) {
                $color = $characters[rand(0, 15)];
            }
            return $color;
        }

        // Gráfico de total de registros por usuário
        var usuariosChartCtx = document.getElementById('usuarios-chart').getContext('2d');
        var usuariosChart = new Chart(usuariosChartCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($usuariosLabels); ?>,
                datasets: [{
                    label: 'Total de Registros por Usuário',
                    data: <?php echo json_encode($usuariosData); ?>,
                    backgroundColor: <?php echo json_encode($usuariosColors); ?>,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                borderWidth: 2,
                borderRadius: 10,
                borderSkipped: false,
                plugins: {
                    legend: {
                        position: 'right',
                        display: false,
                    },
                    title: {
                        display: true,
                        text: 'Registros por Cadastrante'
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            stepSize: 1
                        }
                    }
                },
            },
        });
        // Gráfico de total de registros por unidade arquivística
        var unidadesChartCtx = document.getElementById('unidades-chart').getContext('2d');
        var unidadesChart = new Chart(unidadesChartCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($unidadesLabels); ?>,
                datasets: [{
                    label: 'Total de Registros por Unidade Arquivística',
                    data: <?php echo json_encode($unidadesData); ?>,
                    backgroundColor: <?php echo json_encode($un_arqColors); ?>,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                },
                title: {
                    display: true,
                    text: 'Registros por Unidade de Arquivo'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                },
            },
        });

        // Gráfico de total de registros por dependência antes e após as 12h00
        var dependenciasChartCtx = document.getElementById('dependencias-chart').getContext('2d');
        var dependenciasChart = new Chart(dependenciasChartCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($dependenciasLabels); ?>,
                datasets: [{
                        label: 'Antes das 12h00',
                        data: <?php echo json_encode($dependenciasData['antes']); ?>,
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderWidth: 2,
                        borderRadius: 10,
                        borderSkipped: false,
                    },
                    {
                        label: 'Após as 12h00',
                        data: <?php echo json_encode($dependenciasData['apos']); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderWidth: 2,
                        borderRadius: 10,
                        borderSkipped: false,
                    }
                ]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    title: {
                        display: true,
                        text: 'Registros por Período por Unidade'
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            stepSize: 1
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            }
        });
    </script>

</body>

</html>