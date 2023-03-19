<?php

if (isset($_POST['submit'])) {
    $matricula = $_POST['matricula'];
    $senha = $_POST['senha'];

    $conn = mysqli_connect("localhost", "root", "", "sicontrar");

    $query = "SELECT * FROM usuarios WHERE matricula='$matricula' AND senha='$senha'";
    $result = mysqli_query($conn, $query);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows > 0) {
        $row = mysqli_fetch_array($result);

        setcookie("logged_in", "true", time() + (86400 * 1), "/");
        setcookie("tipo", $row['tipo'], time() + (86400 * 1), "/");
        setcookie("matricula", $matricula, time() + (86400 * 1), "/");

        if ($row['tipo'] == 'cadastrante') {
            header('Location: cadastrante.php');
        } else if ($row['tipo'] == 'gestor') {
            header('Location: formulario.php');
        }
    } else {
        session_start();
        $_SESSION['login_error'] = "Usuário ou senha inválidos";
        header("Location: sicontrar.php");
        exit();
    }
}
