<?php
$linhas = [];

try {
    $PDO = new PDO('mysql:host=localhost;dbname=clinica', 'root', 'Flavio2012');
    if (isset($_POST['acao']) && $_POST['acao'] == 'criar') {
        $sql =
            "INSERT INTO
            medico (Nome, CRM, CPF, Sexo, DatNasc, Telefone)
        VALUES (
            '{$_POST['Nome']}',
            '{$_POST['CRM']}',
            '{$_POST['CPF']}',
            '{$_POST['Sexo']}',
            '{$_POST['DatNasc']}',
            '{$_POST['Telefone']}'

        )";
        $resultado = $PDO->query($sql);
    } else if (isset($_POST['acao']) && $_POST['acao'] == 'editar') {

        $sql =
            "UPDATE medico
        SET
            Nome = '{$_POST['Nome']}',
            CRM = '{$_POST['CRM']}',
            CPF = '{$_POST['CPF']}',
            Sexo = '{$_POST['Sexo']}',
            DatNasc = '{$_POST['DatNasc']}',
            Telefone = '{$_POST['Telefone']}'
        WHERE ID={$_POST['ID']}
            ";

        $resultado = $PDO->query($sql);
    } else if (isset($_POST['acao']) && $_POST['acao'] == 'deletar') {
        $sql =
            "DELETE FROM medico
        WHERE ID= {$_POST['ID']}";

        $resultado = $PDO->query($sql);
    }

    $sql =
        "SELECT 
        *
         FROM medico";

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
    <title>Medicos</title>
    <meta name="description" content="Cadastro e visualização de setores">
    <link rel="icon" type="image/jpeg" href="https://static.vecteezy.com/ti/vetor-gratis/p3/5377647-logotipo-de-atendimento-medico-logotipo-clinica-vetor.jpg">
    <link href="/reset.css" rel="stylesheet">
    <link href="/estilo.css" rel="stylesheet">

</head>

<body>
    <h1>
        <img src="https://static.vecteezy.com/ti/vetor-gratis/p3/5377647-logotipo-de-atendimento-medico-logotipo-clinica-vetor.jpg" width="50" height="40" />
        Médicos
    </h1>
    <div>
        <a href="http://localhost/"><button><b>MENU</b></button></a><br><br>
    </div>
    <div class="align-self-center">
        <table>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">CRM</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Sexo</th>
                    <th scope="col">DatNasc</th>
                    <th scope="col">Telefone</th>
                    <th>Editar</th>
                    <th>Deletar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($linhas); $i++) {
                ?>
                    <tr>
                        <form action="/medicos.php" method="post">
                            <input type="hidden" name="acao" value="editar">
                            <td><input type="int" name="ID" value="<?php echo $linhas[$i]["ID"] ?>" readonly size="4" style="background-color: Lemonchiffon;"></td>
                            <td><input type="text" name="Nome" value="<?php echo $linhas[$i]["Nome"] ?>"></td>
                            <td><input type="text" name="CRM" value="<?php echo $linhas[$i]["CRM"] ?>"></td>
                            <td><input type="text" name="CPF" value="<?php echo $linhas[$i]["CPF"] ?>"></td>
                            <td><input type="char" name="Sexo" value="<?php echo $linhas[$i]["Sexo"] ?>" maxlength="1" size="1"></td>
                            <td><input type="date" name="DatNasc" value="<?php echo $linhas[$i]["DatNasc"] ?>"></td>
                            <td><input type="text" name="Telefone" value="<?php echo $linhas[$i]["Telefone"] ?>"></td>
                            <td><button><b>Editar</b></button></td>
                        </form>
                        <form action="/medicos.php" method="post">
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
        <form action="/medicos.php" method="post">
            <input type="hidden" name="acao" value="criar">
            <br><br><br>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CRM</th>
                        <th>CPF</th>
                        <th>Sexo</th>
                        <th>Data Nascimento</th>
                        <th>Telefone</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" id="Nome" name="Nome" required></td>
                        <td><input type="text" id="CRM" name="CRM" required></td>
                        <td><input type="text" id="CPF" name="CPF" required></td>
                        <td><input type="text" id="Sexo" name="Sexo" maxlength="1" required></td>
                        <td><input type="date" id="DatNasc" name="DatNasc" required></td>
                        <td><input type="text" id="Telefone" name="Telefone" required></td>
                        <td><button>ADD</button></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</body>

</html>