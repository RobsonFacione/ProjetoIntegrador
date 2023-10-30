<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "agendamento";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Consulta SQL para excluir o agendamento
    $sql = "DELETE FROM agendamento WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Agendamento excluído.");</script>';
        echo '<meta http-equiv="refresh" content="2;url=relatorio_agendamento.php">';
    } else {
        echo "Erro ao excluir o agendamento: " . $conn->error;
    }

    $conn->close();
} else {
    echo "ID do agendamento não especificado.";
}

?>
