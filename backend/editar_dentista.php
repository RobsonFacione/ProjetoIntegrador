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
    <link rel="stylesheet" href="editar_dentista.css">
</head>
<body>
<div class="container">

    <header>Editar Dados do Dentista</header>
    <?php if ($mensagem !== "") : ?>
        <p><?php echo $mensagem; ?></p>
    <?php endif; ?>


    <form method="post" action="editar_dentista.php">

        <input type="hidden" name="id" value="<?php echo $dentista["ID"]; ?>">

        <div class="nome">
            <div class="nome1">
                <h3 style="font-family: sans-serif;">Nome</h3>
            </div>
            <div class="nome2">
                <input type="text" name="nome" id="nome" value="<?php echo $dentista["nome"]; ?>"><br>
            </div>
        </div><br>

        <div class="cpf">
            <div class="cpf1">
                <h3 style="font-family: sans-serif;">CPF</h3>
            </div>
            <div class="cpf2">
                <input type="text" name="cpf" id="cpf" value="<?php echo $dentista["cpf"]; ?>"><br>
            </div>
        </div>

        <div class="data">
            <div class="data1">
                <h3 style="font-family: sans-serif;">Data de Nascimento</h3>
            </div>
            <div class="data2">
                <input type="text" name="data_nascimento" id="data" value="<?php echo $dentista["data_nascimento"]; ?>"><br>
            </div>
        </div><br>

        <div class="cro">
            <div class="cro1">
                <h3 style="font-family: sans-serif;">CRO</h3>
            </div>
            <div class="cro2">
                <input type="text" name="cro" id="cro" value="<?php echo $dentista["cro"]; ?>"><br>
            </div>
        </div>

        <div class="telefone">
            <div class="telefone1">
                <h3 style="font-family: sans-serif;">Telefone</h3>
            </div>
            <div class="telefone2">
                <input type="text" name="telefone" id="telefone "value="<?php echo $dentista["telefone"]; ?>"><br>
            </div>
        </div>

        <div class="email">
            <div class="email1">
                <h3 style="font-family: sans-serif;">E-mail</h3>
            </div>
            <div class="email2">
                <input type="text" name="email" id="email" value="<?php echo $dentista["email"]; ?>"><br>
            </div>
        </div>

        <div class="botao">
            <input type="submit" id="botao" value="Salvar Alterações">
        </div>

    </form>

        <div class="voltar">
            <a href="relatorio_dentista.php" id="botaovoltar">Voltar</a>
        </div>

</div> 
</body>
</html>

<?php
// Feche a conexão com o banco de dados
$conn->close();
?>
