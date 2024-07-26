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

    <?php if ($seguranca){ ?>

    <?php
        $tabela = "usuarios";
        $order = "nome";
        $usuarios = buscar($conn, $tabela, 1, $order);

?>
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $usuario = buscaunica($conn, "usuarios", $id);
            updateuser($conn);
            ?>
            <h3>USUARIO SELECIONADO:  <?php echo $_GET['nome']; ?></h3>
       <?php }?>



<br>
    <form action="" method="post">
        <fieldset>
            <legend>Editar Usuarios</legend>
            <input class="form-control" id="floating-input" value="<?php echo $usuario ['id']; ?>" type="hidden" name="id" required>
            <input class="form-control" id="floating-input" value="<?php echo $usuario ['nome']; ?>" type="text" name="nome" placeholder="Nome" required>
            <input class="form-control" id="floating-input" value="<?php echo $usuario ['email']; ?>" type="email" name="email" placeholder="E-mail" required>
            <input class="form-control" id="floating-input" type="password" name="senha" placeholder="Senha">
            <input class="form-control" id="floating-input" type="password" name="confirmesenha" placeholder="Confirme sua senha">
            <input class="form-control" id="floating-input" value="<?php echo $usuario ['data_cadastro']; ?>"type="date" name="data_cadastro" placeholder="Data" required>
            <input type="submit" name="atualizar" value="atualizar">
        </fieldset>


    </form>
    <div class="container mt-5">
        <h2 class="mb-4">Gerênciador Usuarios</h2>
        <table border="1">
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



<?php
} ?>

</body>
</html>