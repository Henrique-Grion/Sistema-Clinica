<?php
$linhas = [];
$pacientes = [];


try {
    $PDO = new PDO('mysql:host=localhost;dbname=clinica', 'root', 'Flavio2012');

    if (isset($_POST['acao']) && $_POST['acao'] == 'criar') {
        $sql =
            "INSERT INTO
            anamnese (DataAmn, Horario, Resultado, ID_Paciente) 
        VALUES (
            '{$_POST['DataAmn']}',
            '{$_POST['Horario']}',
            '{$_POST['Resultado']}',
            {$_POST['Paciente']}
        )";
        $resultado = $PDO->query($sql);
    } else if (isset($_POST['acao']) && $_POST['acao'] == 'editar') {
        $sql =
            "UPDATE
            anamnese
        SET
            DataAmn = '{$_POST['DataAmn']}',
            Horario = '{$_POST['Horario']}',
            Resultado = '{$_POST['Resultado']}',
            ID_Paciente = '{$_POST['Paciente']}'
        WHERE
            ID = {$_POST['ID']}
        ";
        $resultado = $PDO->query($sql);
    } else if (isset($_POST['acao']) && $_POST['acao'] == 'deletar') {
        $sql =
            "DELETE FROM anamnese
        WHERE ID= {$_POST['ID']}";

        $resultado = $PDO->query($sql);
    }

    $sql =
        "SELECT
            a.ID,
            a.DataAmn,
            a.Horario,
            a.Resultado,
            p.Nome,
            p.CPF,
            a.ID_Paciente
        FROM
            anamnese a
            JOIN paciente p ON p.ID = a.ID_Paciente";

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
    <title>Anamneses</title>
    <meta name="description" content="Cadastro e visualização de setores">
    <link rel="icon" type="image/jpeg" href="https://static.vecteezy.com/ti/vetor-gratis/p3/5377647-logotipo-de-atendimento-medico-logotipo-clinica-vetor.jpg">
    <link href="/reset.css" rel="stylesheet">
    <link href="/projeto2/estiliza.css" rel="stylesheet">
</head>

<body>
    <h1>
        <img src="https://static.vecteezy.com/ti/vetor-gratis/p3/5377647-logotipo-de-atendimento-medico-logotipo-clinica-vetor.jpg" width="50" height="40" />
        Anamneses
    </h1>
    <div>
        <a href="http://localhost/"><button><b>MENU</b></button></a><br><br>
    </div>
    <div class="align-self-center">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DataAmn</th>
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
                        <form action="/anamnese.php" method="post">
                            <input type="hidden" name="acao" value="editar">
                            <td><input type="text" name="ID" value="<?php echo $linhas[$i]["ID"] ?>" readonly size="4" style="background-color: Lemonchiffon;"></td>
                            <td><input type="date" name="DataAmn" value="<?php echo $linhas[$i]["DataAmn"] ?>"></td>
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
                            <td><button>Editar</button></td>
                        </form>
                        <form action="/anamnese.php" method="post">
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
        <form action="/anamnese.php" method="post">
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
                        <td><input type="date" id="DataAmn" name="DataAmn" required></td>
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