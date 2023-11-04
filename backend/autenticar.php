<?php
session_start(); // Certifique-se de iniciar a sessão

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    
    // Conexão com o banco de dados (substitua pelos seus próprios dados)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "agendamento";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }
    
    $sql = "SELECT nome FROM cad_usuario WHERE cpf = '$cpf' AND senha = '$senha'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nomeUsuario = $row['nome'];
        $_SESSION['nome_do_usuario'] = $nomeUsuario;
        header("Location: menu.php");
        exit();
    } else {
        header("Location: login.php?error=1"); // Redirecione com um parâmetro de erro
        exit();
    }
    
    $conn->close();
} else {
    header("Location: login.php");
    exit();
}
?>
