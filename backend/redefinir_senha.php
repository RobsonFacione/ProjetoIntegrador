<?php
// Conecta ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agendamento";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se a chave de recuperação foi fornecida
if (isset($_GET['chave_recuperacao'])) {
    $chaveRecuperacao = $_GET['chave_recuperacao'];

    // Verifica se a chave de recuperação é válida
    $verificarChave = "SELECT * FROM usuarios WHERE chave_recuperacao = '$chaveRecuperacao'";
    $resultadoChave = $conn->query($verificarChave);

    if ($resultadoChave->num_rows > 0) {
        // Chave de recuperação válida, exibe o formulário de redefinição de senha
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Redefinir Senha</title>
            <link rel="stylesheet" href="redefinir_senha.css">
        </head>

        <body>
            <div class="container">
                <div class="header">
                    <header>Redefinir Senha</header>
                </div>
                <form action="processar_redefinicao.php" method="post">
                    <input type="hidden" name="chave_recuperacao" value="<?php echo $chaveRecuperacao; ?>">

                    <div class="senha">
                        <h3 style="font-family: sans-serif;">Nova Senha</h3>
                        <input type="password" id="nova_senha" name="nova_senha" placeholder="Digite a nova senha" required>
                    </div>

                    <div class="confirmar_senha">
                        <h3 style="font-family: sans-serif;">Confirmar Nova Senha</h3>
                        <input type="password" id="confirmar_nova_senha" name="confirmar_nova_senha" placeholder="Confirme a nova senha" required>
                    </div>

                    <br>

                    <div class="botao">
                        <input type="submit" id="botao" value="Redefinir Senha">
                    </div>
                </form>
            </div>
        </body>

        </html>
        <?php
    } else {
        // Chave de recuperação inválida
        echo "Chave de recuperação inválida. Por favor, verifique o link enviado por e-mail.";
    }
} else {
    // Chave de recuperação não fornecida
    echo "Chave de recuperação não fornecida. Por favor, use o link enviado por e-mail.";
}

$conn->close();
?>
