<?php
// relatorio_agendamento_filtrado_dentista_pdf.php

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
$dentista = isset($_GET['dentista']) ? $_GET['dentista'] : "";
$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : "";
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : "";

// Construir a consulta SQL com base nos parâmetros
$sql = "SELECT * FROM vw_agendamento";

if (!empty($dentista) || (!empty($data_inicio) && !empty($data_fim))) {
    $sql .= " WHERE 1=1";

    if (!empty($dentista)) {
        $sql .= " AND dentista_nome LIKE '%$dentista%'";
    }

    if (!empty($data_inicio) && !empty($data_fim)) {
        $sql .= " AND dia BETWEEN '$data_inicio' AND '$data_fim'";
    }

    // Adicione a ordenação por ID
    $sql .= " ORDER BY id ASC";

    $result = $conn->query($sql);

    // Criar uma instância do TCPDF
    $pdf = new TCPDF();
    $pdf->SetTitle('Relatório de Consulta de Dentista');

    // Adicionar uma página ao PDF
    $pdf->AddPage();

    $pdf->SetFont('times', 'B', 16); // Definir fonte, negrito e tamanho
    $pdf->Cell(0, 10, 'Relatório de Consulta de Dentista', 0, 1, 'C'); // Célula que abrange toda a largura

    // Definir fonte e tamanho
    $pdf->SetFont('times', '', 12);

    // Adicionar cabeçalho da tabela
    $pdf->Cell(13, 10, 'ID_ag', 1);
    $pdf->Cell(50, 10, 'Paciente', 1);
    $pdf->Cell(23, 10, 'Data', 1);
    $pdf->Cell(23, 10, 'Hora', 1);
    $pdf->Cell(50, 10, 'Dentista', 1);
    $pdf->Cell(30, 10, 'Serviço', 1);
    $pdf->Ln(); // Adicionar nova linha para os dados

    // Contador para o número de consultas agendadas
    $consultaAgendadaCount = 0;

    // Exibir os resultados na tabela
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Incrementar o contador
            $consultaAgendadaCount++;

            // Exibir os dados na tabela
            $pdf->Cell(13, 10, $row['ID'], 1);
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

    // Adicionar a mensagem ao PDF
    $pdf->Ln(); // Adicionar espaço antes da mensagem
    $pdf->Cell(0, 10, "Número de consultas agendadas: $consultaAgendadaCount", 0, 1, 'L');

    // Saída do PDF para o navegador
    $pdf->Output('relatorio_dentista.pdf', 'I');

} else {
    echo "Nenhum resultado encontrado.";
}

$conn->close();
?>
