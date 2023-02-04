<?php

if (!isset($_COOKIE['logged_in']) || $_COOKIE['logged_in'] != "true") {
  header("Location: sicontrar.php");
}

// Configurações de paginação
$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
$registros_por_pagina = 10;
$inicio = ($registros_por_pagina * $pagina) - $registros_por_pagina;

// Conexão com o banco de dados
$conexao = mysqli_connect('localhost', 'root', '', 'sicontrar');
// Consulta SQL para selecionar todos os registros da tabela cadastro
$query = "SELECT * FROM cadastro LIMIT $inicio, $registros_por_pagina";
$resultado = mysqli_query($conexao, $query);

// Consulta para contar o número total de registros
$query_total = "SELECT COUNT(*) AS total FROM cadastro";
$resultado_total = mysqli_query($conexao, $query_total);
$total = mysqli_fetch_assoc($resultado_total)['total'];
$paginas = ceil($total / $registros_por_pagina);
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
  <div class="box4">
    <div class="row">
      <form action="login.php" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend><b>Documentos Cadastrados</b></legend>
          <br>
          <div class="column">
            <table id=listagem>
              <thead>
                <tr>
                  <th>Data de Transferência</th>
                  <th>Documento Encaminhado</th>
                  <th>Sigla da Unidade Produtora</th>
                  <th>Nome da Unidade Produtora</th>
                  <th>Número Antigo da Caixa</th>
                  <th>Número de Custódia</th>
                  <th>Código da Classe de Documento</th>
                  <th>Data de Início</th>
                  <th>Data de Fim</th>
                  <th>Descrição dos Documentos</th>
                  <th>Prazo de Guarda</th>
                  <th>Destino</th>
                  <th>Unidade de Arquivo</th>
                  <th>Localização</th>
                  <th>Matrícula</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($resultado)) {
                ?>
                  <tr>
                    <td><?php echo $row['data_transf_cust'] ?></td>
                    <td><?php echo $row['doc_encam'] ?></td>
                    <td><?php echo $row['un_prod_sigla'] ?></td>
                    <td><?php echo $row['un_prod_nome'] ?></td>
                    <td><?php echo $row['cx_num_ant'] ?></td>
                    <td><?php echo $row['cx_num_cust'] ?></td>
                    <td><?php echo $row['cod_clas_doc'] ?></td>
                    <td><?php echo $row['data_inicio'] ?></td>
                    <td><?php echo $row['data_fim'] ?></td>
                    <td class="descricao"><?php echo $row['desc_docs'] ?></td>
                    <td><?php echo $row['prazo_guarda'] ?></td>
                    <td><?php echo $row['destino'] ?></td>
                    <td><?php echo $row['un_arq'] ?></td>
                    <td><?php echo $row['conjunto'] . " " . $row['rua'] . " " . $row['estante'] . " " . $row['prateleira'] . " " . $row['posicao'] ?></td>
                    <td><?php echo $row['matricula'] ?></td>
                    <td class="btn-group"><button type="button" onclick="location.href='edit_page.php?id=<?php echo $row['id']; ?>'">Editar</button>
                      <button type="button" onclick="if (confirm('Tem certeza que deseja deletar o registro?')) { window.location.href = 'delete.php?id=<?php echo $row['id']; ?>'; }">Deletar</button>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table><br>
            <div class="pagination">
              <?php
              if ($pagina > 1) {
                echo "<a href='listagem.php?pagina=" . ($pagina - 1) . "'>Anterior </a>";
              }
              if ($pagina > 2) {
                echo "<a href='listagem.php?pagina=" . ($pagina - 3) . "'> ... </a>";
              }
              if ($pagina > 1) {
                echo "<a href='listagem.php?pagina=" . ($pagina - 1) . "'>" .  ($pagina - 1)  . "</a>";
              }
              echo "<b>" . $pagina . "</b>";
              if ($pagina < $total) {
                echo "<a href='listagem.php?pagina=" . ($pagina + 1) . "'>" .  ($pagina + 1)  . "</a>";
              }
              if ($pagina < $total - 1) {
                echo "<a href='listagem.php?pagina=" . ($pagina + 2) . "'> ... </a>";
              }
              if ($pagina < $total) {
                echo "<a href='listagem.php?pagina=" . ($pagina + 1) . "'> Próximo</a>";
              }
              ?>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</body>

</html>