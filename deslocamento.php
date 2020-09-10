<?php
if (!isset($_SESSION)) {session_start();}

$token = $_SESSION["token"];
$token = json_decode($token);
$accessToken = $token->access_token;
//exit($accessToken);
//print_r($token);

$idVeiculo = "7742690";
$dataI = "2020-01-28T06:00:00";
$dataF = "2020-01-28T23:59:59";
//inicia
$ws = curl_init();
//configuração do acesso
curl_setopt_array($ws, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => "https://api.getrak.com/v0.1/deslocamentos/$idVeiculo/$dataI/$dataF",
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
  echo "cURL Error #:" . $err;
}
else
{
  //print_r($obj);
  $_SESSION["resultado"] = $obj;
  //print_r($_SESSION["resultado"]);
  $resultado = $_SESSION["resultado"];
  //print_r($_SESSION["resultado"]);
  for ($x=0; $x < count($resultado); $x++)
  {
    $tempoParada = tempo($resultado[$x]->data_ini, $resultado[$x]->data_fim);
    if($tempoParada >= 5) // 5 É O TEMPO DE PARADA EM MINUTOS
    {
      if($resultado[$x]->status_online == "0") // Zero é parado
      {
        $paradas[] = array("local" => array("latitude"=> $resultado[$x]->endereco_origem->lat,
                                            "longitude"=> $resultado[$x]->endereco_origem->lon),
                           "tempo" => tempo($resultado[$x]->data_ini, $resultado[$x]->data_fim));
      }
    }
    
  }
  print_r($paradas);
    /*
    if(isset($obj->error))
    {require_once("index.php"); echo "por enquanto atualiza a pagina";}
    else
    {
        echo $obj;
    }*/
}
function tempo ($datai, $dataf)
{
  $datai = dataHora($datai);
  $dataf = dataHora($dataf);
  $datai = mktime($datai["h"],$datai["m"],$datai["s"],$datai["mes"],$datai["d"],$datai["a"]);
  $dataf = mktime($dataf["h"],$dataf["m"],$dataf["s"],$dataf["mes"],$dataf["d"],$dataf["a"]);
  $difMinutos = ($dataf - $datai)/60;
  return $difMinutos;
}
function dataHora($data)
{
  $dataHora = explode("T", $data);
  $data = $dataHora[0];
  $hora = $dataHora[1];
  $hora = explode(":", $hora);
  $data = explode("-", $data);
  $retorno["h"] = $hora[0];
  $retorno["m"] = $hora[1];
  // segundo vindo com fuso horário (-3)
  $retorno["s"] = $hora[2];
  $retorno["s"] = explode("-", $retorno["s"]);
  $retorno["s"] = $retorno["s"][0];
  // fim de ajuste no segundo
  $retorno["mes"] = $data[1];
  $retorno["d"] = $data[2];
  $retorno["a"] = $data[0];
  
  return $retorno;
}
?>