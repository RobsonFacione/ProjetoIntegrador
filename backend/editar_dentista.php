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

$mensagem = ""; // Variável para armazenar a mensagem de sucesso ou erro

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM cad_dentista WHERE ID = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $dentista = $result->fetch_assoc();
    } else {
        echo "Dentista não encontrado.";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $data_nascimento = $_POST["data_nascimento"];
    $cro = $_POST["cro"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];

    $sql = "UPDATE cad_dentista SET nome='$nome', cpf='$cpf', data_nascimento='$data_nascimento', cro='$cro', telefone='$telefone', email='$email' WHERE ID=$id";

    if ($conn->query($sql) === TRUE) {
        $mensagem = "Dados do dentista atualizados com sucesso.";
        // Redirecionar para a página de relatório após a edição
        header("Location: relatorio_dentista.php");
        exit;
    } else {
        $mensagem = "Erro ao atualizar os dados do dentista: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Dentista</title>
</head>
<body>
    <h1>Editar Dentista</h1>
    <?php if ($mensagem !== "") : ?>
        <p><?php echo $mensagem; ?></p>
    <?php endif; ?>
    <form method="post" action="editar_dentista.php">
        <input type="hidden" name="id" value="<?php echo $dentista["ID"]; ?>">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="<?php echo $dentista["nome"]; ?>"><br>
        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" value="<?php echo $dentista["cpf"]; ?>"><br>
        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="text" name="data_nascimento" value="<?php echo $dentista["data_nascimento"]; ?>"><br>
        <label for="cro">CRO:</label>
        <input type="text" name="cro" value "<?php echo $dentista["cro"]; ?>"><br>
        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" value="<?php echo $dentista["telefone"]; ?>"><br>
        <label for="email">Email:</label>
        <input type="text" name="email" value="<?php echo $dentista["email"]; ?>"><br>
        <input type="submit" value="Salvar">
    </form>
    
    <a href="javascript:history.go(-1)" id="botaovoltar">Voltar</a><br><br>
    <a href="relatorio_dentista.php">Retornar para o relatório de dentistas</a>
</body>
</html>

<?php
// Feche a conexão com o banco de dados
$conn->close();
?>
