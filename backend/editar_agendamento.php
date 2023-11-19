<?php
// Inicialize a mensagem de sucesso como vazia
$mensagem = "";

// Conexão com o banco de dados (mesmo código que você já tem)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agendamento";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Verifique se o ID foi fornecido na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta SQL para selecionar os detalhes do registro com base no ID
    $sql = "SELECT * FROM vw_agendamento WHERE ID = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Agora, você tem os detalhes do registro a ser editado

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Processar o formulário quando for enviado
            $newDate = $_POST['nova_data'];
            $newTime = $_POST['nova_hora'];

            // Atualizar os dados no banco de dados
            $updateSql = "UPDATE vw_agendamento SET dia = '$newDate', hora = '$newTime' WHERE ID = $id";
            if ($conn->query($updateSql) === TRUE) {
                // Defina a mensagem de sucesso
              echo $mensagem = "Dados atualizados com sucesso.";
                
                // Redirecionar o usuário para uma página específica após a atualização
                header("Location: relatorio_agendamento.php");
                exit(); // Certifique-se de sair após o redirecionamento
            } else {
                echo "Erro ao atualizar os dados: " . $conn->error;
            }
        }
    } else {
        echo "Registro não encontrado";
    }
} else {
    echo "ID do registro não fornecido";
}

// Feche a conexão com o banco de dados (mesmo código que você já tem)
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Agendamento</title>
    <link rel="stylesheet" href="editar_dentista.css">
    <style>
        body{
            background-color: black;
            background-image: url('./ar_system.jpg');
            background-position: center top;
            background-repeat: no-repeat;
            background-size: cover;
        }

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
   
    height: 40px;
    border-radius: 5px;
    font-size: 25px;
    font-family: arial;
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

    </style> 
</head>
<body>

<div class="container">
    
    <div class="header">
    <header style="background-color: #6CA6CD; border-radius: none;">Editar Agendamento</header>
    </div><br><br>
    <!-- Exibir a mensagem de sucesso (se houver) -->
    <?php if (!empty($mensagem)) : ?>
        <p><?php echo $mensagem; ?></p>
    <?php endif; ?>
<br>
    <form method="POST">
        <label for="nova_data">Nova Data:</label>
        <input type="date" style="font-family: arial; ffont-weight: bold;" id="nova_data" name="nova_data" value="<?php echo $row['dia']; ?>"><br><br>

        <label for="nova_hora">Nova Hora:</label>
        <input type="time" style="font-family: arial; ffont-weight: bold;" id="nova_hora" name="nova_hora" value="<?php echo $row['hora']; ?>"><br><br>

        <input type="submit" id="botao" value="Salvar">
    </form>

    <form action="relatorio_agendamento.php" method="get">
        <input type="submit" id="botao" value="Voltar">
    </form>

    </div>
</body>
</html>


