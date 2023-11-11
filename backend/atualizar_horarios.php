<?php
// Conexão com o banco de dados
$conexao = new mysqli("localhost", "root", "", "agendamento");

// Verifica se a data foi recebida via POST
$dataSelecionada = isset($_POST["dataSelecionada"]) ? $_POST["dataSelecionada"] : date("Y-m-d");

// Função para obter os horários disponíveis
function getHorariosDisponiveis($conexao, $dataSelecionada)
{
    $sql = "SELECT hora FROM agendamento WHERE dia = '$dataSelecionada'";
    $result = $conexao->query($sql);

    $horariosAgendados = array();

    while ($row = $result->fetch_assoc()) {
        $horariosAgendados[] = $row['hora'];
    }

    // Lista de todos os horários possíveis (pode ser ajustada conforme necessário)
    $todosHorarios = array('08:00:00', '09:00:00', '10:00:00', '11:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00');

    // Filtrar os horários disponíveis removendo os já agendados
    $horariosDisponiveis = array_diff($todosHorarios, $horariosAgendados);

    return array_values($horariosDisponiveis); // Retorna os valores da array associativa
}

// Chama a função para obter os horários disponíveis
$horariosDisponiveis = getHorariosDisponiveis($conexao, $dataSelecionada);

// Retorna os horários disponíveis como uma resposta JSON
echo json_encode($horariosDisponiveis);

// Fecha a conexão com o banco de dados
$conexao->close();
?>

