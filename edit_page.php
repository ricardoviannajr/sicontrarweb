<?php
$conexao = mysqli_connect("localhost", "root", "", "sicontrar");
if (!isset($_GET['id'])) {
  echo "Erro: id não encontrado.";
  exit;
}
$id = $_GET['id'];
$sql = "SELECT * FROM cadastro WHERE id = $id";
$result = mysqli_query($conexao, $sql);
if (!$result) {
  echo "Erro: não foi possível executar a consulta.";
  exit;
}

$row = mysqli_fetch_assoc($result);
if (!$row) {
  echo "Erro: registro não encontrado.";
  exit;
}

$data_transf_cust = $row['data_transf_cust'];
$doc_encam = $row['doc_encam'];
$un_prod_sigla = $row['un_prod_sigla'];
$un_prod_nome = $row['un_prod_nome'];
$cx_num_ant = $row['cx_num_ant'];
$cx_num_cust = $row['cx_num_cust'];
$cod_clas_doc = $row['cod_clas_doc'];
$data_inicio = $row['data_inicio'];
$data_fim = $row['data_fim'];
$desc_docs = $row['desc_docs'];
$prazo_guarda = $row['prazo_guarda'];
$destino = $row['destino'];
$un_arq = $row['un_arq'];
$conjunto = $row['conjunto'];
$rua = $row['rua'];
$estante = $row['estante'];
$prateleira = $row['prateleira'];
$posicao = $row['posicao'];

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

  <div class="sidebar">
    <p>Usuário: <?php
                if (isset($_COOKIE["matricula"])) {
                  $matricula = $_COOKIE["matricula"];
                }
                echo $matricula;
                ?>
    </p>
    <a class="active" href="formulario.php">Gestão de Cadastros</a>
    <a href="cadastrante.php">Cadastrante</a>
    <a href="listagem.php">Listagem de Caixas</a>
    <a href="sicontrar.php">Sair</a>

    <!--
        <div>
            <h3>
                <center>Últimos 10 Registros</center>
            </h3>
            <? php/*
            include_once('config.php');
            $query = "SELECT matricula FROM cadastro ORDER BY id DESC LIMIT 10";
            $result = mysqli_query($conexao, $query);
            $matriculas = array();
            while ($row = mysqli_fetch_array($result)) {
                $matriculas[] = $row['matricula'];
            }
            $matriculas_unique = array_unique($matriculas);
            echo '<ul>';
            foreach ($matriculas_unique as $matricula) {
                echo '<li>' . $matricula . '</li>';
            }
            echo '</ul>';
            */ ?>
        </div>
        -->

    <div style="position: absolute;bottom: 25%;font-size: smaller;">
      <p>
      <h3 style="text-align: center;">Top 10</h3>
      <?php
      include_once('config.php');
      $query = "SELECT matricula, COUNT(matricula) as count FROM cadastro GROUP BY matricula ORDER BY count DESC LIMIT 10";
      $result = mysqli_query($conexao, $query);
      echo '<ul>';
      while ($row = mysqli_fetch_array($result)) {
        echo '<li>' . $row['matricula'] . ' - ' . $row['count'] . ' registros' . '</li>';
      }
      echo '</ul>';
      ?>
      </p>
    </div>
  </div>


  <div class="box2">
    <div class="row">
      <form action="update.php" method="post">
        <fieldset>
          <legend><b>SICONTRAR</b></legend>
          <br>
          <div class="column1">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="inputBox">
              <input type="text" name="data_transf_cust" id="data_transf_cust" class="inputUser" value="<?php echo $data_transf_cust; ?>">
              <label for="doc_encam" class="labelInput">Data de transferência ao arquivo de custódia</label>
            </div><br><br>
            <div class="inputBox">
              <input type="text" name="doc_encam" id="doc_encam" class="inputUser" value="<?php echo $doc_encam; ?>">
              <label for="doc_encam" class="labelInput">Documento de encaminhamento</label>
            </div><br><br>
            <div class="inputBox">
              <input type="text" name="un_prod_sigla" id="un_prod_sigla" class="inputUser" value="<?php echo $un_prod_sigla; ?>">
              <label for="un_prod_sigla" class="labelInput">Unidade produtora - Sigla</label>
            </div><br><br>
            <div class="inputBox">
              <input type="text" name="un_prod_nome" id="un_prod_nome" class="inputUser" value="<?php echo $un_prod_nome; ?>">
              <label for="un_prod_nome" class="labelInput">Unidade produtora - Nome</label>
            </div><br><br>
            <div class="inputBox">
              <input type="text" name="cx_num_ant" id="cx_num_ant" class="inputUser" value="<?php echo $cx_num_ant; ?>">
              <label for="cx_num_ant" class="labelInput">Caixa - Número anterior</label>
            </div><br><br>
            <div class="inputBox">
              <input type="text" name="cx_num_cust" id="cx_num_cust" class="inputUser" value="<?php echo $cx_num_cust; ?>">
              <label for="cx_num_cust" class="labelInput">Caixa - Número custódia</label>
            </div><br><br>
            <div class="inputBox">
              <input type="text" name="cod_clas_doc" id="cod_clas_doc" class="inputUser" value="<?php echo $cod_clas_doc ?>">
              <label for="cod_clas_doc" class="labelInput">Código classificação documental</label>
            </div><br><br>
            <div class="inputBox">
              <input type="text" name="data_inicio" id="data_inicio" class="inputUser" value="<?php echo $data_inicio; ?>">
              <label for="data_inicio" class="labelInput">Data-limite Início</label>
            </div><br><br>
            <div class="inputBox">
              <input type="text" name="data_fim" id="data_fim" class="inputUser" value="<?php echo $data_fim; ?>">
              <label for=" data_fim" class="labelInput">Data-limite fim</label>
            </div><br><br>
            <div class="inputBox">
              <input type="text" name="desc_docs" id="desc_docs" class="inputUser" value="<?php echo $desc_docs; ?>">
              <label for="desc_docs" class="labelInput">Descrição dos documentos</label>
            </div><br><br>
            <div class="inputBox">
              <input type="text" name="prazo_guarda" id="prazo_guarda" class="inputUser" value="<?php echo $prazo_guarda; ?>">
              <label for="prazo_guarda" class="labelInput">Prazo de Guarda</label>
            </div>
          </div>
          <div class="column2">
            <p>Destinação:</p>
            <input type="radio" id="eliminar" name="destino" value="eliminar" <?php if ($destino === 'eliminar') echo 'checked'; ?>>
            <label for="eliminar">EL - Eliminar</label>
            <br>
            <input type="radio" id="permanente" name="destino" value="permanente" <?php if ($destino === 'permanente') echo 'checked'; ?>>
            <label for="permanente">PE - Permanente</label>
            <br><br>
            <div>
              <fieldset>
                <legend id="loc"><b>Localização</b></legend><br>
                <div class="inputBox">
                  <input type="text" name="un_arq" id="un_arq" class="inputUser" value="<?php echo $un_arq; ?>">
                  <label for="un_arq" class="labelInput">Unidade de arquivo</label>
                </div><br><br>
                <div class="inputBox">
                  <input type="text" name="conjunto" id="conjunto" class="inputUser" value="<?php echo $conjunto; ?>">
                  <label for="conjunto" class="labelInput">Conjunto</label>
                </div><br><br>
                <div class="inputBox">
                  <input type="text" name="rua" id="rua" class="inputUser" value="<?php echo $rua; ?>">
                  <label for="rua" class="labelInput">Rua</label>
                </div><br><br>
                <div class="inputBox">
                  <input type="text" name="estante" id="estante" class="inputUser" value="<?php echo $estante; ?>">
                  <label for="estante" class="labelInput">Estante</label>
                </div><br><br>
                <div class="inputBox">
                  <input type="text" name="prateleira" id="prateleira" class="inputUser" value="<?php echo $prateleira; ?>">
                  <label for="prateleira" class="labelInput">Prateleira</label>
                </div><br><br>
                <div class="inputBox">
                  <input type="text" name="posicao" id="posicao" class="inputUser" value="<?php echo $posicao; ?>">
                  <label for="posicao" class="labelInput">Posição</label>
                </div>
              </fieldset>
            </div><br>
            <input type="submit" value="Atualizar" id="submit"><br><br>
            <input type="reset" name="reset" id="reset">
          </div>
        </fieldset>
      </form>
    </div>

  </div>
</body>

</html>