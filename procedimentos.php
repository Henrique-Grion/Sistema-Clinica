<?php
$linhas = [];
$pacientes = [];

try {
    $PDO = new PDO('mysql:host=localhost;dbname=clinica', 'root', 'Flavio2012');

    if (isset($_POST['acao']) && $_POST['acao'] == 'criar') {
        $sql =
            "INSERT INTO
            procedimento (Nome, DataPro, Sala, Hora, Paciente_ID)
        VALUES (
            '{$_POST['NomeProcedimento']}',
            '{$_POST['DataPro']}',
            '{$_POST['Sala']}',
            '{$_POST['Hora']}',
            {$_POST['Paciente']}
        )";
        $resultado = $PDO->query($sql);
    } else if (isset($_POST['acao']) && $_POST['acao'] == 'editar') {
        $sql =
            "UPDATE procedimento
        SET
            Nome = '{$_POST['NomeProcedimento']}',
            DataPro = '{$_POST['DataPro']}',
            Sala = '{$_POST['Sala']}',
            Hora = '{$_POST['Hora']}',
            Paciente_ID = {$_POST['Paciente']}
        WHERE ID={$_POST['ID']}";

        $resultado = $PDO->query($sql);
    } else if (isset($_POST['acao']) && $_POST['acao'] == 'deletar') {
        $sql =
            "DELETE FROM procedimento
        WHERE ID = {$_POST['ID']}";

        $resultado = $PDO->query($sql);
    }

    $sql =
        "SELECT 
        b.ID,
        b.Nome AS NomeProcedimento,
        b.DataPro,
        b.Sala,
        b.Hora,
        a.Nome AS NomePaciente,
        b.Paciente_ID
         FROM procedimento b
            JOIN paciente a ON a.ID = b.Paciente_ID";

    $resultado = $PDO->query($sql);
    $linhas = $resultado->fetchAll();

    $sql =
        "SELECT
            *                                               
        FROM
            paciente";

    $resultado = $PDO->query($sql);
    $pacientes = $resultado->fetchAll();
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Procedimentos</title>
    <meta name="description" content="Cadastro e visualização de setores">
    <link rel="icon" type="image/jpeg" href="https://static.vecteezy.com/ti/vetor-gratis/p3/5377647-logotipo-de-atendimento-medico-logotipo-clinica-vetor.jpg">
    <link href="/reset.css" rel="stylesheet">
    <link href="/estilo.css" rel="stylesheet">
</head>

<body>
    <h1>
        <img src="https://static.vecteezy.com/ti/vetor-gratis/p3/5377647-logotipo-de-atendimento-medico-logotipo-clinica-vetor.jpg" width="50" height="40" />
        Procedimentos
    </h1>
    <div>
        <a href="http://localhost/"><button><b>MENU</b></button></a><br><br>
    </div>
    <div class="align-self-center">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DataPro</th>
                    <th>Horario</th>
                    <th>Nome</th>
                    <th>Sala</th>
                    <th>Paciente</th>
                    <th>Editar</th>
                    <th>Deletar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($linhas); $i++) {
                ?>
                    <tr>
                        <form action="/procedimentos.php" method="post">
                            <input type="hidden" name="acao" value="editar">
                            <td><input type="int" name="ID" value="<?php echo $linhas[$i]["ID"] ?>" readonly size="4" style="background-color: Lemonchiffon;"></td>
                            <td><input type="date" name="DataPro" value="<?php echo $linhas[$i]["DataPro"] ?>"></td>
                            <td><input type="time" name="Hora" value="<?php echo $linhas[$i]["Hora"] ?>"></td>
                            <td><input type="text" name="NomeProcedimento" value="<?php echo $linhas[$i]["NomeProcedimento"] ?>"></td>
                            <td><input type="text" name="Sala" value="<?php echo $linhas[$i]["Sala"] ?>"></td>
                            <td>
                                <select name="Paciente" id="Paciente">
                                    <?php
                                    for ($j = 0; $j < count($pacientes); $j++) {
                                        $selecionado = '';
                                        if ($pacientes[$j]['ID'] == $linhas[$i]['Paciente_ID']) {
                                            $selecionado = 'selected';
                                        }
                                    ?>
                                        <option value="<?php echo $pacientes[$j]['ID'] ?>" <?php echo $selecionado ?>><?php echo $pacientes[$j]['Nome'] ?> - <?php echo $pacientes[$j]['CPF'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                            <td><button><b>Editar</b></button></td>
                        </form>
                        <form action="/procedimentos.php" method="post">
                            <input type="hidden" name="acao" value="deletar">
                            <input type="hidden" name="ID" value="<?php echo $linhas[$i]["ID"] ?>">
                            <td><button>Deletar</button></td>
                        </form>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <br>
    <div class="align-self-center">
        <form action="/procedimentos.php" method="post">
            <input type="hidden" name="acao" value="criar">
            <br><br><br>
            <table>
                <thead>
                    <tr>
                        <th>Procedimento</th>
                        <th>Data</th>
                        <th>Sala</th>
                        <th>Hora</th>
                        <th>Paciente</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" id="NomeProcedimento" name="NomeProcedimento" required></td>
                        <td><input type="date" id="DataPro" name="DataPro" required></td>
                        <td><input type="text" id="Sala" name="Sala" required></td>
                        <td><input type="time" id="Hora" name="Hora" required></td>
                        <td>
                            <select id="Paciente" name="Paciente" required>
                                <br>
                                <?php
                                for ($i = 0; $i < count($pacientes); $i++) {
                                ?>
                                    <option value="<?php echo $pacientes[$i]['ID'] ?> "><?php echo $pacientes[$i]['Nome'] ?> - <?php echo $pacientes[$i]['CPF'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td><button>ADD</button></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</body>

</html>