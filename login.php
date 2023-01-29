<?php
    if(isset($_POST['submit'])){
        $matricula = $_POST['matricula'];
        $senha = $_POST['senha'];

        $conn = mysqli_connect("localhost", "root", "", "sicontrar");

        $query = "SELECT * FROM usuarios WHERE matricula='$matricula' AND senha='$senha'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);

        setcookie("logged_in", "true", time() + (86400 * 1), "/");
        setcookie("tipo", $row['tipo'], time() + (86400 * 1), "/");

        if($row){
            if($row['tipo'] == 'cadastrante'){
                //redirect to cadastrante page
                header('Location: cadastrante.php');
            }else if($row['tipo'] == 'gestor'){
                //redirect to formulario page
                header('Location: formulario.php');
            }
        }else{
            echo "Usuário ou senha inválidos";
        }
    }
?>