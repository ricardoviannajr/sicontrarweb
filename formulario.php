<?php

if (!isset($_COOKIE['logged_in']) || $_COOKIE['logged_in'] != "true") {
    header("Location: sicontrar.php");
}

if (isset($_POST['submit'])) {

    $matricula = $_COOKIE['matricula'];

    include_once('config.php');

    $data_transf_cust = $_POST['data_transf_cust'];
    $doc_encam = $_POST['doc_encam'];
    $un_prod_sigla = $_POST['un_prod_sigla'];
    $un_prod_nome = $_POST['un_prod_nome'];
    $cx_num_ant = $_POST['cx_num_ant'];
    $cx_num_cust = $_POST['cx_num_cust'];
    $cod_clas_doc = $_POST['cod_clas_doc'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];
    $desc_docs = $_POST['desc_docs'];
    $prazo_guarda = $_POST['prazo_guarda'];
    $destino = $_POST['destino'];
    $un_arq = $_POST['un_arq'];
    $conjunto = $_POST['conjunto'];
    $rua = $_POST['rua'];
    $estante = $_POST['estante'];
    $prateleira = $_POST['prateleira'];
    $posicao = $_POST['posicao'];

    $result = mysqli_query($conexao, "INSERT INTO cadastro(data_transf_cust,doc_encam,un_prod_sigla,un_prod_nome,cx_num_ant,cx_num_cust,cod_clas_doc,data_inicio,data_fim,desc_docs,prazo_guarda,destino,un_arq,conjunto,rua,estante,prateleira,posicao,matricula) 
        VALUES ('$data_transf_cust','$doc_encam','$un_prod_sigla','$un_prod_nome','$cx_num_ant','$cx_num_cust','$cod_clas_doc','$data_inicio','$data_fim','$desc_docs','$prazo_guarda','$destino','$un_arq','$conjunto','$rua','$estante','$prateleira','$posicao','$matricula')");

    header("Location: cadastro_doc_full_sucesso.php?data_transf_cust=$data_transf_cust&doc_encam=$doc_encam&un_prod_sigla=$un_prod_sigla&un_prod_nome=$un_prod_nome&cx_num_ant=$cx_num_ant&cx_num_cust=$cx_num_cust&cod_clas_doc=$cod_clas_doc&data_inicio=$data_inicio&data_fim=$data_fim&desc_docs=$desc_docs&prazo_guarda=$prazo_guarda&destino=$destino&un_arq=$un_arq&conjunto=$conjunto&rua=$rua&estante=$estante&prateleira=$prateleira&posicao=$posicao&matricula=$matricula");

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

        <!--
        <div>
            <h3>
                <center>Últimos 10 Registros</center>
            </h3>
            <?php /*
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
            <form action="formulario.php" method="post">
                <fieldset>
                    <legend><b>SICONTRAR</b></legend>
                    <br>
                    <div class="column1">
                        <div class="inputBox">
                            <input type="text" name="data_transf_cust" id="data_transf_cust" class="inputUser" required autocomplete="off">
                            <label for="doc_encam" class="labelInput">Data de transferência ao arquivo de custódia</label>
                        </div><br><br>
                        <div class="inputBox">
                            <input type="text" name="doc_encam" id="doc_encam" class="inputUser" required autocomplete="off">
                            <label for="doc_encam" class="labelInput">Documento de encaminhamento</label>
                        </div><br><br>
                        <div class="inputBox">
                            <input type="text" name="un_prod_sigla" id="un_prod_sigla" class="inputUser" required autocomplete="off">
                            <label for="un_prod_sigla" class="labelInput">Unidade produtora - Sigla</label>
                        </div><br><br>
                        <div class="inputBox">
                            <input type="text" name="un_prod_nome" id="un_prod_nome" class="inputUser" required autocomplete="off">
                            <label for="un_prod_nome" class="labelInput">Unidade produtora - Nome</label>
                        </div><br><br>
                        <div class="inputBox">
                            <input type="text" name="cx_num_ant" id="cx_num_ant" class="inputUser" required autocomplete="off">
                            <label for="cx_num_ant" class="labelInput">Caixa - Número anterior</label>
                        </div><br><br>
                        <div class="inputBox">
                            <input type="text" name="cx_num_cust" id="cx_num_cust" class="inputUser" required autocomplete="off">
                            <label for="cx_num_cust" class="labelInput">Caixa - Número custódia</label>
                        </div><br><br>
                        <div class="inputBox">
                            <input type="text" name="cod_clas_doc" id="cod_clas_doc" class="inputUser" required autocomplete="off">
                            <label for="cod_clas_doc" class="labelInput">Código classificação documental</label>
                        </div><br><br>
                        <div class="inputBox">
                            <input type="text" name="data_inicio" id="data_inicio" class="inputUser" required autocomplete="off">
                            <label for="data_inicio" class="labelInput">Data-limite Início</label>
                        </div><br><br>
                        <div class="inputBox">
                            <input type="text" name="data_fim" id="data_fim" class="inputUser" required autocomplete="off">
                            <label for="data_fim" class="labelInput">Data-limite Fim</label>
                        </div><br><br>
                        <div class="inputBox">
                            <input type="text" name="desc_docs" id="desc_docs" class="inputUser" required autocomplete="off">
                            <label for="desc_docs" class="labelInput">Descrição dos documentos</label>
                        </div><br><br>
                        <div class="inputBox">
                            <input type="text" name="prazo_guarda" id="prazo_guarda" class="inputUser" required autocomplete="off">
                            <label for="prazo_guarda" class="labelInput">Prazo de Guarda</label>
                        </div>
                    </div>
                    <div class="column2">
                        <p>Destinação:</p>
                        <input type="radio" id="eliminar" name="destino" value="eliminar" required autocomplete="off">
                        <label for="eliminar">EL - Eliminar</label>
                        <input type="radio" id="permanente" name="destino" value="permanente" required autocomplete="off">
                        <label for="permanente">PE - Permanente</label>
                        <br><br>
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
                                    <input type="text" name="conjunto" id="conjunto" class="inputUser" required autocomplete="off" onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 8 || event.charCode == 32">
                                    <label for=" conjunto" class="labelInput">Conjunto</label>
                                </div><br><br>
                                <div class="inputBox">
                                    <input type="text" name="rua" id="rua" class="inputUser" required autocomplete="off" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                    <label for="rua" class="labelInput">Rua</label>
                                </div><br><br>
                                <div class="inputBox">
                                    <input type="text" name="estante" id="estante" class="inputUser" required autocomplete="off" onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 8 || event.charCode == 32">
                                    <label for="estante" class="labelInput">Estante</label>
                                </div><br><br>
                                <div class="inputBox">
                                    <input type="text" name="prateleira" id="prateleira" class="inputUser" required autocomplete="off" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                    <label for="prateleira" class="labelInput">Prateleira</label>
                                </div><br><br>
                                <div class="inputBox">
                                    <input type="text" name="posicao" id="posicao" class="inputUser" required autocomplete="off" onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 8 || event.charCode == 32">
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