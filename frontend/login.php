<?php
session_start(); // Certifique-se de iniciar a sessão

if (isset($_SESSION['nome_do_usuario'])) {
    $nomeUsuario = $_SESSION['nome_do_usuario'];
} else {
    $nomeUsuario = "Usuário não autenticado"; // Define um valor padrão caso o usuário não esteja autenticado
}
?>

<!DOCTYPE html>
<html lang="pr-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="login.css">
</head>

<body>
  <div class="container">

    <div class="header">
      <header>Odonto System</header>
    </div>

    <form action="autenticar.php" method="post">
      <h3 style="font-family: sans-serif; text-indent: 20px;">CPF</h3>

      <div class="CPF">
        <input type="text" id="CPF" name="cpf" placeholder="Informe o CPF" required><br><br>
      </div>

      <h3 style="font-family: sans-serif; text-indent: 20px;">SENHA</H3>

      <div class="senha">
        <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required><br>
      </div><br>

      <div class="entrar">
        <input type="submit" class="botao" value="Entrar">
      </div>
    </form><br>

<div class="esqueceu">
    <form action="esqueceu_senha.html" method="get">
      <input type="submit" id="botaocadastre" value="Esqueceu a Senha?">
    </form>
</div><br>

<div class="cadastro">
    <form action="cad_usuario.html" method="get">
      <input type="submit" id="botaocadastre" value="Cadastre-se">
    </form>
</div>


  </div>
</body>

</html>