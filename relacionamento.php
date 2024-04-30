<?php
$linhas = [];
$funcionarios = [];
$setores = [];

try {
    $PDO = new PDO('mysql:host=localhost;dbname=clinica', 'root', 'Flavio2012');
    if (isset($_POST['acao']) && $_POST['acao'] == 'criar') {
        $sql =
            "INSERT INTO relaciona (ID_Setor,ID_Funcionario)
            VALUES(
            {$_POST['Setor']},
            {$_POST['Funcionario']}
            )";
        $resultado = $PDO->query($sql);
    } else if (isset($_POST['acao']) && $_POST['acao'] == 'deletar') {
        $sql =
            "DELETE FROM relaciona
            WHERE ID_Setor = {$_POST['idSetor']} AND ID_Funcionario = {$_POST['idFuncionario']}";
        $resultado = $PDO->query($sql);
    }

    $sql =
        "SELECT
        f. ID AS idFuncionario,
        s.ID AS idSetor,
        f.Nome AS nomeFuncionario,
        s.Nome AS nomeSetor
        FROM
        relaciona r
        JOIN funcionario f ON r.ID_Funcionario = f.ID
        JOIN setor s ON r.ID_Setor = s.ID";

    $resultado = $PDO->query($sql);
    $linhas = $resultado->fetchAll();

    $sql =
        "SELECT 
    *
    FROM funcionario";
    $resultado = $PDO->query($sql);
    $funcionarios = $resultado->fetchALL();

    $sql =
        "SELECT
    *
    FROM setor";
    $resultado = $PDO->query($sql);
    $setores = $resultado->fetchALL();
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Relacionamentos</title>
    <meta name="description" content="Cadastro e visualização de setores">
    <link rel="icon" type="image/jpeg" href="https://static.vecteezy.com/ti/vetor-gratis/p3/5377647-logotipo-de-atendimento-medico-logotipo-clinica-vetor.jpg">
    <link href="/reset.css" rel="stylesheet">
    <link href="/estilo.css" rel="stylesheet">
</head>

<body>
    <h1>
        <img src="https://static.vecteezy.com/ti/vetor-gratis/p3/5377647-logotipo-de-atendimento-medico-logotipo-clinica-vetor.jpg" width="50" height="40" />
        Relacionamentos
    </h1>
    <div>
        <a href="http://localhost/"><button><b>MENU</b></button></a><br><br>
    </div>
    <div class="align-self-center">
        <table>
            <thead>
                <tr>
                    <th>ID_Funcionario</th>
                    <th>Nome_Funcionario</th>
                    <th>ID-Setor</th>
                    <th>Nome_Setor</th>
                    <th>Deletar</th>
                </tr>
            </thead>
            <tbody>


                <?php
                for ($i = 0; $i < count($linhas); $i++) {
                ?>
                    <tr>
                        <div class="tab-exibe">
                            <td style="background-color: Lemonchiffon;border:solid 3px black;"><?php echo $linhas[$i]["idFuncionario"] ?></td>
                            <td style="background-color: ivory;border:solid 3px black;"><?php echo $linhas[$i]["nomeFuncionario"] ?></td>
                            <td style="background-color: Lemonchiffon;border:solid 3px black;"><?php echo $linhas[$i]["idSetor"] ?></td>
                            <td style="background-color: ivory;border:solid 3px black;"><?php echo $linhas[$i]["nomeSetor"] ?></td>
                        </div>
                        <th>
                            <form action="/relacionamento.php" method="post">
                                <input type="hidden" name="acao" value="deletar">
                                <input type="hidden" name="idFuncionario" value="<?php echo $linhas[$i]["idFuncionario"] ?>">
                                <input type="hidden" name="idSetor" value="<?php echo $linhas[$i]["idSetor"] ?>">
                                <button>Deletar</button>
                            </form>
                        </th>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="align-self-center">
        <form action="/relacionamento.php" method="post">
            <input type="hidden" name="acao" value="criar">
            <br><br><br>
            <table>
                <thead>
                    <tr>
                        <th>Setor</th>
                        <th>Funcionário</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="Setor" id="Setor" required>
                                <?php
                                for ($i = 0; $i < count($setores); $i++) {
                                ?>
                                    <option value="<?php echo $setores[$i]['ID'] ?>"><?php echo $setores[$i]['Nome'] ?> - <?php echo $setores[$i]['LocalSet'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <select name="Funcionario" id="Funcionario" required>
                                <?php
                                for ($i = 0; $i < count($funcionarios); $i++) {
                                ?>
                                    <option value="<?php echo $funcionarios[$i]['ID'] ?>"><?php echo $funcionarios[$i]['Nome'] ?> - <?php echo $funcionarios[$i]['CPF'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                        <th><button>ADD</button></th>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</body>

</html>