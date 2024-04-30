<?php
$linhas = [];
$pacientes = [];

try {
    $PDO = new PDO('mysql:host=localhost;dbname=clinica', 'root', 'Flavio2012');
    if (isset($_POST['acao']) && $_POST['acao'] == 'criar') {
        $sql =
            "INSERT INTO
            laudo (DataLau, Horario, Resultado, ID_Paciente)
        VALUES (
            '{$_POST['DataLau']}',
            '{$_POST['Horario']}',
            '{$_POST['Resultado']}',
            {$_POST['Paciente']}
        )";

        $resultado = $PDO->query($sql);
    } else if (isset($_POST['acao']) && $_POST['acao'] == 'editar') {
        $sql =
            "UPDATE laudo
        SET
            DataLau = '{$_POST['DataLau']}',
            Horario = '{$_POST['Horario']}',
            Resultado = '{$_POST['Resultado']}',
            ID_Paciente = {$_POST['Paciente']}
            WHERE ID={$_POST['ID']}";

        $resultado = $PDO->query($sql);
    } else if (isset($_POST['acao']) && $_POST['acao'] == 'deletar') {
        $sql =
            "DELETE FROM laudo
        WHERE ID = {$_POST['ID']}";

        $resultdao = $PDO->query($sql);
    }

    $sql =
        "SELECT 
            l.ID,
            l.DataLau,
            l.Horario,
            l.Resultado,
            p.Nome,
            p.CPF,
            l.ID_Paciente
        FROM laudo l
        JOIN paciente p ON p.ID = l.ID_Paciente";

    $resultado = $PDO->query($sql);
    $linhas = $resultado->fetchAll();


    $sql =
        "SELECT 
        *
    FROM paciente";

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
    <title>Laudos</title>
    <meta name="description" content="Cadastro e visualização de setores">
    <link rel="icon" type="image/jpeg" href="https://static.vecteezy.com/ti/vetor-gratis/p3/5377647-logotipo-de-atendimento-medico-logotipo-clinica-vetor.jpg">
    <link href="/reset.css" rel="stylesheet">
    <link href="/estilo.css" rel="stylesheet">

</head>

<body>
    <h1>
        <img src="https://static.vecteezy.com/ti/vetor-gratis/p3/5377647-logotipo-de-atendimento-medico-logotipo-clinica-vetor.jpg" width="50" height="40" />
        Laudos
    </h1>
    <div>
        <a href="http://localhost/"><button><b>MENU</b></button></a><br><br>
    </div>
    <div class="align-self-center">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DataLau</th>
                    <th>Horario</th>
                    <th>Resultado</th>
                    <th>Paciente</th>
                    <th>Editar</th>
                    <th>Deletar</th>
                </tr>
            <tbody>
                <?php
                for ($i = 0; $i < count($linhas); $i++) {
                ?>
                    <tr>
                        <form action="/laudos.php" method="post">
                            <input type="hidden" name="acao" value="editar">
                            <td><input type="int" name="ID" value="<?php echo $linhas[$i]["ID"] ?>" readonly style="background-color: Lemonchiffon;"></td>
                            <td><input type="date" name="DataLau" value="<?php echo $linhas[$i]["DataLau"] ?>"></td>
                            <td><input type="time" name="Horario" value="<?php echo $linhas[$i]["Horario"] ?>"></td>
                            <td><input type="text" name="Resultado" value="<?php echo $linhas[$i]["Resultado"] ?>"></td>
                            <td>
                                <select id="Paciente" name="Paciente" required>
                                    <?php
                                    for ($j = 0; $j < count($pacientes); $j++) {
                                        $selecionado = '';
                                        if ($pacientes[$j]['ID'] == $linhas[$i]['ID_Paciente']) {
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
                        <form action="/laudos.php" method="post">
                            <input type="hidden" name="acao" value="deletar">
                            <input type="hidden" name="ID" value="<?php echo $linhas[$i]["ID"] ?>">
                            <td><button>Deletar</button></td>
                        </form>
                    </tr>
                <?php
                }
                ?>
            </tbody>
            </thead>
        </table>
    </div>
    <br>
    <div class="align-self-center">
        <form action="/laudos.php" method="post">
            <input type="hidden" name="acao" value="criar">
            <br><br><br>
            <table>
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Resultado</th>
                        <th>Paciente</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="date" id="DataLau" name="DataLau" required></td>
                        <td><input type="time" id="Horario" name="Horario" required></td>
                        <td><input type="text" id="Resultado" name="Resultado" required></td>
                        <td>
                            <select id="Paciente" name="Paciente" required>
                                <br>
                                <?php
                                for ($i = 0; $i < count($pacientes); $i++) {
                                ?>
                                    <option value="<?php echo $pacientes[$i]['ID'] ?>"><?php echo $pacientes[$i]['Nome'] ?> - <?php echo $pacientes[$i]['CPF'] ?></option>
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