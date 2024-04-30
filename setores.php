<?php
$linhas = [];
try {
    $PDO = new PDO('mysql:host=localhost;dbname=clinica', 'root', 'Flavio2012');
    if (isset($_POST['acao']) && $_POST['acao'] == 'criar') {
        $sql =
            "INSERT INTO setor (LocalSet, Nome)
            VALUES(
            '{$_POST["LocalSet"]}',
            '{$_POST["Nome"]}')";
        $resultado = $PDO->query($sql);

    } else if(isset($_POST['acao']) && $_POST['acao']=='editar'){
        $sql=
        "UPDATE setor
        SET
            LocalSet = '{$_POST["LocalSet"]}',
            Nome = '{$_POST["Nome"]}'
        WHERE ID = {$_POST['ID']}";

        $resultado = $PDO->query($sql);

    } else if (isset($_POST['acao']) && $_POST['acao'] == 'deletar'){
        $sql=
        "DELETE FROM setor
        WHERE ID = {$_POST['ID']}";

        $resultado = $PDO->query($sql);
    }

    $sql =
        "SELECT
        *
        FROM
        setor";
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
    <title>Setores</title>
    <meta name="description" content="Cadastro e visualização de setores">
    <link rel="icon" type="image/jpeg" href="https://static.vecteezy.com/ti/vetor-gratis/p3/5377647-logotipo-de-atendimento-medico-logotipo-clinica-vetor.jpg">
    <link href="/reset.css" rel="stylesheet">
    <link href="/estilo.css" rel="stylesheet">
</head>

<body>
    <h1>
        <img src="https://static.vecteezy.com/ti/vetor-gratis/p3/5377647-logotipo-de-atendimento-medico-logotipo-clinica-vetor.jpg" width="50" height="40"/>
        Setores
    </h1>
    <div>
        <a href="http://localhost/"><button><b>MENU</b></button></a><br><br>
    </div>
    <div class="align-self-center">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>LocalSet</th>
                    <th>Nome</th>
                    <th>Editar</th>
                    <th>Deletar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($linhas); $i++) {
                ?>
                    <tr>
                        <form action="/setores.php" method="post">
                            <input type="hidden" name="acao" value="editar">
                            <td><input type="int" name="ID" value="<?php echo $linhas[$i]["ID"] ?>"readonly  style="background-color: Lemonchiffon;"></td>
                            <td><input type="text" name="LocalSet" value="<?php echo $linhas[$i]["LocalSet"] ?>"></td>
                            <td><input type="text" name="Nome" value="<?php echo $linhas[$i]["Nome"] ?>"></td>
                            <td><button><b>Editar</b></button></td>
                        </form>
                        <form action="/setores.php" method="post">
                            <input type="hidden" name="acao" value="deletar">
                            <input type="hidden" name="ID" value="<?php echo $linhas[$i]["ID"] ?>">
                            <td><button>Deletar</button></td>
                        </form>
                    <?php
                }
                    ?>
            </tbody>
        </table>
    </div>
    <div class="align-self-center">   
        <form action="/setores.php" method="post">
            <input type="hidden" name="acao" value="criar">
            <br><br><br>
            <table>
                <thead>
                    <tr>
                        <th>Local do Setor</th>
                        <th>Nome</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" id="LocalSet" name="LocalSet"></td>
                        <td><input type="text" id="Nome" name="Nome"></td>
                        <td><button>ADD</button></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</body>

</html>