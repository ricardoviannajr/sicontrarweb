<?php
// Conexão com o banco de dados
$conexao = mysqli_connect('localhost', 'root', '', 'sicontrar');
// Consulta SQL para selecionar todos os registros da tabela cadastro
$query = "SELECT * FROM cadastro";
$resultado = mysqli_query($conexao, $query);
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
                    <td><?php echo $row['desc_docs'] ?></td>
                    <td><?php echo $row['prazo_guarda'] ?></td>
                    <td><?php echo $row['destino'] ?></td>
                    <td><?php echo $row['un_arq'] ?></td>
                    <td><?php echo $row['conjunto'] . " " . $row['rua'] . " " . $row['estante'] . " " . $row['prateleira'] . " " . $row['posicao'] ?></td>
                    <td><?php echo $row['matricula'] ?></td>
                    <td><a href="edit_page.php?id=<?php echo $row['id']; ?>">Editar</a><br><br>
                      <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja deletar o registro?');">Deletar</a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</body>

</html>