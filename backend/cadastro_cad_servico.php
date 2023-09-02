<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servico = $_POST["servico"];
        

        $conexao = new mysqli("localhost", "root", "", "agendamento");
        if ($conexao->connect_error) {
            die("Conexão falhou: " . $conexao->connect_error);
        }

        $sql = "INSERT INTO cad_servico (servico) VALUES ('$servico')";
        if ($conexao->query($sql) === TRUE) {
            echo "Registro cadastrado com sucesso.";
        } else {
            echo "Erro ao cadastrar registro: " . $conexao->error;
        }

        $conexao->close();
    }
?>