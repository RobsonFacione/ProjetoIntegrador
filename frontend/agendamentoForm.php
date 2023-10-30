<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento</title>
    <link rel="stylesheet" href="agendamento.css">
</head>

<body>

    <div class="container">
        <div class="header">
            <header>Agendamento</header>
        </div>
        <form action="agendamento.php" method="post">
            <!--link com o banco de dados para realizar o cadastro, verifiar se há diferenças nas variaveis feito pelo Rold GPT -->
            <div class="paciente">
                <div class="paciente1">
                    <h3 style="font-family: sans-serif;" id="paciente1">Nome</h3>
                </div>
                <div class="paciente2">
                    <!-- Início select dinâmico paciente -->
                    <select name="paciente_id" id="paciente">
                        <?php
                        $conexao = new mysqli("localhost", "root", "", "agendamento");
                        $sql = "SELECT id, nome FROM cad_paciente";
                        $result = $conexao->query($sql);

                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                        }
                        ?>
                    </select><br>
                    <!-- Fim select dinâmico  -->
				</div>
            </div><br>

            <div class="data">    
                <div class="data1">
                    <h3 style="font-family: sans-serif;">Data</h3>
                </div>
                <div class="data2">
                    <input type="date" id="data" name="dia" placeholder="Digite a data" required>
                </div>
            </div>

            <div class="hora">
                <div class="hora1">
                    <h3 style="font-family: sans-serif;">Hora</h3>
                </div>
                <div class="hora2">
                    <input type="time" id="hora" name="hora" placeholder="Digite a hora" required>
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

</body>

</html>