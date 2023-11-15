<?php
// relatorio_agendamento_filtrado_pdf.php

// Inclua a biblioteca TCPDF
require_once('TCPDF-main/tcpdf.php');

// Conectar ao banco de dados (substitua com suas credenciais)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agendamento";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Obter parâmetros do formulário
$paciente = isset($_GET['paciente']) ? $_GET['paciente'] : "";
$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : "";
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : "";

// Construir a consulta SQL com base nos parâmetros
$sql = "SELECT * FROM vw_agendamento";

if (!empty($paciente) || (!empty($data_inicio) && !empty($data_fim))) {
    $sql .= " WHERE 1=1";

    if (!empty($paciente)) {
        $sql .= " AND paciente_nome LIKE '%$paciente%'";
    }

    if (!empty($data_inicio) && !empty($data_fim)) {
        $sql .= " AND dia BETWEEN '$data_inicio' AND '$data_fim'";
    }

    // Adicione a ordenação por ID
    $sql .= " ORDER BY id ASC";

    $result = $conn->query($sql);

    // Criar uma instância do TCPDF
    $pdf = new TCPDF();

    // Adicionar uma página ao PDF
    $pdf->AddPage();

    // Definir fonte e tamanho
    $pdf->SetFont('times', '', 12);

    // Adicionar cabeçalho da tabela
    $pdf->Cell(10, 10, 'ID', 1);
    $pdf->Cell(50, 10, 'Paciente', 1);
    $pdf->Cell(23, 10, 'Data', 1);
    $pdf->Cell(23, 10, 'Hora', 1);
    $pdf->Cell(50, 10, 'Dentista', 1);
    $pdf->Cell(30, 10, 'Serviço', 1);
    $pdf->Ln(); // Adicionar nova linha para os dados

    // Exibir os resultados na tabela
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Exibir os dados na tabela
            $pdf->Cell(10, 10, $row['ID'], 1);
            $pdf->Cell(50, 10, $row['paciente_nome'], 1);
            $pdf->Cell(23, 10, $row['dia'], 1);
            $pdf->Cell(23, 10, $row['hora'], 1);
            $pdf->Cell(50, 10, $row['dentista_nome'], 1);
            $pdf->Cell(30, 10, $row['servico_nome'], 1);
            $pdf->Ln(); // Adicionar nova linha para os próximos dados
        }
    } else {
        $pdf->Cell(180, 10, "Nenhum resultado encontrado.", 1, 1, 'C');
    }

    // Saída do PDF para o navegador
    $pdf->Output('relatorio_agendamento.pdf', 'I');

    // Limpar o buffer de saída
    ob_end_clean();
} else {
    echo "Nenhum resultado encontrado.";
}

$conn->close();
?>
