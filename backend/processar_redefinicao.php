<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $chaveRecuperacao = $_POST["chave_recuperacao"];
    $novaSenha = $_POST["nova_senha"];
    $confirmarNovaSenha = $_POST["confirmar_nova_senha"];

    // Conecta ao banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "agendamento";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Verifica se as senhas coincidem
    if ($novaSenha == $confirmarNovaSenha) {
        // Atualiza a senha e limpa a chave de recuperação
        $sql = "UPDATE usuarios SET senha = '$novaSenha', chave_recuperacao = NULL WHERE chave_recuperacao = '$chaveRecuperacao'";

        if ($conn->query($sql) === TRUE) {
            echo "Senha redefinida com sucesso!";
        } else {
            echo "Erro ao redefinir senha: " . $conn->error;
        }
    } else {
        echo "As senhas não coincidem. Tente novamente.";
    }

    $conn->close();
} else {
    // Método incorreto de acesso ao arquivo
    echo "Acesso inválido.";
}
?>
