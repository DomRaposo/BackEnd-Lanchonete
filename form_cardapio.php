<?php
session_start();
$seguranca = isset($_SESSION['ativa']) ?TRUE : header("location: login.php");
require_once "functions.php";
insertcardapio($conn);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1"
    <title></title>

</head>
<body>

    <?php if ($seguranca){ ?>

<h1>Painel admnistrativo do site</h1>
<h3>Bem vindo, <?php echo $_SESSION['nome'];?></h3>
<h2> Gerenciador do cardapio </h2>
    <?php include "layout/menu.php" ?>

    <?php
        $id = "";
        $titulo = "";
        $descricao = "";
        $data = date('Y-m-d');
        $action = "insert";

        ?>

       <?php
         if (isset($_GET['id'])) {
             $idget = $_GET['id'];
             $itemcardapio = buscaunica($conn, "cardapio", $idget);
             if(!empty($itemcardapio['titulo'])){
                 $id = $itemcardapio['id'];
                 $titulo = $itemcardapio['titulo'];
                 $descricao = $itemcardapio['descricao'];
                 $data = $itemcardapio['data_registro'];
                 $action = "update";
             }
            if(isset($_POST['update'])) {
                updatecardapio($conn);
            }

         }
             ?>
       <?php //}?>



<br>
    <form action="" method="post" enctype = "multipart/form-datass ">
        <fieldset>
            <legend>Inserir / Editar Item do cardapio</legend>
        <div>
            <input value="<?php echo $id; ?>" type="hidden" name="id" required>
        </div>
        <div>
            <input type="file" name="imagem">
        </div>
        <div>
            <input value="<?php echo $titulo; ?>" type="text" name="titulo" placeholder="Nome" required>
        </div>
        <div>
            <textarea name="descricao"><?php echo $descricao; ?></textarea>
        </div>
        <div>
            <input value="<?php echo $data; ?>"type="date" name="data_registro" required>
        </div>
        <div>
            <input type="submit" name="insert"  value="Salvar">
        </div>
        </fieldset>


    </form>

        <?php
        } ?>


</body>
</html>