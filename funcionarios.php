<?php
$linhas = [];

try {
    $PDO = new PDO('mysql:host=localhost;dbname=clinica', 'root', 'Flavio2012');
    if (isset($_POST['acao']) && $_POST['acao'] == 'criar') {
        $sql =
            "INSERT INTO
            funcionario (Nome, Telefone, Salario, CPF, DatNasc, Sexo, HorarioE, HorarioS)
        VALUES (
            '{$_POST['Nome']}',
            '{$_POST['Telefone']}',
            '{$_POST['Salario']}',
            '{$_POST['CPF']}',
            '{$_POST['DatNasc']}',
            '{$_POST['Sexo']}',
            '{$_POST['HorarioE']}',
            '{$_POST['HorarioS']}'
        )";
        $resultado = $PDO->query($sql);
    } else if (isset($_POST['acao']) && $_POST['acao'] == 'editar') {
        $sql =
            "UPDATE
            funcionario
        SET
            Nome ='{$_POST['Nome']}',
            Telefone = '{$_POST['Telefone']}',
            Salario = '{$_POST['Salario']}',
            CPF = '{$_POST['CPF']}',
            DatNasc = '{$_POST['DatNasc']}',
            Sexo = '{$_POST['Sexo']}',
            HorarioE = '{$_POST['HorarioE']}',
            HorarioS = '{$_POST['HorarioS']}'
        WHERE
            ID = {$_POST['ID']}
        ";
        $resultado = $PDO->query($sql);
    } else if (isset($_POST['acao']) && $_POST['acao'] == 'deletar') {
        $sql =
            "DELETE FROM funcionario
        WHERE ID = {$_POST['ID']}";

        $resultdao = $PDO->query($sql);
    }

    $sql =
        "SELECT
            *
         FROM funcionario";

    $resultado = $PDO->query($sql);
    $linhas = $resultado->fetchAll();
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}
?>

<!DOCTYPE html>

<html lang="pt-br" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Funcionarios</title>
    <meta name="description" content="Cadastro e visualização de setores">
    <link rel="icon" type="image/jpeg" href="https://static.vecteezy.com/ti/vetor-gratis/p3/5377647-logotipo-de-atendimento-medico-logotipo-clinica-vetor.jpg">
    <link href="/reset.css" rel="stylesheet">
    <link href="/estilo.css" rel="stylesheet">
</head>

<body>
    <h1>
        <img src="https://static.vecteezy.com/ti/vetor-gratis/p3/5377647-logotipo-de-atendimento-medico-logotipo-clinica-vetor.jpg" width="50" height="40" />
        Funcionários
    </h1>
    <div>
        <a href="http://localhost/"><button><b>MENU</b></button></a><br><br>
    </div>
    <div class="align-self-center">
        <table>
            <thead>
                <tr>
                    <th scope="col"> ID</th>
                    <th scope="col"> Nome</th>
                    <th scope="col"> Telefone</th>
                    <th scope="col"> Salário</th>
                    <th scope="col"> CPF</th>
                    <th scope="col"> Data Nascimento</th>
                    <th scope="col"> Sexo</th>
                    <th scope="col"> HorarioE</th>
                    <th scope="col"> HorarioS</th>
                    <th scope="col"> Editar</th>
                    <th scope="col"> Deletar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($linhas); $i++) {
                ?>
                    <tr>
                        <form action="/funcionarios.php" method="post">
                            <input type="hidden" name="acao" value="editar">
                            <td><input type="int" name="ID" value="<?php echo $linhas[$i]["ID"] ?>" readonly style="background-color: Lemonchiffon;" size="5"></td>
                            <td><input type="text" name="Nome" value="<?php echo $linhas[$i]["Nome"] ?>"></td>
                            <td><input type="text" name="Telefone" value="<?php echo $linhas[$i]["Telefone"] ?>"></td>
                            <td><input type="text" name="Salario" value="<?php echo $linhas[$i]["Salario"] ?>"></td>
                            <td><input type="text" name="CPF" value="<?php echo $linhas[$i]["CPF"] ?>"></td>
                            <td><input type="date" name="DatNasc" value="<?php echo $linhas[$i]["DatNasc"] ?>"></td>
                            <td><input type="char" name="Sexo" value="<?php echo $linhas[$i]["Sexo"] ?>" maxlength="1" size="1"></td>
                            <td><input type="time" name="HorarioE" value="<?php echo $linhas[$i]["HorarioE"] ?>"></td>
                            <td><input type="time" name="HorarioS" value="<?php echo $linhas[$i]["HorarioS"] ?>"></td>
                            <td>
                                <button>Editar</button>
                            </td>
                        </form>
                        <form action="/funcionarios.php" method="post">
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
        <form action="/funcionarios.php" method="post">
            <input type="hidden" name="acao" value="criar">
            <br><br><br>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Salario</th>
                        <th>CPF</th>
                        <th>Data Nascimento</th>
                        <th>Sexo</th>
                        <th>Hora Entrada</th>
                        <th>Hora Saida</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" id="Nome" name="Nome" required></td>
                        <td><input type="text" id="Telefone" name="Telefone" required></td>
                        <td><input type="text" id="Salario" name="Salario" required></td>
                        <td><input type="text" id="CPF" name="CPF" required></td>
                        <td><input type="date" id="DatNasc" name="DatNasc" required></td>
                        <td><input type="char" id="Sexo" name="Sexo" maxlength="1" required></td>
                        <td><input type="time" id="HorarioE" name="HorarioE" required></td>
                        <td><input type="time" id="HorarioS" name="HorarioS" required></td>
                        <td><button>ADD</button></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</body>

</html>