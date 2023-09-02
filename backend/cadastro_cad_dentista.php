<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $data_nascimento = $_POST["data_nascimento"];
    $cro = $_POST["cro"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];

    $conexao = new mysqli("localhost", "root", "", "agendamento");
    if ($conexao->connect_error) {
        die("Conexão falhou: " . $conexao->connect_error);
    }

    $sql = "INSERT INTO cad_dentista (nome, cpf, data_nascimento, cro, telefone, email) VALUES ('$nome', '$cpf', '$data_nascimento', '$cro', '$telefone', '$email')";
    if ($conexao->query($sql) === TRUE) {
        // Exibe a mensagem com JavaScript e redireciona após um breve atraso
        echo '<script>alert("Registro cadastrado com sucesso.");</script>';
        echo '<meta http-equiv="refresh" content="2;url=menu.html">';
    } else {
        echo "Erro ao cadastrar registro: " . $conexao->error;
    }

    $conexao->close();
}
?>
