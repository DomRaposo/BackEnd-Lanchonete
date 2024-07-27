<?php
require_once ("conexao.php");
function login($conn){
    if (isset($_POST['acessar']) AND !empty ($_POST['email']) AND !
        empty ($_POST['senha'])){
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $senha = sha1($_POST['senha']);
        $query = "SELECT * FROM usuarios where email= '$email' AND senha= '$senha'";
        $executar = mysqli_query($conn, $query);
        $return = mysqli_fetch_assoc($executar);
        if (!empty($return ['email'])) {
            //echo "Seja Bem Vindo " . $return['nome'];}
            session_start();
            $_SESSION['nome'] = $return['nome'];
            $_SESSION['id'] = $return['id'];
            $_SESSION['ativa'] = TRUE;
            header("location: index.php");
        }
        else {
            echo "Usuario ou senha não encontrado!";
            }
        }

}
function logout(){
    session_start();
    session_unset();
    session_destroy();
    header("location: login.php");
    }
/* seleciona(busca) no BD um resultado com base no ID */
function  buscaunica($conn, $tabela, $id){
    $query = "SELECT * FROM $tabela where id =". (int) $id;
    $execute = mysqli_query($conn, $query);
    $result = mysqli_fetch_assoc($execute);
    return $result;


}
/* seleciona(busca) no BD um resultado com base no WHERE */
function buscar($conn, $tabela, $where = 1, $order=""){
    if(!empty($order)){
        $order = "ORDER BY $order";
    }
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit=10;
    $offset =($page-1) * $limit;
    $query = "SELECT * FROM $tabela WHERE $where $order LIMIT $limit OFFSET $offset; ";
    $execute = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($execute, MYSQLI_ASSOC);
    return $result;

}
function inserir($conn){
    if(isset($_POST['cadastrar']) AND !empty($_POST['email']) AND !empty($_POST['senha']) ) {
        $erros = array();
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $nome = mysqli_real_escape_string($conn, $_POST['nome']);
        $senha = sha1($_POST['senha']);
        if ($_POST['senha'] != $_POST['confirmesenha']) {
            $erros[] = "Senhas não conferem!";
        }

        $queryemail = "SELECT email FROM usuarios WHERE email = '$email'";
        $buscaemail = mysqli_query($conn, $queryemail);
        $verifica = mysqli_num_rows($buscaemail);

        if (!empty($verifica)) {
            $erros[] = "Email já cadastrado";

        }
        if (empty($erros)) {
            //inserir o usuario no BD
            $query = "INSERT INTO usuarios(nome, email, senha, data_cadastro) VALUES ('$nome','$email', '$senha', NOW() )";
            $executar = mysqli_query($conn, $query);
            if ($executar) {
                echo "Usuario inserido com sucesso!";
            } else {
                echo "Erro ao inserir o usuario.";
            }
        } else {
            foreach ($erros as $erro) {
                echo "<p>$erro</p>";
            }
        }
    }
}
//Deletar algum dado.
function deletar($conn, $tabela, $id){
    if(!empty($id)){

        $query = "DELETE FROM $tabela WHERE id=". (int) $id;
        $executar = mysqli_query($conn, $query);
        if ($executar) {

            echo '

    <div id="message" style="color: #cc0000; width: 100%; background-color: #ffcccc; height: 50px; display: flex; align-items: center; justify-content: center;">
        Dado deletado com sucesso
        
    </div>
    <script>
        setTimeout(function() {
            document.getElementById("message").style.display = "none";
        }, 2000);
    </script>
';


        }else{
            echo "Erro ao tentar deletar este dado";
        }
    }

}

function updateuser($conn)
{
    if (isset($_POST['atualizar']) and !empty($_POST['email'])) {
        $erros = array();
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $nome = mysqli_real_escape_string($conn, $_POST['nome']);
        $senha = "";
        $data = mysqli_real_escape_string($conn, $_POST['data_cadastro']);

        if (empty($data)) {
            $erros[] = "Preencha a data de cadastro";
        }
        if (empty($email)) {
            $erros[] = "Preencha seu e-mail corretamente.";
        }
        if (!empty($_POST['senha'])) {
            if ($_POST['senha'] == $_POST['confirmesenha']) {
                $senha = sha1($_POST['senha']);
            } else {
                $erros[] = "Senhas não conferem!";
            }
        }

        $queryemailatual = "SELECT email FROM usuarios WHERE id = $id";
        $buscaemailatual = mysqli_query($conn, $queryemailatual);
        $returnemail = mysqli_fetch_assoc($buscaemailatual);
        $queryemail = "SELECT email FROM usuarios WHERE email = '$email' AND email <>'" . $returnemail ['email'] . "'";
        $buscaemail = mysqli_query($conn, $queryemail);
        $verifica = mysqli_num_rows($buscaemail);

        if (!empty($verifica)) {
            $erros[] = "Email já cadastrado";
        }
        if (empty($erros)) {
            //update usuarios
            if (!empty($senha)) {
                $query = "UPDATE usuarios SET nome = '$nome', email = '$email', senha = '$senha', data_cadastro = '$data' WHERE id=" . $id;
            } else {
                $query = "UPDATE usuarios SET nome = '$nome', email = '$email', data_cadastro = '$data' WHERE id=" . $id;
            }
            $executar = mysqli_query($conn, $query);

            if ($executar) {
                echo "Dado atualizado com sucesso.";

            } else {
                echo "Erro ao tentar atualizar este dado";
            }
        } else {
            foreach ($erros as $erro) {
                echo "<p>$erro</p>";
            }
        }
    }

}

