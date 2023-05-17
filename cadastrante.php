<?php

if (!isset($_COOKIE['logged_in']) || $_COOKIE['logged_in'] != "true") {
    header("Location: sicontrar.php");
}

if (isset($_POST['submit'])) {

    $matricula = $_COOKIE['matricula'];

    include_once('config.php');

    $un_prod_sigla = strtoupper($_POST['un_prod_sigla']);
    $un_prod_nome = strtoupper($_POST['un_prod_nome']);
    $data_inicio = strtoupper($_POST['data_inicio']);
    $data_fim = strtoupper($_POST['data_fim']);
    $desc_docs = strtoupper($_POST['desc_docs']);
    $un_arq = strtoupper($_POST['un_arq']);
    $conjunto = strtoupper($_POST['conjunto']);
    $rua = strtoupper($_POST['rua']);
    $estante = strtoupper($_POST['estante']);
    $prateleira = strtoupper($_POST['prateleira']);
    $posicao = strtoupper($_POST['posicao']);

    $result = mysqli_query($conexao, "INSERT INTO cadastro(un_prod_sigla,un_prod_nome,data_inicio,data_fim,desc_docs,un_arq,conjunto,rua,estante,prateleira,posicao,matricula) 
        VALUES ('$un_prod_sigla','$un_prod_nome','$data_inicio','$data_fim','$desc_docs','$un_arq','$conjunto','$rua','$estante','$prateleira','$posicao','$matricula')");

    header("Location: cadastro_doc_sucesso.php?un_prod_sigla=$un_prod_sigla&un_prod_nome=$un_prod_nome&data_inicio=$data_inicio&data_fim=$data_fim&desc_docs=$desc_docs&un_arq=$un_arq&conjunto=$conjunto&rua=$rua&estante=$estante&prateleira=$prateleira&posicao=$posicao&matricula=$matricula");

    unset($_POST);
}

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
    function limparCampos() {
        document.getElementById("un_prod_sigla").value = "";
        document.getElementById("un_prod_nome").value = "";
        document.getElementById("data_inicio").value = "";
        document.getElementById("data_fim").value = "";
        document.getElementById("desc_docs").value = "";
        document.getElementById("un_arq").value = "";
        document.getElementById("conjunto").value = "";
        document.getElementById("rua").value = "";
        document.getElementById("estante").value = "";
        document.getElementById("prateleira").value = "";
        document.getElementById("posicao").value = "";
    }

    window.onunload = function() {
        window.sessionStorage.clear();
    }
</script>

<body onload="limparCampos()">

    <div class="sidebar">
        <p>Usuário: <?php
                    if (isset($_COOKIE["matricula"])) {
                        $matricula = $_COOKIE["matricula"];
                    }
                    echo $matricula;
                    ?>
        </p>
        <a class="active" href="cadastrante.php">Cadastrante</a>
        <a href="pesquisa.php">Pesquisa</a>
        <a href="sicontrar.php">Sair</a>
        <br><br><br>
        <div style="position: absolute;bottom: 5%">
            <p>Documentos cadastrados:
                <br>
                <?php
                include_once('config.php');
                $matricula = $_COOKIE['matricula'];
                $query = "SELECT COUNT(matricula) as count FROM cadastro WHERE matricula LIKE '$matricula'";
                $result = mysqli_query($conexao, $query);
                $row = mysqli_fetch_array($result);
                echo $row['count'] . ' documentos';
                ?>
            </p>
        </div>
    </div>

    <div class="box2">
        <div class="row">
            <form action="cadastrante.php" method="post">
                <fieldset>
                    <legend><b>SICONTRAR</b></legend>
                    <br>
                    <div class="column1">
                        <div class="inputBox">
                            <input type="text" name="un_prod_sigla" id="un_prod_sigla" class="inputUser" required>
                            <label for="un_prod_sigla" class="labelInput">Unidade produtora - Sigla</label>
                        </div><br><br>
                        <div class="inputBox">
                            <input type="text" name="un_prod_nome" id="un_prod_nome" class="inputUser" required>
                            <label for="un_prod_nome" class="labelInput">Unidade produtora - Nome</label>
                        </div><br><br>
                        <div class="inputBox">
                            <input type="text" name="data_inicio" id="data_inicio" class="inputUser" required>
                            <label for="data_inicio" class="labelInput">Data-limite Início</label>
                        </div><br><br>
                        <div class="inputBox">
                            <input type="text" name="data_fim" id="data_fim" class="inputUser" required>
                            <label for="data_fim" class="labelInput">Data-limite Fim</label>
                        </div><br><br>
                        <div class="inputBox">
                            <input type="text" name="desc_docs" id="desc_docs" class="inputUser" required>
                            <label for="desc_docs" class="labelInput">Descrição dos documentos</label>
                        </div><br><br>
                        <input type="submit" name="submit" id="submit"><br><br>
                        <input type="reset" name="reset" id="reset">
                    </div>
                    <div class="column2">
                        <div>
                            <fieldset>
                                <legend id="loc"><b>Localização</b></legend><br>
                                <div class="inputBox">
                                    <label for="un_arq" class="labelInput">Unidade de arquivo</label><br><br>
                                    <select name="un_arq" id="un_arq" required autocomplete="off">
                                        <option value=""></option>
                                        <option value="Brasília">Brasília</option>
                                        <option value="Recife">Recife</option>
                                        <option value="São Paulo">São Paulo</option>
                                    </select>
                                </div><br><br>
                                <div class="inputBox">
                                    <input type="text" name="conjunto" id="conjunto" class="inputUser" required>
                                    <label for="conjunto" class="labelInput">Conjunto</label>
                                </div><br><br>
                                <div class="inputBox">
                                    <input type="text" name="rua" id="rua" class="inputUser" required>
                                    <label for="rua" class="labelInput">Rua</label>
                                </div><br><br>
                                <div class="inputBox">
                                    <input type="text" name="estante" id="estante" class="inputUser" required>
                                    <label for="estante" class="labelInput">Estante</label>
                                </div><br><br>
                                <div class="inputBox">
                                    <input type="text" name="prateleira" id="prateleira" class="inputUser" required>
                                    <label for="prateleira" class="labelInput">Prateleira</label>
                                </div><br><br>
                                <div class="inputBox">
                                    <input type="text" name="posicao" id="posicao" class="inputUser" required>
                                    <label for="posicao" class="labelInput">Posição</label>
                                </div>
                            </fieldset>
                        </div><br>
                    </div>
                </fieldset>
            </form>
        </div>

    </div>
</body>

</html>
