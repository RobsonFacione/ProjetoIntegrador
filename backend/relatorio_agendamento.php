<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agendamento";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

$sql = "SELECT * FROM vw_agendamento";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Agendamento</title>
    <style>
        body {
            background-color: black;
            background-image: url('./ar_system.jpg');
            background-position: center top;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body>
    <h1>Relatório de Agendamento</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>paciente_nome</th>
            <th>dia</th>
            <th>hora</th>
            <th>dentista_nome</th>
            <th>servico_nome</th>
            <th>funcoes</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ID"] . "</td>";
                echo "<td>" . $row["paciente_nome"] . "</td>";
                echo "<td>" . $row["dia"] . "</td>";
                echo "<td>" . $row["hora"] . "</td>";
                echo "<td>" . $row["dentista_nome"] . "</td>";
                echo "<td>" . $row["servico_nome"] . "</td>";
                echo "<td><a href='editar_agendamento.php?id=" . $row["ID"] . "'>Editar</a> <a href='excluir_agendamento.php?id=" . $row["ID"] . "'>Excluir</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nenhum usuário encontrado</td></tr>";
        }
        ?>
    </table><br><br>

    <a href="pdf_agendamento.php">Gerar PDF</a><br><br>

    <a href="relatorio_agendamento.html" id="botaovoltar">Voltar</a>
</body>
</html>

<?php
$conn->close();
?>
