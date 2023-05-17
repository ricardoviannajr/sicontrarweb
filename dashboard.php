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
// Consulta para obter o total geral de registros
$query_total = "SELECT COUNT(*) AS total_geral FROM cadastro";
$result_total = $conn->query($query_total);
$row_total = $result_total->fetch_assoc();
$total_geral = (int) $row_total['total_geral'];

// Consulta para obter a contagem de registros por unidade arquivística e período (manhã/tarde)
$query_periodo = "SELECT un_arq, CASE WHEN HOUR(hora_registro) < 12 THEN 'Manhã' ELSE 'Tarde' END AS periodo, COUNT(*) AS total_registros FROM cadastro GROUP BY un_arq, periodo";
$result_periodo = $conn->query($query_periodo);

$data_periodo = array();

while ($row = $result_periodo->fetch_assoc()) {
    $data_periodo[] = array(
        'un_arq' => $row['un_arq'],
        'periodo' => $row['periodo'],
        'total_registros' => (int)$row['total_registros']
    );
}

$data_percentual = array();

// Calcula os percentuais de registros para cada unidade arquivística
foreach ($data_unidades as $unidade) {
    $un_arq = $unidade[0];
    $total_registros_unidade = $unidade[1];
    $registros_manha = 0;
    $registros_tarde = 0;

    // Encontra os registros da unidade arquivística atual
    $registros_unidade = array_filter($data_periodo, function ($item) use ($un_arq) {
        return $item['un_arq'] === $un_arq;
    });

    // Calcula a contagem de registros para cada período (manhã/tarde)
    foreach ($registros_unidade as $registro) {
        if ($registro['periodo'] === 'Manhã') {
            $registros_manha += $registro['total_registros'];
        } else {
            $registros_tarde += $registro['total_registros'];
        }
    }

    // Calcula os percentuais
    $percentual_manha = ($total_registros_unidade > 0) ? ($registros_manha / $total_registros_unidade) * 100 : 0;
    $percentual_tarde = ($total_registros_unidade > 0) ? ($registros_tarde / $total_registros_unidade) * 100 : 0;

    $data_percentual[] = array(
        'un_arq' => $un_arq,
        'manha' => $percentual_manha,
        'tarde' => $percentual_tarde
    );
}

// Consulta para obter a quantidade de registros por usuário com seus respectivos nomes e matrículas
$query_usuarios = "SELECT u.matricula, u.nome, COUNT(*) AS total_registros FROM cadastro c JOIN usuarios u ON c.matricula = u.matricula GROUP BY u.matricula, u.nome";
$result_usuarios = $conn->query($query_usuarios);

$data_usuarios = array();

while ($row = $result_usuarios->fetch_assoc()) {
    $data_usuarios[] = array(
        'matricula' => $row['matricula'],
        'nome' => $row['nome'],
        'total_registros' => (int)$row['total_registros']
    );
}

// Consulta para obter a quantidade de registros por unidade arquivística
$query_unidades = "SELECT un_arq, COUNT(*) AS total_registros FROM cadastro GROUP BY un_arq";
$result_unidades = $conn->query($query_unidades);

// Consulta para obter a contagem de registros por período de tempo e unidade arquivística
$query_registros = "SELECT DATE_FORMAT(data_registro, '%Y-%m') AS periodo, un_arq, COUNT(*) AS total_registros FROM cadastro GROUP BY periodo, un_arq";
$result_registros = $conn->query($query_registros);

// Criação de arrays para os dados do gráfico
$data_usuarios = array();
$data_unidades = array();
$data_registros = array();
$unidades_arquivisticas = array();

// Preenchimento dos arrays com os dados do banco de dados
while ($row = $result_usuarios->fetch_assoc()) {
    $data_usuarios[] = array((string)$row['matricula'], $row['nome'], (int)$row['total_registros']);
}

while ($row = $result_unidades->fetch_assoc()) {
    $data_unidades[] = array($row['un_arq'], (int)$row['total_registros']);
    $unidades_arquivisticas[] = $row['un_arq'];
}

