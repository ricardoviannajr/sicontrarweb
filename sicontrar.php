<?php
session_start();
if (isset($_SESSION['login_error'])) {
  echo "<script>alert('" . htmlspecialchars($_SESSION['login_error']) . "');</script>";
  unset($_SESSION['login_error']);
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
    function show1() {
      var senha = document.getElementById("senha");
      if (senha.type === "password") {
        senha.type = "text";
      } else {
        senha.type = "password";
      }
    }
  </script>
</head>

<body>
  <div class="box1">
    <div class="row">
      <form action="login.php" method="post" enctype="multipart/form-data" autocomplete="off">
        <fieldset>
          <legend><b>SICONTRAR</b></legend>
          <br>
          <div class="column">
            <div class="inputBox">
              <input type="text" class="inputUser" style="text-transform: uppercase" id="matricula" name="matricula" required autocomplete="off">
              <label for="matricula" class="labelInput">Matrícula</label>
            </div>
            <br><br>
            <div class="inputBox">
              <input type="password" class="inputUser" id="senha" name="senha" required autocomplete="off">
              </br></br>
              <input type="checkbox" id="checksenha" onclick="show1()"><label for="checksenha" class="mostrasenha">Exibir Senha</label>
              <label for="senha" class="labelInput">Senha</label>
            </div>
            <br><br>
            <div class="inputBox">
              <input type="submit" name="submit" id="submit">
            </div>
            <div class="error-message">
              <?php
              if (isset($_SESSION['login_error'])) {
                echo $_SESSION['login_error'];
                unset($_SESSION['login_error']);
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
