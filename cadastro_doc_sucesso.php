<?php

$un_prod_sigla = $_GET['un_prod_sigla'];
$un_prod_nome = $_GET['un_prod_nome'];
$data_inicio = $_GET['data_inicio'];
$data_fim = $_GET['data_fim'];
$desc_docs = $_GET['desc_docs'];
$un_arq = $_GET['un_arq'];
$conjunto = $_GET['conjunto'];
$rua = $_GET['rua'];
$estante = $_GET['estante'];
$prateleira = $_GET['prateleira'];
$posicao = $_GET['posicao'];
$matricula = $_GET['matricula'];


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

  <div class="box3">
    <div class="row">
      <fieldset>
        <legend><b>SICONTRAR</b></legend>
        <br>
        <div class="column3">
          <h2>
            <center>Documento cadastrado com sucesso!</center>
          </h2>
          <br><br>
          <table id=listagem style="width:100%">
            <thead>
              <tr>
                <th>Sigla da Unidade Produtora</th>
                <th>Nome da Unidade Produtora</th>
                <th>Data de Início</th>
                <th>Data de Fim</th>
                <th>Descrição dos Documentos</th>
                <th>Unidade de Arquivo</th>
                <th>Conjunto</th>
                <th>Rua</th>
                <th>Estante</th>
                <th>Prateleira</th>
                <th>Posição</th>
                <th>Matrícula</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo $un_prod_nome ?></td>
                <td><?php echo $un_prod_sigla ?></td>
                <td><?php echo $data_inicio ?></td>
                <td><?php echo $data_fim ?></td>
                <td><?php echo $desc_docs ?></td>
                <td><?php echo $un_arq ?></td>
                <td><?php echo $conjunto ?></td>
                <td><?php echo $rua ?></td>
                <td><?php echo $estante ?></td>
                <td><?php echo $prateleira ?></td>
                <td><?php echo $posicao ?></td>
                <td><?php echo $matricula ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </fieldset>
    </div>
  </div>

</body>

</html>