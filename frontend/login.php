<?php
session_start(); // Certifique-se de iniciar a sessão

if (isset($_SESSION['nome_do_usuario'])) {
    $nomeUsuario = $_SESSION['nome_do_usuario'];
} else {
    $nomeUsuario = "Usuário não autenticado"; // Define um valor padrão caso o usuário não esteja autenticado
}

$error_message = '';
if (isset($_GET['error']) && $_GET['error'] === '1') {
    $error_message = 'CPF ou senha incorretos. Tente novamente.';
}

?>

<!DOCTYPE html>
<html lang="pr-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="login.css">
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
      <header>Odonto System</header>
    </div><br>

    <form action="autenticar.php" method="post">
      <h3 style="font-family: sans-serif; text-indent: 20px;">CPF</h3>

      <div class="CPF">
        <input type="text" style="width: 300px;" id="CPF" name="cpf" placeholder="Informe o CPF" required><br><br>
      </div>

      <h3 style="font-family: sans-serif; text-indent: 20px;">SENHA</H3>

      <div class="senha">
        <input type="password" style="width: 300px;" id="senha" name="senha" placeholder="Digite sua senha" required><br>
      </div><br><br>

      <!-- Se houver uma mensagem de erro, exiba-a aqui -->
<?php if (!empty($error_message)) : ?>
            <div class="error-message">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

      <div class="entrar">
        <input type="submit" class="botao" id="botao" value="Entrar">
      </div>
    </form><br>

<div class="esqueceu">
    <form action="esqueceu_senha.php" method="get">
      <input type="submit" style="font-weight: bold; font-size: 16px;" id="botao" value="Esqueceu a Senha?">
    </form>
</div><br>

<div class="cadastro">
    <form action="cad_usuario.html" method="get">
      <input type="submit" style="font-weight: bold; font-size: 16px;" id="botao" value="Cadastre-se">
    </form>
</div>


  </div>
</body>

</html>