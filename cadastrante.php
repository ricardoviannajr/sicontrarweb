<?php

$matricula = $_COOKIE['matricula'];

if (isset($_POST['submit'])) {
    /* 
        print_r($_POST['data_transf_cust']);
        print_r($_POST['doc_encam']);
        print_r($_POST['un_prod_sigla']);
        print_r($_POST['un_prod_nome']);
        print_r($_POST['cx_num_ant']);
        print_r($_POST['cx_num_cust']);
        print_r($_POST['cod_clas_doc']);
        print_r($_POST['data_lim']);
        print_r($_POST['desc_docs']);
        print_r($_POST['prazo_guarda']);
        print_r($_POST['destino']);
        print_r($_POST['un_arq']);
        print_r($_POST['conjunto']);
        print_r($_POST['estante']);
        print_r($_POST['prateleira']);   
        */

    include_once('config.php');

    $un_prod_sigla = $_POST['un_prod_sigla'];
    $un_prod_nome = $_POST['un_prod_nome'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];
    $desc_docs = $_POST['desc_docs'];
    $un_arq = $_POST['un_arq'];
    $conjunto = $_POST['conjunto'];
    $rua = $_POST['rua'];
    $estante = $_POST['estante'];
    $prateleira = $_POST['prateleira'];
    $posicao = $_POST['posicao'];
    $matricula = $_POST['matricula'];

    $result = mysqli_query($conexao, "INSERT INTO cadastro(un_prod_sigla,un_prod_nome,data_inicio,data_fim,desc_docs,un_arq,conjunto,rua,estante,prateleira,posicao,matricula) 
        VALUES ('$un_prod_sigla','$un_prod_nome','$data_inicio','$data_fim','$desc_docs','$un_arq','$conjunto','$rua','$estante','$prateleira','$posicao','$matricula')");
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

<body>

    <div class="sidebar">
        <p>Usuário: <?php echo $matricula; ?></p>
        <a class="active" href="cadastrante.php">Cadastrante</a>
        <a href="#contact">Listagem de Caixas</a>
        <a href="sicontrar.php">Sair</a>
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
                    </div>
                    <div class="column2">
                        <div>
                            <fieldset>
                                <legend id="loc"><b>Localização</b></legend><br>
                                <div class="inputBox">
                                    <input type="text" name="un_arq" id="un_arq" class="inputUser" required>
                                    <label for="un_arq" class="labelInput">Unidade de arquivo</label>
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
                        <input type="submit" name="submit" id="submit"><br><br>
                        <input type="reset" name="reset" id="reset">
                    </div>
                </fieldset>
            </form>
        </div>

    </div>
</body>

</html>