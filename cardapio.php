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
    <title>Painel Admin - Cardapio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>

    <h1>Painel admnistrativo do site</h1>
    <h3>Bem vindo, <?php echo $_SESSION['nome'];?></h3>
    <h2> Gerenciador de Cardapio </h2>

    <?php include "layout/menu.php" ?>

<?php if ($seguranca){ ?>

    <?php
        $tabela = "cardapio";
        $order = "titulo";
        $cardapios = buscar($conn, $tabela, 1, $order);

    if(isset($_GET['id'])) { ?>
    <h4>Você deseja deletar este item? <?php echo $_GET['titulo']."?";?></h4>
    <form action="cardapio.php" method="post">
        <input type="hidden" name="id" value="<?php echo $_GET['id']?>">
        <input type="submit" name="deletar" value="Deletar">

    </form>
<?php }
    if (isset($_POST['deletar']) AND !empty($_POST['id'])) {
        deletar($conn, "cardapio", $_POST['id']);
    }

?>

        <div class="container">
            <div>
                <a href="form_cardapio.php">Inserir novo item</a>
            </div>
            <h2 class="mb-4">Gerênciador Usuarios</h2>
            <table border="1">
                <thead class="thead-dark">
                <tr>
                    <th>imagem</th>
                    <th>titulo</th>
                    <th>Data cadastro</th>
                    <th style="width: 70px;">Ações</th>
                </tr>
                </thead>
            <tbody>
            <?php foreach ($cardapios as $cardapio): ?>
                  <tr>


                    <td><?php echo $cardapio['imagem'];  ?></td>
                    <td><?php echo $cardapio['titulo']; ?></td>
                    <td><?php echo $cardapio['data_registro']; ?></td>

                      <td>
                          <a href="cardapio.php?id=<?php echo $cardapio['id']; ?>&titulo=<?php echo $cardapio['titulo'];?>"><i class="fa-solid fa-trash" style="color:red;"></i></a>
                          |
                          <a href="form_cardapio.php?id=<?php echo $cardapio['id']; ?>&titulo=<?php echo $cardapio['titulo'];?>"><i class="fa-solid fa-pencil" style="color:blue;"></i></a>
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