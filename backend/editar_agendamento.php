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
    <style>
        body{
            background-color: black;
            background-image: url('./ar_system.jpg');
            background-position: center top;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style> 
</head>
<body>
    <h1>Editar Agendamento</h1>

    <!-- Exibir a mensagem de sucesso (se houver) -->
    <?php if (!empty($mensagem)) : ?>
        <p><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="nova_data">Nova Data:</label>
        <input type="date" id="nova_data" name="nova_data" value="<?php echo $row['dia']; ?>"><br><br>

        <label for="nova_hora">Nova Hora:</label>
        <input type="time" id="nova_hora" name="nova_hora" value="<?php echo $row['hora']; ?>"><br><br>

        <input type="submit" value="Salvar">
    </form>

    <a href="relatorio_agendamento.php" id="botaovoltar">Voltar</a>
</body>
</html>


