<?php
// Inclua aqui qualquer código PHP necessário para processamento de dados ou outras funcionalidades
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Controle de Arquivos</title>
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <style>
    /* Adicione aqui seus estilos personalizados ou importe arquivos CSS externos */
  </style>
</head>

<body>
  <div class="box4">
    <div class="row">
      <form action="login.php" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend><b>TITULO</b></legend>
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
          </div>
        </fieldset>
      </form>
    </div>
  </div>

  <script>
    // Adicione aqui seus scripts personalizados ou importe arquivos JavaScript externos
  </script>
</body>

</html>