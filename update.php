<?php
// Conectar ao banco de dados
$conn = mysqli_connect('localhost', 'root', '', 'sicontrar');

// Verificar se houve conexão com o banco de dados
if (!$conn) {
    die("A conexão falhou: " . mysqli_connect_error());
}

// Recuperar os dados do formulário
$id = mysqli_real_escape_string($conn, $_POST['id']);
$data_transf_cust = mysqli_real_escape_string($conn, $_POST['data_transf_cust']);
$doc_encam = mysqli_real_escape_string($conn, $_POST['doc_encam']);
$un_prod_sigla = mysqli_real_escape_string($conn, $_POST['un_prod_sigla']);
$un_prod_nome = mysqli_real_escape_string($conn, $_POST['un_prod_nome']);
$cx_num_ant = mysqli_real_escape_string($conn, $_POST['cx_num_ant']);
$cx_num_cust = mysqli_real_escape_string($conn, $_POST['cx_num_cust']);
$cod_clas_doc = mysqli_real_escape_string($conn, $_POST['cod_clas_doc']);
$data_inicio = mysqli_real_escape_string($conn, $_POST['data_inicio']);
$data_fim = mysqli_real_escape_string($conn, $_POST['data_fim']);
$desc_docs = mysqli_real_escape_string($conn, $_POST['desc_docs']);
$prazo_guarda = mysqli_real_escape_string($conn, $_POST['prazo_guarda']);
$destino = mysqli_real_escape_string($conn, $_POST['destino']);
$un_arq = mysqli_real_escape_string($conn, $_POST['un_arq']);
$conjunto = mysqli_real_escape_string($conn, $_POST['conjunto']);
$rua = mysqli_real_escape_string($conn, $_POST['rua']);
$estante = mysqli_real_escape_string($conn, $_POST['estante']);
$prateleira = mysqli_real_escape_string($conn, $_POST['prateleira']);
$posicao = mysqli_real_escape_string($conn, $_POST['posicao']);

// Preparar a query de atualização
$sql = "UPDATE cadastro SET data_transf_cust=?, doc_encam=?, un_prod_sigla=?, un_prod_nome=?, cx_num_ant=?, cx_num_cust=?, cod_clas_doc=?, data_inicio=?, data_fim=?, desc_docs=?, prazo_guarda=?, destino=?, un_arq=?, conjunto=?, rua=?, estante=?, prateleira=?, posicao=? WHERE id=?";

// Preparar a query para ser executada
$stmt = mysqli_prepare($conn, $sql);

// Vincular as variáveis à query
mysqli_stmt_bind_param($stmt, 'sssssssssssssssssi', $data_transf_cust, $doc_encam, $un_prod_sigla, $un_prod_nome, $cx_num_ant, $cx_num_cust, $cod_clas_doc, $data_inicio, $data_fim, $desc_docs, $prazo_guarda, $destino, $un_arq, $conjunto, $rua, $estante, $prateleira, $posicao, $id);

// Executar a query
$result = mysqli_stmt_execute($stmt);

// Verificar se a atualização foi bem-sucedida
if ($result) {
    // Redirecionar para a página de listagem
    header("Location: listagem.php");
} else {
    echo "Erro ao atualizar os dados: " . mysqli_error($conn);
}

// Fechar a conexão com o banco de dados
mysqli_close($conn);
