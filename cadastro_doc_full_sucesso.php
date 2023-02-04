<?php

$data_transf_cust = $_GET['data_transf_cust'];
$doc_encam = $_GET['doc_encam'];
$un_prod_sigla = $_GET['un_prod_sigla'];
$un_prod_nome = $_GET['un_prod_nome'];
$cx_num_ant = $_GET['cx_num_ant'];
$cx_num_cust = $_GET['cx_num_cust'];
$cod_clas_doc = $_GET['cod_clas_doc'];
$data_inicio = $_GET['data_inicio'];
$data_fim = $_GET['data_fim'];
$desc_docs = $_GET['desc_docs'];
$prazo_guarda = $_GET['prazo_guarda'];
$destino = $_GET['destino'];
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

<script>
  window.onunload = function() {
    window.sessionStorage.clear();
  }
</script>

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
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo $data_transf_cust ?></td>
                <td><?php echo $doc_encam ?></td>
                <td><?php echo $un_prod_nome ?></td>
                <td><?php echo $un_prod_sigla ?></td>
                <td><?php echo $cx_num_ant ?></td>
                <td><?php echo $cx_num_cust ?></td>
                <td><?php echo $cod_clas_doc ?></td>
                <td><?php echo $data_inicio ?></td>
                <td><?php echo $data_fim ?></td>
                <td><?php echo $desc_docs ?></td>
                <td><?php echo $prazo_guarda ?></td>
                <td><?php echo $destino ?></td>
                <td><?php echo $un_arq ?></td>
                <td><?php echo $conjunto . " " . $rua . " " . $estante . " " . $prateleira . " " . $posicao ?></td>
                <td><?php echo $matricula ?></td>
              </tr>
            </tbody>
          </table><br>
          <div class="div_center">
            <input type="button" id="button" value="Voltar" onclick="window.location.href='formulario.php'">
          </div>
        </div>
      </fieldset>
    </div>
  </div>

</body>

</html>