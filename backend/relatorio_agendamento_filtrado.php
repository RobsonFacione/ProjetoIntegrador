<?php
// relatorio_agendamento_filtrado.php

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

// Definir o número de resultados por página
$resultados_por_pagina = 10;

// Obter o número da página atual
$pagina_atual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Calcular o deslocamento
$deslocamento = ($pagina_atual - 1) * $resultados_por_pagina;

// Construir a consulta SQL com base nos parâmetros, na paginação e na ordenação por ID
$sql = "SELECT * FROM vw_agendamento";

if (!empty($paciente) || (!empty($data_inicio) && !empty($data_fim))) {
    $sql .= " WHERE 1=1";

    if (!empty($paciente)) {
        $sql .= " AND paciente_nome LIKE '%$paciente%'";
    }

    if (!empty($data_inicio) && !empty($data_fim)) {
        $sql .= " AND dia BETWEEN '$data_inicio' AND '$data_fim'";
    }
}

$sql .= " ORDER BY id ASC LIMIT $deslocamento, $resultados_por_pagina";

$result = $conn->query($sql);

// Exibir os resultados
if ($result->num_rows > 0) {
    // Adicione a tag <table> aqui
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Paciente</th><th>Data</th><th>Hora</th><th>Dentista</th><th>Serviço</th></tr>";

    while ($row = $result->fetch_assoc()) {
        // Use as tags <tr> e <td> para representar cada linha e célula da tabela
        echo "<tr>";
        echo "<td>" . $row['ID'] . "</td>";
        echo "<td>" . $row['paciente_nome'] . "</td>";
        echo "<td>" . $row['dia'] . "</td>";
        echo "<td>" . $row['hora'] . "</td>";
        echo "<td>" . $row['dentista_nome'] . "</td>";
        echo "<td>" . $row['servico_nome'] . "</td>";
        echo "</tr>";
        // Adicione mais campos conforme necessário
    }

    // Adicione a tag </table> aqui
    echo "</table>";

    // Adicionar links para navegação entre páginas
    $sql = "SELECT COUNT(*) AS total FROM vw_agendamento";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $total_resultados = $row['total'];
    $total_paginas = ceil($total_resultados / $resultados_por_pagina);

    echo "<div>";
    for ($i = 1; $i <= $total_paginas; $i++) {
        echo "<a href='relatorio_agendamento_filtrado.php?paciente=$paciente&data_inicio=$data_inicio&data_fim=$data_fim&pagina=$i'>$i</a> ";
    }
    echo "</div>";

    // Adicione a quebra de linha após os links de navegação
    echo "<br>";

    // Adicione os links no final do arquivo
    echo "<br><br>";
    echo "<a href='relatorio_agendamento_filtrado_pdf.php?paciente=$paciente&data_inicio=$data_inicio&data_fim=$data_fim'>Gerar PDF</a><br><br>";
    echo "<a href='relatorio_agendamento.html' id='botaovoltar'>Voltar</a>";
} else {
    echo "Nenhum resultado encontrado.";
}

$conn->close();
?>
