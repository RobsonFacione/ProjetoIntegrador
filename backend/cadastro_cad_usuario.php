<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $cpf = $_POST["cpf"];
        $senha = $_POST["senha"];

        $conexao = new mysqli("localhost", "root", "", "agendamento");
        if ($conexao->connect_error) {
            die("Conexão falhou: " . $conexao->connect_error);
        }

        $sql = "INSERT INTO cad_usuario (nome, email, cpf, senha) VALUES ('$nome', '$email','$cpf',  '$senha')";
        if ($conexao->query($sql) === TRUE) {
            echo '<script>alert("Registro cadastrado com sucesso.");</script>';
            echo '<meta http-equiv="refresh" content="2;url=login.php">';
        } else {
            echo "Erro ao cadastrar registro: " . $conexao->error;
        }

        $conexao->close();
    }
?>