<?php
function getVeiculos()
{ // lembrar de receber o token pela função e não pela session
  if (!isset($_SESSION)) {session_start();}
  $token = $_SESSION["token"];
  $token = json_decode($token);
  $accessToken = $token->access_token;
  //exit($accessToken);
  //print_r($token);
  
  //inicia
  $ws = curl_init();
  //configuração do acesso
  curl_setopt_array($ws, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => "https://api.getrak.com/v0.1/localizacoes",
      CURLOPT_USERAGENT => 'Codular Sample cURL Request',
      CURLOPT_HTTPHEADER => array(
                    "Accept: application/json",
                    "Authorization: Bearer $accessToken"
                  ),
  ));
  $result = curl_exec($ws);
  $err = curl_error($ws);
  //fecha
  curl_close($ws);
  $obj = json_decode($result);
  
  if ($err) {
     return array("falha"=>"cURL Error #:" . $err);
  } else {
      return $obj;
  }
}
?>