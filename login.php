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

<body >
    <main class=" mt-4 container card" >

    <form action="" method="POST" >


        <h1 class="h3 mb-3 fw-normal mt-3 text-center" >Insira seu Login</h1>
        <div class="form-floating">
            <label>E-mail:</label>
            <input type="email" class="form-control mb-2" id="floating-input" name="email" placeholder="Informe seu E-mail" required>
            <label>Senha:</label>
            <input type="password" class="form-control mb-2" id="floating-input" name="senha" placeholder="insira sua senha:">
            <input type="submit" class="btn btn-info  w-100  py-2 mt-2 mb-3" id="floating-input" name="acessar" value="Acessar">

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