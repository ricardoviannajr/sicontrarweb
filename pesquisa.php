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

// Verifica se a pesquisa foi submetida
if (isset($_POST['search'])) {
    $search_terms = explode(' ', $_POST['search_term']); // divide os termos por espaço
    $sql = "SELECT * FROM cadastro WHERE ";
    foreach ($search_terms as $term) {
        $sql .= "(data_transf_cust LIKE '%$term%' OR 
                  doc_encam LIKE '%$term%' OR 
                  un_prod_sigla LIKE '%$term%' OR 
                  un_prod_nome LIKE '%$term%' OR 
                  cx_num_ant LIKE '%$term%' OR 
                  cx_num_cust LIKE '%$term%' OR 
                  cod_clas_doc LIKE '%$term%' OR 
                  data_inicio LIKE '%$term%' OR 
                  data_fim LIKE '%$term%' OR 
                  desc_docs LIKE '%$term%' OR 
                  prazo_guarda LIKE '%$term%' OR 
                  destino LIKE '%$term%' OR 
                  un_arq LIKE '%$term%' OR 
                  conjunto LIKE '%$term%' OR 
                  rua LIKE '%$term%' OR 
                  estante LIKE '%$term%' OR 
                  prateleira LIKE '%$term%' OR 
                  posicao LIKE '%$term%' OR 
                  matricula LIKE '%$term%') AND ";
    }
    $sql = substr($sql, 0, -5); // remove o último "AND" da consulta
    $result = $conn->query($sql);
} else {
    $result = null;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Controle de Arquivos</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
</head>

<body>
    <div class="box6">
        <div class="row">
            <fieldset>
                <legend><b>Pesquisar</b></legend>
                <br>
                <div class="column">
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
                    <form method="post">
                        <input type="text" name="search_term" class="searchbox">
                        <input type="submit" name="search" value="Pesquisar">
                    </form>
                    <br>
                    <?php
                    // Exibe os resultados em uma tabela
                    // Exibe os resultados em uma tabela
                    if ($result != null && $result->num_rows > 0) {
                        echo "<table id=listagem>";
                        echo "<tr><th>Data Transferência</th><th>Doc Encaminhado</th><th>Un Prod Sigla</th><th>Un Prod Nome</th><th>CX Número Anterior</th><th>CX Número de Custódia</th><th>Cod Classe Doc</th><th>Data Início</th><th>Data Fim</th><th>Descrição</th><th>Prazo de Guarda</th><th>Destino</th><th>Unidade Arquivística</th><th>Conjunto</th><th>Rua</th><th>Estante</th><th>Prateleira</th><th>Posição</th><th>Matrícula</th><th>Ações</th></tr>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["data_transf_cust"] . "</td>";
                            echo "<td>" . $row["doc_encam"] . "</td>";
                            echo "<td>" . $row["un_prod_sigla"] . "</td>";
                            echo "<td>" . $row["un_prod_nome"] . "</td>";
                            echo "<td>" . $row["cx_num_ant"] . "</td>";
                            echo "<td>" . $row["cx_num_cust"] . "</td>";
                            echo "<td>" . $row["cod_clas_doc"] . "</td>";
                            echo "<td>" . $row["data_inicio"] . "</td>";
                            echo "<td>" . $row["data_fim"] . "</td>";
                            echo "<td>" . $row["desc_docs"] . "</td>";
                            echo "<td>" . $row["prazo_guarda"] . "</td>";
                            echo "<td>" . $row["destino"] . "</td>";
                            echo "<td>" . $row["un_arq"] . "</td>";
                            echo "<td>" . $row["conjunto"] . "</td>";
                            echo "<td>" . $row["rua"] . "</td>";
                            echo "<td>" . $row["estante"] . "</td>";
                            echo "<td>" . $row["prateleira"] . "</td>";
                            echo "<td>" . $row["posicao"] . "</td>";
                            echo "<td>" . $row["matricula"] . "</td>";
                            echo '<td class="btn-group">';
                            echo '<button type="button" onclick="location.href=\'edit_page.php?id=' . $row['id'] . '\'">Editar</button>';
                            echo '<button type="button" onclick="if (confirm(\'Tem certeza que deseja deletar o registro?\')) { window.location.href = \'delete.php?id=' . $row['id'] . '\'; }">Deletar</button>';
                            echo '</td>';
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "Nenhum resultado encontrado.";
                    }
                    // Fecha a conexão com o banco de dados
                    $conn->close();
                    ?>
                </div>
        </div>

</body>

</html>
