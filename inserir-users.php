<?php
session_start();
$seguranca = isset($_SESSION['ativa']) ?TRUE : header("location: login.php");
require_once "functions.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1"
    <title></title>
    <link href="style.css" rel="stylesheet">
</head>
<body>




    <nav class="navbar navbar-dark bg-primary">

        <div>
            <a href="index.php" class="btn btn-primary active" role="button" aria-pressed="true">Painel</a>
            <a href="users.php" class="btn btn-primary active" role="button" aria-pressed="true">Gerenciar Usuarios</a>
            <a href="logout.php" class="btn btn-primary active" role="button" aria-pressed="true">Sair</a>

        </div>

    </nav>
    <?php if ($seguranca){ ?>

    <?php
        $tabela = "usuarios";
        $order = "nome";
        $usuarios = buscar($conn, $tabela, 1, $order);
        inserir($conn);

        //deletar($conn, $tabela, $id);
        if(isset($_GET['id'])) {?>
            <h4>Você deseja deletar usuario <?php echo $_GET['nome']."?";?></h4>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $_GET['id']?>">
                <input type="submit" name="deletar" value="Deletar">

            </form>
        <?php }?>
        <?php
            if (isset($_POST['deletar'])) {
                if ( $_SESSION['id'] != $_POST['id']) {
                    deletar($conn, "usuarios", $_POST['id']);
                }else{
                    echo "<br>Você não pode deletar o usuario que está logado.<br>";
                }

            }
        ?>


<br>
    <main class="w-100 m-auto form-container" >
        <div class="form-floating">

        <form action="" method="post">
            <fieldset>
                <legend><h6>Inserir Usuarios</h6></legend>
                <input type="text" class="form-control" id="floating-input" name="nome" placeholder="Nome">
                <input type="email" class="form-control" id="floating-input" name="email" placeholder="E-mail">
                <input type="password" class="form-control" id="floating-input" name="senha" placeholder="Senha">
                <input type="password" class="form-control" id="floating-input" name="repetesenha" placeholder="Confirme sua senha">
                <input type="submit" name="cadastrar" value="Cadastrar">
    </main>
        </fieldset>

        </div>
    </form>
        <div class="container mt-5">
            <h2 class="mb-4">Gerênciador Usuarios</h2>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Data de cadastro</th>
                    <th style="width: 70px;">Ações</th>
                </tr>
                </thead>
            <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                  <tr>
                    <td><?php echo $usuario['id'];  ?></td>
                    <td><?php echo $usuario['nome']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td><?php echo $usuario['data_cadastro']; ?></td>

                      <td>
                          <a href="users.php?id=<?php echo $usuario['id']; ?>&nome=<?php echo $usuario['nome'];?>"><i class="fa-solid fa-trash" style="color:red;"></i></a>
                          |
                          <a href="edit_user.php?id=<?php echo $usuario['id']; ?>&nome=<?php echo $usuario['nome'];?>"><i class="fa-solid fa-pencil" style="color:blue;"></i></a>
                      </td>

                  </tr>

            <?php  endforeach; ?>
            </tbody>
        </table>



    </div>


<?php
} ?>

</body>
</html>