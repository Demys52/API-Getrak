<?php
require_once("apiGetrak/login.php");
//receber login e senha
$login = login();
if(isset($login["falha"]))
{
        echo json_encode($login, JSON_UNESCAPED_UNICODE);
}
else
{
        if (!isset($_SESSION)) {session_start();}
        $_SESSION["token"] = $login;
        $login = json_decode($login);
        $login = $login->access_token;
        echo json_encode($login);
}
// Session irá permanecer para meus testes, mas o token deve ser retornado em json para apk
?>