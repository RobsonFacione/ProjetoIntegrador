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
}

#botao, #botaovoltar {
    background-color: #A9A9A9; /* Cor de fundo para os botões */
    color: black;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

#botao:hover, #botaovoltar:hover {
    background-color: #6CA6CD; /* Altere a cor ao passar o mouse sobre os botões se desejar */
}
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <header><?php echo "Bem-vindo, " . $nomeUsuario; ?></header>
        </div><br><br>

        <form action="agendamentoForm.php" method="get">
            <div class="agendamento">
                <input type="submit" id="botao" value="Agendamento">
            </div>
        </form>

        <form action="relatorio.html" method="get">
            <div class="relatorio">
                <input type="submit" id="botao" value="Relatório">
            </div>
        </form>
        
        <form action="cadastro.html" method="get">
            <div class="cadastro">
                <input type="submit" id="botao" value="Cadastro">
            </div>
        </form><br><br>
        
        <form action="login.php" method="get">
            <div class="sair">
                <input type="submit" id="botao" background-color="green" value="Sair">
            </div>
        </form>
        
    </div>

</body>
</html>
