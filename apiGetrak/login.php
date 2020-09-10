<?php
//      RECEBER LOGIN DOS USUARIOS MAS POR ENQUANTO VOU INFORMAR DIRETO
function login()
{
        $client_id = "login"; // login do cliente
        $client_password = "senha"; // senha do cliente
        $authorization = "="; // código fornecido pela Gertrak
        //$authorization = base64_encode($client_id.":".$client_password);
        
        $ws = curl_init();
        //configuração do acesso
        curl_setopt_array($ws, array(
                CURLOPT_URL => "https://api.getrak.com/newkoauth/oauth/token",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "grant_type=password&username=$client_id@indikar&password=$client_password", "https://api.getrak.com/newkoauth/oauth/token",
                CURLOPT_HTTPHEADER => array(
                  "Content-Type: application/x-www-form-urlencoded",
                  "Accept: application/json",
                  "Authorization: Basic $authorization"
                ),
              ));
                
        $result = curl_exec($ws);
        $err = curl_error($ws);
        curl_close($ws);
        $obj = json_decode($result);
        
        if ($err)
        {
          return array("falha"=>"cURL Error #:" . $err);
        } else
        {
                return $result;
        }
}
?>