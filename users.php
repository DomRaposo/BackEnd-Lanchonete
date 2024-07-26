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
    <title>Painel Admin - Usuarios</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>


<h1>Painel admnistrativo do site</h1>
<h3>Bem vindo, <?php echo $_SESSION['nome'];?></h3>
<h2> Gerenciador de usuarios </h2>

<?php include "layout/menu.php" ?>



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
        <div >
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
        <div class="container">
            <h2>Gerênciador Usuarios</h2>
            <table border="1">
                <thead >
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