<?php
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

// Consulta SQL para selecionar os dados do banco de dados
$sql = "SELECT * FROM vw_agendamento"; // Substitua "sua_tabela" pelo nome da tabela do seu banco de dados
$result = $conn->query($sql);

// Código para gerar o PDF usando TCPDF
require_once('TCPDF-main/tcpdf.php');

$pdf = new TCPDF();
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetTitle('Relatório de Agendamento por Data');
$pdf->AddPage();

$pdf_html = '<h1>Relatório de Agendamento por Data</h1>';
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

$pdf->writeHTML($pdf_html, true, false, true, false, '');

$pdf_filename = 'relatorio_agendamento.pdf';

$pdf->Output($pdf_filename, 'I');
?>
