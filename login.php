<?php
require_once "functions.php";
require_once "conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="style.css" rel="stylesheet">
  </head>

<body class="d-flex align-items-center py-4 bg-body-tertiary ">
    <main class="w-100 m-auto form-container" >

    <form action="" method="POST" >


        <h1 class="h3 mb-3 fw-normal">Insira seu Login</h1>
        <div class="form-floating">
            <input type="email" class="form-control" id="floating-input" name="email" placeholder="Informe seu E-mail" required>
            <input type="password" class="form-control" id="floating-input" name="senha" placeholder="insira sua senha:">
            <input type="submit" class="btn btn-primary w-100 py-2" id="floating-input" name="acessar" value="acessar">

        </div>
    </form>






<?php
if (isset($_POST['acessar'])) {
    login($conn);
}
?>
    </main>
</body>
</html>