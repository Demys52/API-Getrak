<?php
//$key        = "AIzaSyB4GDt6PcKdaoL2Q6gyCA1gmd0Ha6r6CSo";
// SE NECESSARIO CRIAR UM COMANDO PARA SUBSTITUIR OS ESPAÇOS POR '+'
//function convertlatlong ($endereco, $numero, $bairro, $cidade)
    //  FUNÇÃO POST
function convertlatlong ($endereco, $key)
{
//$endereco = "rua%20nossa%20senhora%20das%20graças%201014,%20pirambu,%20fortaleza%20ce";
    // Converter em latitude e longitude
    //inicia
    $ws = curl_init();
    //configuração do acesso
    curl_setopt_array($ws, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => "https://maps.googleapis.com/maps/api/geocode/json?address=$endereco&key=$key",
        CURLOPT_USERAGENT => 'Codular Sample cURL Request'
    ));
    $result = curl_exec($ws);
    //fecha
    curl_close($ws);
    $obj = json_decode($result);
    // CAPTURA OS DADOS DE STATUS, LATITUDE E LONGITUDE
    if ($obj->status === "OK")
    {
        $sts = $obj->status;
        $lat = $obj->results[0]->geometry->location->lat;
        $lng = $obj->results[0]->geometry->location->lng;
    }
    else
    {
        $sts = $obj->status;
        $lat = null;
        $lng = null;
        //$mensagem_error = $obj->error_message;
        // MENSAGEM DE ERRO AINDA NÃO INCLUIDA NA RESPOSTA !
    }
    //CRIA UM ARRAY QUE SERA CONVERTIDO NO RETORNO EM JSON
    $latlong = array ("status" => "$sts", "label" => "C", "coordenadas" => array("latitude" => $lat, "longitude" => $lng));
    //RETORNA AS CORDENADAS E ESTATUS
    return $latlong;
}
?>