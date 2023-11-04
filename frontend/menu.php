<?php
session_start(); // Certifique-se de iniciar a sessão

if (isset($_SESSION['nome_do_usuario'])) {
    $nomeUsuario = $_SESSION['nome_do_usuario'];
} else {
    $nomeUsuario = "Usuário não autenticado"; // Define um valor padrão caso o usuário não esteja autenticado
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="menu.css">
</head>

<body>

    <div class="container">
        <div class="header">
            <header><?php echo "Bem-vindo, " . $nomeUsuario; ?></header>
        </div>

        <form action="agendamentoForm.php" method="get">
            <div class="agendamento">
                <input type="submit" id="botao" value="Agendamento">
            </div><br>
        </form>

        <form action="relatorio.html" method="get">
            <div class="relatorio">
                <input type="submit" id="botao" value="Relatório">
            </div><br>
        </form>
        
        <form action="cadastro.html" method="get">
            <div class="cadastro">
                <input type="submit" id="botao" value="Cadastro">
            </div><br>
        </form>
        
        <form action="login.php" method="get">
            <div class="sair">
                <input type="submit" id="botaovoltar" value="Sair">
            </div><br>
        </form>

    </div>

</body>
</html>
