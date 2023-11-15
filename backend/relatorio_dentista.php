<?php
// Conexão com o banco de dados
$servername = "localhost"; // substitua pelo seu servidor MySQL
$username = "root"; // substitua pelo seu nome de usuário do MySQL
$password = ""; // substitua pela sua senha do MySQL
$dbname = "agendamento"; // substitua pelo nome do seu banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Consulta SQL para selecionar todos os dados da tabela "cad_dentista"
$sql = "SELECT *, YEAR(CURDATE()) - YEAR(data_nascimento) - (DATE_FORMAT(CURDATE(), '%m-%d') < DATE_FORMAT(data_nascimento, '%m-%d')) AS idade FROM cad_dentista";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Dentista</title>
    <style>
        body{
            background-color: black;
            background-image: url('./ar_system.jpg');
            background-position: center top;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style> 
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#filtroNome").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#tabelaDentistas tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
</head>
<body>
    <h1>Relatório de Dentistas Cadastrados</h1>

    <!-- Adicione um campo de pesquisa dinâmico -->
    <label for="filtroNome">Filtrar por Nome:</label>
    <input type="text" id="filtroNome">

    <table border="1" id="tabelaDentistas">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Data de Nascimento</th>
            <th>Idade</th>
            <th>CRO</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Editar</th>
            <!-- Adicione mais colunas conforme necessário -->
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ID"] . "</td>";
                echo "<td>" . $row["nome"] . "</td>";
                echo "<td>" . $row["cpf"] . "</td>";
                echo "<td>" . $row["data_nascimento"] . "</td>";
                echo "<td>" . $row["idade"] . " anos</td>"; // Exibição da idade calculada
                echo "<td>" . $row["cro"] . "</td>";
                echo "<td>" . $row["telefone"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td><a href='editar_dentista.php?id=" . $row["ID"] . "'>Editar</a></td>"; 
                // Adicione mais colunas conforme necessário
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Nenhum dentista encontrado</td></tr>";
        }
        ?>
    </table><br><br>
    
    <a href="relatorio_dentista.html" id="botaovoltar">Voltar</a><br><br>
    
</body>
</html>

<?php
// Feche a conexão com o banco de dados
$conn->close();
?>
