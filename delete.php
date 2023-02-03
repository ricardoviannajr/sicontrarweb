<?php
// Conectar ao banco de dados
$conn = mysqli_connect('localhost', 'root', '', 'sicontrar');

// Verificar se houve conexão com o banco de dados
if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}

// Receber o id do registro a ser excluído
$id = $_GET['id'];

// Montar a query de exclusão
$query = "DELETE FROM cadastro WHERE id = $id";

// Executar a query
if (mysqli_query($conn, $query)) {
    header("Location: listagem.php");
} else {
    echo "Erro ao excluir o registro: " . mysqli_error($conn);
}

// Fechar a conexão com o banco de dados
mysqli_close($conn);