function insertcardapio($conn){
    if((isset($_POST['insert']) AND !empty($_POST['titulo']) AND !empty($_POST['descricao'])) ) {

        $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
        $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
        $data = mysqli_real_escape_string($conn, $_POST['data_registro']);
        $imagem = !empty($_FILES['imagem']['name']) ? $_FILES['imagem']['name'] : "";
        if (!empty($imagem)){
            $caminho = "imagens/upload/";
            $imagem = uploadimage($caminho);
        }
            $query = "INSERT INTO cardapio (titulo, descricao, imagem, data_registro) VALUES ('$titulo','$descricao', '$imagem','$data' )";
            $executar = mysqli_query($conn, $query);
            if ($executar) {
                header("location: cardapio.php");
            } else {
                echo "Erro ao inserir o item.";
        }
    }
}
function updatecardapio($conn){
    if((isset($_POST['update']) AND !empty($_POST['titulo']) AND !empty($_POST['descricao'])) ) {
        $id = (int) $_POST['id'];
        $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
        $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
        $data = mysqli_real_escape_string($conn, $_POST['data_registro']);
        $imagem =  "";
        if(!empty($id)){
        $query = "UPDATE cardapio SET titulo = '$titulo', descricao = '$descricao', data_registro = '$data'
            WHERE id = '$id'";
            $executar = mysqli_query($conn, $query);
            if ($executar) {
                header("location: cardapio.php");
            } else {
                echo "Erro ao atualizar o item.";
            }
        }

    }
}

function uploadimage($caminho){
    if(!empty($_FILES['imagem'] ['name'])){
        $nomeimagem = $_FILES['imagem'] ['nome'];
        $tipo = $_FILES ['imagem'] ['type'];
        $nometemporario = $_FILES['imagem']['tmp_name'];
        $tamanho = $_FILES['imagem']['size'];
        $erros = array();
        $tamanhomaximo = 1024 * 1024 * 5; //5MB
        if ($tamanho > $tamanhomaximo){
            $erros[] = "Seu arquivo excede o tamanho maximo<br>";
        }
        $arquivospermitidos = ["png", "jpg", "jpeg"];
        $extensao = pathinfo($nomeimagem, PATHINFO_EXTENSION);
            if (!in_array($extensao, $arquivospermitidos)) {
                $erros[] = "Arquivo não permitido.<br>";
            }
        $typespermitidos = ["image/jpg", "image/png", "imagem/jpeg"];
            if(!in_array($tipo, $typespermitidos)){
                $erros[] = "Tipo de arquivo não permitido.<br>";
            }
            if(!empty($erros)){
                foreach ($erros as $erro) {
                    echo $erro;

                }
            }else{

                $hoje = date ("d-m-Y_h-i");
                $novonome = $hoje."-".$nomeimagem;
                if (move_uploaded_file($nometemporario, $caminho.$novonome)){
                    return $novonome;

                }else{
                    return FALSE;
                }
            }
    }
}
function paginate($conn) {
    // Consulta para contar o total de registros
    $qtd_usuarios = "SELECT COUNT(*) AS total FROM usuarios";
    $usuarios_qtd = $conn->query($qtd_usuarios);
    $usuarios_count = $usuarios_qtd->fetch_assoc();
    $count_usuarios = $usuarios_count["total"];

    // Cálculo para a paginação
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;


    // Total de páginas
    $numero_de_paginas = ceil($count_usuarios / $limit);


    // Exibir paginação
    echo '<ul class="pagination">';
    for ($p = 1; $p <= $numero_de_paginas; $p++) {
        if ($p == $page) {
            echo "<li class='page-item active'><span class='page-link'>{$p}</span></li>";
        } else {
            echo "<li class='page-item'><a class='page-link' href='?page={$p}'>{$p}</a></li>";
        }
    }
    echo '</ul>';
}



?>
