<?php
$linhas = [];
$pacientes = [];

try {
    $PDO = new PDO('mysql:host=localhost;dbname=clinica', 'root', 'Flavio2012');

    if (isset($_POST['acao']) && $_POST['acao'] == 'criar') {
        $sql =
            "INSERT INTO 
            senha (Hora,DataSen,Nr,Guiche,ID_Paciente)
        VALUES (
        '{$_POST['Hora']}',
        '{$_POST['DataSen']}',
        '{$_POST['Nr']}',
        '{$_POST['Guiche']}',
        {$_POST['Paciente']}
        )";
        $resultado = $PDO->query($sql);
    } else if (isset($_POST['acao']) && $_POST['acao'] == 'editar') {
        $sql =
            "UPDATE senha
        SET
            Hora = '{$_POST['Hora']}',
            DataSen = '{$_POST['DataSen']}',
            Nr = '{$_POST['Nr']}',
            Guiche = '{$_POST['Guiche']}',
            ID_Paciente = {$_POST['Paciente']}
        WHERE ID={$_POST['ID']}";

        $resultado = $PDO->query($sql);
    } else if (isset($_POST['acao']) && $_POST['acao'] == 'deletar') {
        $sql =
            "DELETE FROM senha
        WHERE ID={$_POST['ID']}";

        $resultado = $PDO->query($sql);
    }

    $sql =
        "SELECT
        s.ID,
        s.Hora,
        s.DataSen,
        s.Nr,
        s.Guiche,
        p.Nome,
        s.ID_Paciente
         FROM senha s
        JOIN paciente p ON p.ID = s.ID_Paciente";

    $resultado = $PDO->query($sql);
    $linhas = $resultado->fetchAll();
    $sql =
        "SELECT
        *
        FROM
        paciente";
    $resultado = $PDO->query($sql);
    $pacientes = $resultado->fetchALL();
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Senhas</title>
    <meta name="description" content="Cadastro e visualização de setores">
    <link rel="icon" type="image/jpeg" href="https://static.vecteezy.com/ti/vetor-gratis/p3/5377647-logotipo-de-atendimento-medico-logotipo-clinica-vetor.jpg">
    <link href="/reset.css" rel="stylesheet">
    <link href="/estilo.css" rel="stylesheet">
</head>

<body>
    <h1>
        <img src="https://static.vecteezy.com/ti/vetor-gratis/p3/5377647-logotipo-de-atendimento-medico-logotipo-clinica-vetor.jpg" width="50" height="40" />
        Senhas
    </h1>
    <div>
        <a href="http://localhost/"><button><b>MENU</b></button></a><br><br>
    </div>
    <div class="align-self-center">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Horario</th>
                    <th>DataSen</th>
                    <th>Nr</th>
                    <th>Guichê</th>
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
                        <form action="/senhas.php" method="post">
                            <input type="hidden" name="acao" value="editar">
                            <td><input type="int" name="ID" value="<?php echo $linhas[$i]["ID"] ?>" readonly size="4" style="background-color: Lemonchiffon;"></td>
                            <td><input type="time" name="Hora" value="<?php echo $linhas[$i]["Hora"] ?>"></td>
                            <td><input type="date" name="DataSen" value="<?php echo $linhas[$i]["DataSen"] ?>"></td>
                            <td><input type="text" name="Nr" value="<?php echo $linhas[$i]["Nr"] ?>" size="4"></td>
                            <td><input type="text" name="Guiche" value="<?php echo $linhas[$i]["Guiche"] ?>" size="2"></td>
                            <td>
                                <select id="Paciente" name="Paciente">
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
                        <form action="/senhas.php" method="post">
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
        <form action="/senhas.php" method="post">
            <input type="hidden" name="acao" value="criar">
            <br><br><br>
            <table>
                <thead>
                    <tr>
                        <th>Hora</th>
                        <th>Data</th>
                        <th>Numero</th>
                        <th>Guichê</th>
                        <th>Paciente</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="time" id="Hora" name="Hora" required></td>
                        <td><input type="date" id="DataSen" name="DataSen" required></td>
                        <td><input type="text" id="Nr" name="Nr" required size="4"></td>
                        <td><input type="text" id="Guiche" name="Guiche" required size="2"></td>
                        <td>
                            <select name="Paciente" id="Paciente" required>
                                <?php
                                for ($i = 0; $i < count($pacientes); $i++) {
                                ?>
                                    <option value="<?php echo $pacientes[$i]["ID"] ?>"><?php echo $pacientes[$i]["Nome"] ?> - <?php echo $pacientes[$i]["CPF"] ?></option>
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