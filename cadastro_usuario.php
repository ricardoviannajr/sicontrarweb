<?php

if (!isset($_COOKIE['logged_in']) || $_COOKIE['logged_in'] != "true") {
  header("Location: sicontrar.php");
}

if (isset($_POST['submit'])) {
  include_once('config.php');

  $matricula = $_POST['matricula'];
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $senha = $_POST['senha'];
  $tipo = $_POST['tipo'];

  $query = "SELECT * FROM usuarios WHERE matricula='$matricula'";
  $result = mysqli_query($conexao, $query);
  $row = mysqli_fetch_array($result);

  if ($row) {
    echo "<script>alert('Matrícula já cadastrada'); document.getElementById('cadastro_usuario').reset();</script>";
    header("Location: cadastro_sucesso.php?matricula=$matricula&nome=$nome&email=$email&senha=$senha&tipo=$tipo");
  } else {
    $result = mysqli_query($conexao, "INSERT INTO usuarios(matricula,nome,email,senha,tipo) 
            VALUES ('$matricula','$nome','$email','$senha','$tipo')");
    echo "<script>alert('Cadastro realizado com sucesso'); document.getElementById('cadastro_usuario').reset();</script>";
    header("Location: cadastro_user_sucesso.php?matricula=$matricula&nome=$nome&email=$email&senha=$senha&tipo=$tipo");
  }
  unset($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Controle de Arquivos</title>
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <script>
    function validarSenhas() {
      var senha = document.getElementById("senha").value;
      var confirma_senha = document.getElementById("confirma_senha").value;
      var erro_senhas = document.getElementById("erro_senhas");

      if (senha != confirma_senha) {
        erro_senhas.innerHTML = "As senhas não conferem.";
        erro_senhas.style.display = "block";
      } else {
        erro_senhas.style.display = "none";
      }
    }

    function show1() {
      var senha = document.getElementById("senha");
      if (senha.type === "password") {
        senha.type = "text";
      } else {
        senha.type = "password";
      }
    }

    function show2() {
      var confirma_senha = document.getElementById("confirma_senha");
      if (confirma_senha.type === "password") {
        confirma_senha.type = "text";
      } else {
        confirma_senha.type = "password";
      }
    }
  </script>
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
    <a href="cadastro_usuario.php">Cadastro de Usuários</a>
    <a href="sicontrar.php">Sair</a>
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
  <div class="box1">
    <div class="row">
      <form id="cadastro_usuario" action="cadastro_usuario.php" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend><b>Cadastro de Usuários</b></legend>
          <br>
          <div class="column">
            <div class="inputBox">
              <input type="text" class="inputUser" id="matricula" name="matricula" required>
              <label for="matricula" class="labelInput">Matrícula</label>
            </div>
            <br><br>
            <div class="inputBox">
              <input type="text" class="inputUser" id="nome" name="nome" required>
              <label for="nome" class="labelInput">Nome</label>
            </div>
            <br><br>
            <div class="inputBox">
              <input type="text" class="inputUser" id="email" name="email" required>
              <label for="email" class="labelInput">E-mail</label>
            </div>
            <br><br>
            <div class="inputBox">
              <input type="password" class="inputUser" id="senha" name="senha" required>
              <br><br>
              <input type="checkbox" id="checksenha" onclick="show1()"><label for="checksenha" class="mostrasenha">Exibir Senha</label>
              <label for="senha" class="labelInput">Senha</label>
            </div>
            <br><br>
            <div class="inputBox">
              <input type="password" class="inputUser" id="confirma_senha" name="confirma_senha" required onblur="validarSenhas()">
              <br><br>
              <input type="checkbox" id="checksenha" onclick="show2()"><label for="checksenha" class="mostrasenha">Exibir Senha</label>
              <label for="confirma_senha" class="labelInput">Confirme sua Senha</label>
            </div>
            <br>
            <span id="erro_senhas" style="display: none; color: red;">As senhas não conferem!</span>
            <p>Acesso:</p>
            <input type="radio" id="cadastrante" name="tipo" value="cadastrante" required>
            <label for="cadastrante">Cadastrante</label>
            <br>
            <input type="radio" id="gestor" name="tipo" value="gestor" required>
            <label for="gestor">Gestor</label>
            <br><br>
            <div class="inputBox">
              <input type="submit" name="submit" id="submit">
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</body>

</html>