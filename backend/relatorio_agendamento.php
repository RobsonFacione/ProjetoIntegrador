<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agendamento";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Lógica de filtragem com as datas
$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : '';
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : '';
$nome = isset($_GET['nome']) ? $_GET['nome'] : '';

// Modifica a consulta SQL para incluir as condições com base nas variáveis
$sql = "SELECT * FROM vw_agendamento WHERE 1=1";

if (!empty($nome)) {
    $sql .= " AND paciente_nome LIKE '%$nome%'";
}

if (!empty($data_inicio) && !empty($data_fim)) {
    $sql .= " AND dia BETWEEN '$data_inicio' AND '$data_fim'";
}

// Adiciona a cláusula ORDER BY para ordenar por ID em ordem crescente
$sql .= " ORDER BY ID ASC";

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

    <form method="get">
        <label for="nome">Nome do Paciente:</label>
        <input type="text" name="nome" value="<?php echo $nome; ?>"><br>

        <label for="data_inicio">Data de Início:</label>
        <input type="date" name="data_inicio" value="<?php echo $data_inicio; ?>">

        <label for="data_fim">Data de Fim:</label>
        <input type="date" name="data_fim" value="<?php echo $data_fim; ?>">

        <input type="submit" value="Filtrar"><br><br>
    </form>

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
    </table><br>

    

    <a href="relatorio_agendamento.html" id="botaovoltar">Voltar</a><br>
</body>
</html>

<?php
$conn->close();
?>
