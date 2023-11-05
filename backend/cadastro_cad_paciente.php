<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $data_nascimento = $_POST["data_nascimento"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];

    // Verificar a idade
    $data_nascimento = new DateTime($data_nascimento);
    $hoje = new DateTime();
    $idade = $hoje->diff($data_nascimento)->y;

    if ($idade > 0) {
        // A idade é igual ou maior que zero, podemos continuar com o cadastro
        $conexao = new mysqli("localhost", "root", "", "agendamento");
        if ($conexao->connect_error) {
            die("Conexão falhou: " . $conexao->connect_error);
        }

        $sql = "INSERT INTO cad_paciente (nome, cpf, data_nascimento, telefone, email) VALUES ('$nome', '$cpf', '".$data_nascimento->format('Y-m-d')."', '$telefone', '$email')";
        if ($conexao->query($sql) === TRUE) {
            echo '<script>alert("Registro cadastrado com sucesso.");</script>';
            echo '<meta http-equiv="refresh" content="2;url=menu.php">';
        } else {
            echo "Erro ao cadastrar registro: " . $conexao->error;
        }

        $conexao->close();
    } else {
        // A idade é menor ou igual a zero, exiba uma mensagem de erro
        echo '<script>alert("A idade deve ser maior que zero.");</script>';
        echo '<script>history.go(-1);</script>'; // Volte para a página anterior (a página de cadastro)
    }
}
?>
