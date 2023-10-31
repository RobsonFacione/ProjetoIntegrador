<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se as chaves de matriz estão definidas antes de usá-las
    if (isset($_POST["paciente_id"]) && isset($_POST["dia"]) && isset($_POST["hora"]) && isset($_POST["dentista_id"]) && isset($_POST["servico_id"])) {
        $paciente_id = $_POST["paciente_id"];
        $dia = $_POST["dia"];
        $hora = $_POST["hora"];
        $dentista_id = $_POST["dentista_id"];
        $servico_id = $_POST["servico_id"];

        $conexao = new mysqli("localhost", "root", "", "agendamento");
        if ($conexao->connect_error) {
            die("Conexão falhou: " . $conexao->connect_error);
        }

        // Verificar se o registro já existe no banco de dados
        $checkQuery = "SELECT * FROM agendamento WHERE paciente_id = '$paciente_id' AND dia = '$dia' AND hora = '$hora' AND dentista_id = '$dentista_id' AND servico_id = '$servico_id'";
        $result = $conexao->query($checkQuery);

        if ($result->num_rows > 0) {
            echo '<script>alert("Erro: O registro já existe no banco de dados.");</script>';
            echo '<meta http-equiv="refresh" content="2;url=agendamento.html">';
        } else {
            // Inserir o registro se ele não existe
            $insertQuery = "INSERT INTO agendamento (paciente_id, dia, hora, dentista_id, servico_id) VALUES ('$paciente_id', '$dia', '$hora', '$dentista_id', '$servico_id')";
            if ($conexao->query($insertQuery) === TRUE) {
                echo '<script>alert("Registro cadastrado com sucesso.");</script>';
                echo '<meta http-equiv="refresh" content="2;url=menu.html">';
            } else {
                echo "Erro ao cadastrar registro: " . $conexao->error;
            }
        }

        $conexao->close();
    } else {
        echo '<script>alert("Erro: Algum campo do formulário não foi preenchido.");</script>';
        echo '<meta http-equiv="refresh" content="2;url=agendamento.html">';
    }
}
?>
