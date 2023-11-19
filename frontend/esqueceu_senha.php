<?php
// Função para gerar uma chave única
function gerarChaveUnica() {
    return bin2hex(random_bytes(16));
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera o e-mail do formulário
    $email = $_POST["email"];

    // Conecta ao banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "agendamento";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Verifica se o e-mail existe no banco de dados
    $verificarEmail = "SELECT * FROM cad_usuario WHERE email = '$email'";
    $resultadoEmail = $conn->query($verificarEmail);

    if ($resultadoEmail->num_rows > 0) {
        // E-mail existe, continua com a geração de chave de recuperação
        // Gera a chave única
        $chaveRecuperacao = gerarChaveUnica();

        // Atualiza a chave de recuperação na tabela de usuários
        $sql = "UPDATE cad_usuario SET chave_recuperacao = '$chaveRecuperacao' WHERE email = '$email'";

        if ($conn->query($sql) === TRUE) {
            // Envia a chave por e-mail
            $assunto = "Redefinição de Senha";
            $mensagem = "Use a seguinte chave para redefinir sua senha: $chaveRecuperacao";
            $headers = "De: seu_email@seu_dominio.com";

            if (mail($email, $assunto, $mensagem, $headers)) {
                echo "Chave de recuperação gerada e enviada com sucesso para o e-mail!";
            } else {
                echo "Erro ao enviar e-mail. Verifique as configurações do servidor de e-mail.";
            }
        } else {
            echo "Erro ao gerar chave de recuperação: " . $conn->error;
        }
    } else {
        echo "E-mail não encontrado. Verifique se o e-mail está correto.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueceu a Senha?</title>
    <link rel="stylesheet" href="esqueceu_senha.css">
    <style>       
        body {
    margin: 0;
}

.container {
    background-color: rgba(255, 255, 255, 0.4); /* Adicione a opacidade ao definir a cor de fundo com rgba */
    padding: 20px;
    border: none;
}

.header {
    text-align: center;
    background-color: #6CA6CD;
    border: none;
    width: 300px;
}

#botao {
    background-color: #A9A9A9; /* Cor de fundo para os botões */
    color: black;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 330px;
}

#botaovoltar {
    background-color: #A9A9A9; /* Cor de fundo para os botões */
    color: black;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 300px;
}

#botao:hover, #botaovoltar:hover {
    background-color: #6CA6CD; /* Altere a cor ao passar o mouse sobre os botões se desejar */
}

.botao{
    text-align: center;
}
    
     
   
      
    
        .error-message {
            color: black;
            text-align: center;
            font-family: arial;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <header>Esqueceu a Senha?</header>
        </div>
        <p style="font-family: sans-serif; text-align: center;">Digite abaixo o e-mail para prosseguir <br>com a
            recuperação de senha</p>

        <form method="post">
            <!-- Adicione um campo oculto para o e-mail -->
            <input type="hidden" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
            <div class="email">
                <input type="email" style="width: 300px" id="email" name="email" placeholder="Digite o e-mail" required>
            </div><br>
            <div class="botao">
                <input type="submit" id="botao" value="Enviar">
            </div>
        </form>

        <div class="voltar">
            <a href="javascript:history.go(-1)" id="botaovoltar">Voltar</a>
        </div>
    </div>
</body>

</html>
