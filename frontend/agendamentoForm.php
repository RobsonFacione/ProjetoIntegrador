<?php
// Conexão com o banco de dados
$conexao = new mysqli("localhost", "root", "", "agendamento");

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

    return $horariosDisponiveis;
}

// Verifica se a data foi enviada via POST
$dataSelecionada = isset($_POST["dia"]) ? $_POST["dia"] : date("Y-m-d");

// Chama a função para obter os horários disponíveis
$horariosDisponiveis = getHorariosDisponiveis($conexao, $dataSelecionada);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento</title>
    <link rel="stylesheet" href="agendamento.css">
    <style>
        #pacienteId{
            width: 30px;
            border-radius: 4px;
            border: 1px solid black ;
            text-align: center;
        }

        #pacienteNome{
            width: 198px;
            border-radius: 4px;
            border: 1px solid black ;
        }

       
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <header>Agendamento</header>
        </div>
        <form action="agendamento.php" method="post">
            <div class="paciente">
                <div class="paciente1">
                    <h3 style="font-family: sans-serif;" id="paciente1">Nome</h3>
                </div>
                <div class="paciente2">
                    <!-- Campo de texto para o ID do paciente -->
                    <input type="text" name="paciente_id" id="pacienteId" placeholder="ID" required>
                    <input type="text" id="pacienteNome" readonly><br>
                    <a href="relatorio_paciente.php">Pesquisa Paciente</a>
                </div>
            </div><br>

            <div class="data">
                <div class="data1">
                    <h3 style="font-family: sans-serif;">Data</h3>
                </div>
                <div class="data2">
                    <input type="date" id="data" name="dia" placeholder="Digite a data" required onchange="atualizarHorariosDisponiveis()">
                </div>
            </div>

            <div class="hora">
                <div class="hora1">
                    <h3 style="font-family: sans-serif;">Hora</h3>
                </div>
                <div class="hora2">
                    <select name="hora" id="hora" required>
                        <?php
                        // Agora, use $horariosDisponiveis para criar as opções do campo de hora
                        foreach ($horariosDisponiveis as $horario) {
                            echo "<option value='$horario'>$horario</option>";
                        }
                        ?>
                    </select>
                </div>
            </div><br>

            <div class="dentista">
                <div class="dentista1">
                    <h3 style="font-family: sans-serif;">Dentista</h3>
                </div>
                <div class="dentista2">
                    <!-- Início select dinâmico dentista -->
                    <select name="dentista_id" id="dentista">
                        <?php
                        $sql = "SELECT id, nome FROM cad_dentista";
                        $result = $conexao->query($sql);

                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                        }
                        $conexao->close();
                        ?>
                    </select><br>
                    <!-- Fim select dinâmico dentista -->
                    <div class="servico">
                        <div class="servico1">
                            <h3 style="font-family: sans-serif;">Serviço</h3>
                        </div>
                        <div class="servico2">
                            <select name="servico_id" id="servico">
                                <?php
                                $conexao = new mysqli("localhost", "root", "", "agendamento");
                                $sql = "SELECT id, servico FROM cad_servico";
                                $result = $conexao->query($sql);

                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['servico'] . "</option>";
                                }
                                ?>
                            </select><br>
                        </div><br>

                        <div class="botao">
                            <input type="submit" id="botao" value="Agendar">
                        </div>
        </form>

        <div class="voltar">
            <a href="javascript:history.go(-1)" id="botaovoltar">Voltar</a>
        </div>

    </div>
    <script>
        const pacienteIdInput = document.getElementById("pacienteId");
        const pacienteNome = document.getElementById("pacienteNome");
        const dataInput = document.getElementById("data");
        const horaSelect = document.getElementById("hora");

        pacienteIdInput.addEventListener("input", function () {
            const paciente_id = pacienteIdInput.value;

            if (paciente_id) {
                // Faz uma solicitação AJAX para buscar o nome do paciente
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "get_nome.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        pacienteNome.value = xhr.responseText;
                    }
                };
                xhr.send("paciente_id=" + paciente_id);
            } else {
                pacienteNome.value = "";
            }
        });

        function atualizarHorariosDisponiveis() {
            // Lógica para atualizar os horários disponíveis com base na data selecionada
            const dataSelecionada = dataInput.value;
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "atualizar_horarios.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        const horarios = JSON.parse(xhr.responseText);

                        // Verifica se horarios é uma array
                        if (Array.isArray(horarios)) {
                            horaSelect.innerHTML = "";
                            horarios.forEach(function (horario) {
                                horaSelect.innerHTML += "<option value='" + horario + "'>" + horario + "</option>";
                            });
                        } else {
                            console.error("Os horários recebidos não são uma array:", horarios);
                        }
                    } catch (error) {
                        console.error("Erro ao processar resposta JSON:", error);
                    }
                }
            };
            xhr.send("dataSelecionada=" + dataSelecionada);
        }
    </script>
</body>

</html>
