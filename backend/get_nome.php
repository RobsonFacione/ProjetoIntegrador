<?php
if (isset($_POST['paciente_id'])) {
    $conexao = new mysqli("localhost", "root", "", "agendamento");
    $paciente_id = $_POST['paciente_id'];
    $sql = "SELECT nome FROM cad_paciente WHERE id = ?";
    
    if ($stmt = $conexao->prepare($sql)) {
        $stmt->bind_param("i", $paciente_id);
        $stmt->execute();
        $stmt->bind_result($nome);
        
        if ($stmt->fetch()) {
            echo $nome;
        } else {
            echo "Paciente não encontrado";
        }
        
        $stmt->close();
    } else {
        echo "Erro na consulta SQL";
    }
    
    $conexao->close();
} else {
    echo "ID de paciente não fornecido";
}
?>
