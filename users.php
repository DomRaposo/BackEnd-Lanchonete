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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>

<?php include "layout/menu.php" ?>
<h1>Painel admnistrativo do site</h1>
<h3>Bem vindo, <?php echo $_SESSION['nome'];?></h3>
<h2> Gerenciador de usuarios </h2>





    <?php if ($seguranca){ ?>

    <?php
        $tabela = "usuarios";
        $order = "nome";
        $usuarios = buscar($conn, $tabela, 1, $order);
        inserir($conn);

        //deletar($conn, $tabela, $id);
        if(isset($_GET['id'])) {?>
            <h4 id="message">Você deseja deletar usuario <?php echo $_GET['nome']."?";?>

            </h4>
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


        <div class=" container card mt-3">
        <form action="" method="post">

                <h3 class="text-center mt-3">Inserir Usuarios</h3>
                <label class="mb-2">Usuario:</label>
                <input type="text" class="form-control" id="floating-input" name="nome" placeholder="Nome">
                <label class="mb-2">E-mail:</label>
                <input type="email" class="form-control" id="floating-input" name="email" placeholder="E-mail">
                <label class="mb-2">Senha:</label>
                <input type="password" class="form-control" id="floating-input" name="senha" placeholder="Senha">
                <label class="mb-2">Repita Senha:</label>
                <input type="password" class="form-control" id="floating-input" name="repetesenha" placeholder="Confirme sua senha">
                <input class="mt-3 mb-3 btn btn-primary" type="submit" name="cadastrar" value="Cadastrar">
    </main>


        </div>
    </form>
        <div class="container">
            <h2 class="text-center mt-3">Gerênciador Usuarios</h2>
            <table border="1" class="table table-striped table-light table-condensed mt-4">
                <thead >
                <tr>

                    <th class="bg-primary text-light">ID</thclass>
                    <th class="bg-primary text-light">Nome</th>
                    <th class="bg-primary text-light">Email</th>
                    <th class="bg-primary text-light">Data de cadastro</th>
                    <th class="bg-primary text-light style="width: 50px;">Ações</th>
                </tr>
                </thead>
                <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                  <tr>
                    <td><?php echo $usuario['id'];  ?></td>
                    <td><?php echo $usuario['nome']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td><?php echo date("d/m/Y", strtotime($usuario['data_cadastro'])); ?></td>

                      <td class="d-flex">
                          <a  class="m-1 btn btn-danger text-light" href="users.php?id=<?php echo $usuario['id']; ?>&nome=<?php echo $usuario['nome'];?>"><i class="fa-solid fa-trash" ></i></a>

                          <a class="m-1 btn btn-info text-light" href="edit_user.php?id=<?php echo $usuario['id']; ?>&nome=<?php echo $usuario['nome'];?>"><i class="fa-solid fa-pencil" ></i></a>
                      </td>

                  </tr>

            <?php  endforeach; ?>
            </tbody>
        </table>
       <p><i>Quantidade de Registros:</i> <b><?= count($usuarios)?></b></p>
       <?=paginate($conn);?>

    </div>


<?php
} ?>

</body>
</html>