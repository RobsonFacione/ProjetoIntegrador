<?php
// Inclua a biblioteca TCPDF
require_once('TCPDF-main/tcpdf.php');

// Recupere o filtro (nome) da URL
$nome = isset($_GET['nome']) ? $_GET['nome'] : '';

// Conexão com o banco de dados
$servername = "localhost"; // substitua pelo seu servidor MySQL
$username = "root"; // substitua pelo seu nome de usuário do MySQL
$password = ""; // substitua pela sua senha do MySQL
$dbname = "agendamento"; // substitua pelo nome do seu banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Consulta SQL com filtro
$sql = "SELECT * FROM vw_agendamento WHERE paciente_nome LIKE '%$nome%'";
$result = $conn->query($sql);

// Cria um novo objeto TCPDF
$pdf = new TCPDF();
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetTitle('Relatório de Agendamento por Nome');
$pdf->AddPage();

// Cria o conteúdo do PDF
$pdf_html = '<h1>Relatório de Agendamento por Nome</h1>';
$pdf_html .= '<table border="1">';
$pdf_html .= '<tr><th>ID</th><th>Nome</th><th>Dia</th><th>Hora</th><th>Dentista</th><th>Serviço</th></tr>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf_html .= '<tr>';
        $pdf_html .= '<td>' . $row["ID"] . '</td>';
        $pdf_html .= '<td>' . $row["paciente_nome"] . '</td>';
        $pdf_html .= '<td>' . $row["dia"] . '</td>';
        $pdf_html .= '<td>' . $row["hora"] . '</td>';
        $pdf_html .= '<td>' . $row["dentista_nome"] . '</td>';
        $pdf_html .= '<td>' . $row["servico_nome"] . '</td>';
        $pdf_html .= '</tr>';
    }
} else {
    $pdf_html .= '<tr><td colspan="7">Nenhum usuário encontrado</td></tr>';
}

$pdf_html .= '</table>';

// Adicione o conteúdo ao PDF
$pdf->writeHTML($pdf_html, true, false, true, false, '');

// Nome do arquivo PDF de saída
$pdf_filename = 'relatorio_agendamento_nome.pdf';

// Saída do PDF para o navegador
$pdf->Output($pdf_filename, 'I');

// Feche a conexão com o banco de dados
$conn->close();
?>
