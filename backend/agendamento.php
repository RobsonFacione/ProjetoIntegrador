<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se as chaves de matriz estão definidas antes de usá-las
    if (isset($_POST["paciente_id"]) && isset($_POST["dia"]) && isset($_POST["hora"]) && isset($_POST["dentista_id"]) && isset($_POST["servico_id"])) {
        $paciente_id = $_POST["paciente_id"]; //paciente_id
        $dia = $_POST["dia"];
        $hora = $_POST["hora"];
        $dentista_id = $_POST["dentista_id"]; //dentista_id
        $servico_id = $_POST["servico_id"];   //servico_id

        $conexao = new mysqli("localhost", "root", "", "agendamento");
        if ($conexao->connect_error) {
            die("Conexão falhou: " . $conexao->connect_error);
        }

        $sql = "INSERT INTO agendamento (paciente_id, dia, hora, dentista_id, servico_id) VALUES ('$paciente_id', '$dia', '$hora', '$dentista_id', '$servico_id')";
        if ($conexao->query($sql) === TRUE) {
            // Exibe a mensagem com JavaScript e redireciona após um breve atraso
            echo '<script>alert("Registro cadastrado com sucesso.");</script>';
            echo '<meta http-equiv="refresh" content="2;url=menu.html">';
        } else {
            echo "Erro ao cadastrar registro: " . $conexao->error;
        }

        $conexao->close();
    } else {
        echo '<script>alert("Erro: Algum campo do formulário não foi preenchido.");</script>';
        echo '<meta http-equiv="refresh" content="2;url=agendamento.html">';
    }
}
?>
