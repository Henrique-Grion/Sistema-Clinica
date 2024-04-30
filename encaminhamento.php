<?php
$linhas = [];
$pacientes = [];

try {
    $PDO = new PDO('mysql:host=localhost;dbname=clinica', 'root', 'Flavio2012');

    if (isset($_POST['acao']) && $_POST['acao'] == 'criar') {
        $sql =
            "INSERT INTO
            encaminhamento (DataEnc, Motivo, Medico, Paciente_ID, Clinica)
        VALUES (
            '{$_POST['DataEnc']}',
            '{$_POST['Motivo']}',
            '{$_POST['Medico']}',
             {$_POST['Paciente']},
            '{$_POST['Clinica']}'
        )";
        $resultado = $PDO->query($sql);
    } else if (isset($_POST['acao']) && $_POST['acao'] == 'editar') {
        $sql =
            "UPDATE
            encaminhamento
        SET
            Medico = '{$_POST['Medico']}',
            DataEnc = '{$_POST['DataEnc']}',
            Motivo = '{$_POST['Motivo']}',
            Clinica = '{$_POST['Clinica']}',
            Paciente_ID = '{$_POST['Paciente']}'   
        WHERE
            ID = {$_POST['ID']}
        ";
        $resultado = $PDO->query($sql);
    } else if (isset($_POST['acao']) && $_POST['acao'] == 'deletar') {
        $sql =
            "DELETE FROM encaminhamento
        WHERE ID = {$_POST['ID']}";

        $resultado = $PDO->query($sql);
    }


    $sql =
        "SELECT 
            e.ID,
            e.Medico,
            e.DataEnc,
            e.Motivo,
            e.Clinica,
            p.Nome,
            p.CPF,
            e.Paciente_ID
        FROM encaminhamento e
        JOIN paciente  p ON p.ID = e.Paciente_ID
        ORDER BY 1 ASC";

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
    <title>Encaminhamentos</title>
    <meta name="description" content="Cadastro e visualização de setores">
    <link rel="icon" type="image/jpeg" href="https://static.vecteezy.com/ti/vetor-gratis/p3/5377647-logotipo-de-atendimento-medico-logotipo-clinica-vetor.jpg">
    <link href="/reset.css" rel="stylesheet">
    <link href="/estilo.css" rel="stylesheet">
</head>

<body>
    <h1>
        <img src="https://static.vecteezy.com/ti/vetor-gratis/p3/5377647-logotipo-de-atendimento-medico-logotipo-clinica-vetor.jpg" width="50" height="40" />
        Encaminhamentos
    </h1>
    <div>
        <a href="http://localhost/"><button><b>MENU</b></button></a><br><br>
    </div>
    <div class="align-self-center">
        <table id="tabexibe">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Medico</th>

                    <th>DataEnc</th>

                    <th>Motivo</th>

                    <th>Clinica</th>

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
                        <form action="/encaminhamento.php" method="post">
                            <input type="hidden" name="acao" value="editar">
                            <td><input type="int" name="ID" value="<?php echo $linhas[$i]["ID"] ?>" readonly style="background-color: Lemonchiffon;" size="4"></td>

                            <td><input type="text" name="Medico" value="<?php echo $linhas[$i]["Medico"] ?>"></td>

                            <td><input type="date" name="DataEnc" value="<?php echo $linhas[$i]["DataEnc"] ?>"></td>

                            <td><input type="text" name="Motivo" value="<?php echo $linhas[$i]["Motivo"] ?>"></td>

                            <td><input type="text" name="Clinica" value="<?php echo $linhas[$i]["Clinica"] ?>"></td>

                            <td>
                                <select id="Paciente" name="Paciente" required>
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

                            <td><button>Editar</button></td>

                        </form>
                        <form action="/encaminhamento.php" method="post">
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
        <form action="/encaminhamento.php" method="post">
            <input type="hidden" name="acao" value="criar">
            <br><br><br>
            <table>
                <thead>
                    <tr>
                        <th>Medico</th>
                        <th>DataEnc</th>
                        <th>Motivo</th>
                        <th>Clinica</th>
                        <th>Paciente</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" id="Medico" name="Medico" required></td>
                        <td><input type="date" id="DataEnc" name="DataEnc" required></td>
                        <td><input type="text" id="Motivo" name="Motivo" required></td>
                        <td><input type="text" id="Clinica" name="Clinica" required></td>
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