while ($row = $result_registros->fetch_assoc()) {
    $data_registros[$row['periodo']][$row['un_arq']] = (int)$row['total_registros'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Controle de Arquivos - Dashboard</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f3f3;
        }

        .box5 {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .column {
            flex: 50%;
            max-width: 50%;
        }
    </style>
</head>

<body>
    <div class="box5">
        <h1>Dashboard - Distribuição dos Registros</h1>
        <p>Total Geral de Registros: <?php echo $total_geral; ?></p>
        <div class="row">
            <div class="column">
                <div id="chart_usuarios"></div>
            </div>
            <div class="column">
                <div id="chart_unidades"></div>
            </div>
            <div class="column">
                <div id="chart_registros"></div>
            </div>
            <div class="column">
                <div id="chart_percentual"></div>
            </div>
        </div>
    </div>

    <script>
        // Carrega a biblioteca de visualização do Google Charts
        google.charts.load('current', {
            'packages': ['corechart']
        });

        // Chama a função de desenhar os gráficos quando a biblioteca estiver pronta
        google.charts.setOnLoadCallback(drawCharts);

        // Função para desenhar os gráficos
        function drawCharts() {
            // Gráfico de Distribuição dos Registros por Usuário
            var dataUsuarios = new google.visualization.DataTable();
            dataUsuarios.addColumn('string', 'Matrícula');
            dataUsuarios.addColumn('number', 'Total de Registros');
            dataUsuarios.addColumn({
                type: 'string',
                role: 'tooltip'
            });
            dataUsuarios.addColumn({
                type: 'string',
                role: 'style'
            });

            var usuariosData = <?php echo json_encode($data_usuarios); ?>;
            var formattedUsuariosData = usuariosData.map(function(item) {
                return [item[0], item[2], item[0] + ': ' + item[1] + ' - Registros: ' + item[2], 'color: #3366cc'];
            });

            dataUsuarios.addRows(formattedUsuariosData);

            var optionsUsuarios = {
                title: 'Distribuição dos Registros por Usuário',
                height: 400,
                legend: {
                    position: 'none'
                },
                tooltip: {
                    isHtml: true
                }
            };

            var chartUsuarios = new google.visualization.ColumnChart(document.getElementById('chart_usuarios'));
            chartUsuarios.draw(dataUsuarios, optionsUsuarios);


            // Gráfico de Distribuição dos Registros por Unidade Arquivística
            var dataUnidades = new google.visualization.DataTable();
            dataUnidades.addColumn('string', 'Unidade Arquivística');
            dataUnidades.addColumn('number', 'Total de Registros');
            dataUnidades.addRows(<?php echo json_encode($data_unidades); ?>);

            var optionsUnidades = {
                title: 'Distribuição dos Registros por Unidade Arquivística',
                height: 400,
                legend: {
                    position: 'none'
                }
            };

            var chartUnidades = new google.visualization.ColumnChart(document.getElementById('chart_unidades'));
            chartUnidades.draw(dataUnidades, optionsUnidades);

            // Gráfico de Distribuição dos Registros por Período de Tempo
            var dataRegistros = new google.visualization.DataTable();
            dataRegistros.addColumn('date', 'Período');

            // Adiciona as colunas para cada unidade arquivística
            var unidadesArquivisticas = <?php echo json_encode($unidades_arquivisticas); ?>;
            unidadesArquivisticas.forEach(function(unidade) {
                dataRegistros.addColumn('number', unidade);
            });

            // Preenche os dados do gráfico
            var registrosData = <?php echo json_encode($data_registros); ?>;
            var registrosAgrupados = [];

            for (var periodo in registrosData) {
                if (registrosData.hasOwnProperty(periodo)) {
                    var registro = [new Date(periodo)];
                    var periodoData = registrosData[periodo];

                    unidadesArquivisticas.forEach(function(unidade) {
                        var totalRegistros = periodoData.hasOwnProperty(unidade) ? periodoData[unidade] : null;
                        registro.push(totalRegistros);
                    });

                    registrosAgrupados.push(registro);
                }
            }

            dataRegistros.addRows(registrosAgrupados);

            var optionsRegistros = {
                title: 'Distribuição dos Registros por Período de Tempo',
                height: 400,
                isStacked: true,
                hAxis: {
                    format: 'MMM yyyy' // Formato da data exibida no eixo horizontal
                },
                vAxis: {
                    title: 'Total de Registros'
                },
                series: {
                    0: {
                        color: '#3366cc'
                    }, // Cor para a primeira unidade arquivística
                    1: {
                        color: '#dc3912'
                    }, // Cor para a segunda unidade arquivística
                    2: {
                        color: '#ff9900'
                    } // Cor para a terceira unidade arquivística
                }
            };

            var chartRegistros = new google.visualization.ColumnChart(document.getElementById('chart_registros'));
            chartRegistros.draw(dataRegistros, optionsRegistros);
        }
        // Função para desenhar o gráfico aninhado
        function drawNestedChart() {
            var dataPercentual = new google.visualization.DataTable();
            dataPercentual.addColumn('string', 'Unidade Arquivística');
            dataPercentual.addColumn('number', 'Manhã');
            dataPercentual.addColumn('number', 'Tarde');

            var percentualData = <?php echo json_encode($data_percentual); ?>;
            var formattedPercentualData = percentualData.map(function(item) {
                return [item.un_arq, item.manha, item.tarde];
            });

            dataPercentual.addRows(formattedPercentualData);

            var optionsPercentual = {
                title: 'Percentual de Registros por Unidade Arquivística e Período',
                height: 400,
                isStacked: true,
                hAxis: {
                    title: 'Unidade Arquivística'
                },
                vAxis: {
                    title: 'Percentual de Registros (%)',
                    minValue: 0,
                    maxValue: 100
                },
                series: {
                    0: {
                        color: '#3366cc'
                    }, // Manhã
                    1: {
                        color: '#dc3912'
                    } // Tarde
                },
                legend: {
                    position: 'top'
                }
            };

            var chartPercentual = new google.visualization.ColumnChart(document.getElementById('chart_percentual'));
            chartPercentual.draw(dataPercentual, optionsPercentual);
        }

        // Chama a função de desenhar os gráficos quando a biblioteca estiver pronta
        google.charts.setOnLoadCallback(function() {
            drawCharts();
            drawNestedChart(); // Adiciona a chamada para o novo gráfico
        });
    </script>
</body>

</html>