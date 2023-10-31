<?php
// Conexão com o banco de dados (mesmo código de conexão)
$servername = "localhost"; // substitua pelo seu servidor MySQL
$username = "root"; // substitua pelo seu nome de usuário do MySQL
$password = ""; // substitua pela sua senha do MySQL
$dbname = "agendamento"; // substitua pelo nome do seu banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

$update_message = ""; // Inicialize a mensagem de atualização

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta SQL para obter os detalhes do paciente com base no ID
    $sql = "SELECT * FROM cad_paciente WHERE ID = $id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nome = $row["nome"];
        $cpf = $row["cpf"];
        $data_nascimento = $row["data_nascimento"];
        $telefone = $row["telefone"];
        $email = $row["email"];
    } else {
        echo "Paciente não encontrado.";
        exit();
    }
} else {
    echo "ID do paciente não especificado.";
    exit();
}

// Verificar se o formulário de edição foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $novo_nome = $_POST['novo_nome'];
    $novo_cpf = $_POST['novo_cpf'];
    $nova_data_nascimento = $_POST['nova_data_nascimento'];
    $novo_telefone = $_POST['novo_telefone'];
    $novo_email = $_POST['novo_email'];

    // Consulta SQL para atualizar os dados do paciente
    $update_sql = "UPDATE cad_paciente SET nome = '$novo_nome', cpf = '$novo_cpf', data_nascimento = '$nova_data_nascimento', telefone = '$novo_telefone', email = '$novo_email' WHERE ID = $id";

    if ($conn->query($update_sql) === TRUE) {
        $update_message = "Dados do paciente atualizados com sucesso.";
        // Redirecionar para a página relatorio_paciente.php
        header("Location: relatorio_paciente.php");
        exit();
    } else {
        echo "Erro ao atualizar os dados do paciente: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Paciente</title>
</head>
<body>
    <h1>Editar Paciente</h1>
    <?php if (!empty($update_message)) : ?>
        <p><?php echo $update_message; ?></p>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="novo_nome" placeholder="Novo Nome" value="<?php echo $nome; ?>">
        <input type="text" name="novo_cpf" placeholder="Novo CPF" value="<?php echo $cpf; ?>">
        <input type="text" name="nova_data_nascimento" placeholder="Nova Data de Nascimento" value="<?php echo $data_nascimento; ?>">
        <input type="text" name="novo_telefone" placeholder="Novo Telefone" value="<?php echo $telefone; ?>">
        <input type="text" name="novo_email" placeholder="Novo Email" value="<?php echo $email; ?>">
        <input type="submit" name="submit" value="Salvar Alterações">
    </form>
    <br>
    <a href="javascript:history.go(-1)" id="botaovoltar">Voltar</a>
</body>
</html>

<?php
// Feche a conexão com o banco de dados
$conn->close();
?>
