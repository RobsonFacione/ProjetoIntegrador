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

// Inicialize a variável de pesquisa
$search_name = "";

// Verifique se o formulário de pesquisa foi enviado
if (isset($_POST['search'])) {
    $search_name = $_POST['search_name'];
}

// Consulta SQL para selecionar dados da tabela "cad_paciente" com base no nome
$sql = "SELECT *, YEAR(CURDATE()) - YEAR(data_nascimento) - (DATE_FORMAT(CURDATE(), '%m-%d') < DATE_FORMAT(data_nascimento, '%m-%d')) AS idade FROM cad_paciente WHERE nome LIKE '%$search_name%'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Paciente</title>
</head>
<body>
    <h1>Relatório de Pacientes Cadastrados</h1>

    <!-- Formulário de pesquisa por nome -->
    <form method="post">
        <input type="text" name="search_name" placeholder="Nome do paciente" value="<?php echo $search_name; ?>">
        <input type="submit" name="search" value="Pesquisar">
    </form>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Data de Nascimento</th>
            <th>Idade</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Editar</th> <!-- Coluna para edição -->
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
                echo "<td>" . $row["telefone"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td><a href='editar_paciente.php?id=" . $row["ID"] . "'>Editar</a></td>"; // Adicione um link para a página de edição
                // Adicione mais colunas conforme necessário
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Nenhum paciente encontrado</td></tr>";
        }
        ?>
    </table><br><br>
    
    <a href="javascript:history.go(-1)" id="botaovoltar">Voltar</a><br><br>
    <a href="relatorio_paciente.html">Voltar para a página Relatório de Pacientes</a>
</body>
</html>

<?php
// Feche a conexão com o banco de dados
$conn->close();
?>
