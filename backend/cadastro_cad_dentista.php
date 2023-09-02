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

        $sql = "INSERT INTO cad_paciente (nome, cpf, data_nascimento, cro, telefone, email) VALUES ('$nome', '$cpf', '$data_nascimento', '$cro', '$telefone', '$email')";
        if ($conexao->query($sql) === TRUE) {
            echo "Registro cadastrado com sucesso.";
        } else {
            echo "Erro ao cadastrar registro: " . $conexao->error;
        }

        $conexao->close();
    }
?>