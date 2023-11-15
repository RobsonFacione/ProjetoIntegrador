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
$search_servico = "";

// Verifique se o formulário de pesquisa foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_servico = isset($_POST['search_servico']) ? $_POST['search_servico'] : '';
}

// Consulta SQL para selecionar dados da tabela "cad_servico" com base no serviço
$sql = "SELECT * FROM cad_servico WHERE servico LIKE '%$search_servico%'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Serviço</title>
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
            $("#filtroServico").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#tabelaServicos tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
</head>
<body>
    <h1>Relatório de Serviço</h1>

    <!-- Formulário de pesquisa por serviço -->
    <form method="post">
        <input type="text" name="search_servico" id="filtroServico" placeholder="Nome do serviço" value="<?php echo $search_servico; ?>">
        <input type="submit" name="search" value="Pesquisar">
    </form>

    <table border="1" id="tabelaServicos">
        <tr>
            <th>ID</th>
            <th>Serviço</th>
            
            <!-- Adicione mais colunas conforme necessário -->
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ID"] . "</td>";
                echo "<td>" . $row["servico"] . "</td>";
                
                // Adicione mais colunas conforme necessário
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>Nenhum serviço encontrado</td></tr>";
        }
        ?>
    </table><br><br>
    
    <a href="javascript:history.go(-1)" id="botaovoltar">Voltar</a>
</body>
</html>

<?php
// Feche a conexão com o banco de dados
$conn->close();
?>
