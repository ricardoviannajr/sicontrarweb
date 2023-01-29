<?php

$matricula = $_GET['matricula'];
$nome = $_GET['nome'];
$email = $_GET['email'];
$senha = $_GET['senha'];
$tipo = $_GET['tipo'];

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
            <h2>Usuário cadastrado com sucesso!</h2>
            <table id=tabela_usuarios>
              <thead>
                <tr>
                  <th>Matrícula</th>
                  <th>Nome</th>
                  <th>E-mail</th>
                  <th>Tipo</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><?php echo $matricula ?></td>
                  <td><?php echo $nome ?></td>
                  <td><?php echo $email ?></td>
                  <td><?php echo $tipo ?></td>
                </tr>
              </tbody>
            </table>
          </div> 
        </fieldset>
      </div>
    </div>

  </body>
</html>