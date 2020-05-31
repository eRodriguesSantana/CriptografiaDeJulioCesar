<?php

function DecifraLetra($letra, $qtdCasas)
{
    $letra = strtolower($letra);

    $cifrado = ['a','b','c','d','e','f','g','h','i','j', 'k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];

    $j = 0;

    while ($j < count($cifrado) && ($letra != $cifrado[$j]))
        $j++;

    while($qtdCasas > 0)
    {
        $j--;

        if($j < 0)
            $j = count($cifrado)-1;

        $qtdCasas--;
    }        
    return strtolower($cifrado[$j]);
}

function DecifraMensagem($qtdCasas, $mensagem)
{
    $resposta = "";

    for($i=0; $i < strlen($mensagem); $i++)
    {            
        if($mensagem[$i] == " ")
            $resposta .= " ";
        else if($mensagem[$i] < chr(48) || $mensagem[$i] < chr(65) || $mensagem[$i] < chr(97))
            $resposta .= $mensagem[$i];
        else
            $resposta .= DecifraLetra($mensagem[$i], $qtdCasas);                       
    }
    return strtolower($resposta);
}

$urlReceive = "https://api.codenation.dev/v1/challenge/dev-ps/generate-data?token=f5c5b23140af4521b4acaab33de23966da0a6260";

$ch = curl_init();

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $urlReceive);

$result = curl_exec($ch);

curl_close($ch);

$result = json_decode($result, true);

$decifrado = DecifraMensagem($result['numero_casas'], $result['cifrado']);

$resp = array(
    'numero_casas' => (int)json_encode($result['numero_casas']),
    'token' => $result['token'],
    'cifrado' => $result['cifrado'],
    'decifrado' => $decifrado,
    'resumo_criptografico' => sha1($decifrado)
);

print_r($resp);
$fp = fopen("answer.json", "w");
fwrite($fp, json_encode($resp));
fclose($fp);

?>

<form action="https://api.codenation.dev/v1/challenge/dev-ps/submit-solution?token=f5c5b23140af4521b4acaab33de23966da0a6260"
      method="POST" 
      enctype="multipart/form-data">
        Enviar o arquivo: <input type="file" name="answer" />
        <input type="submit" value="Enviar" />
</form>

<?php

/*$pasta_upload = '/home/student/Imagens/';
$arquivo = $pasta_upload . $_FILES['answer']['name'];

if (move_uploaded_file($_FILES['answer']['tmp_name'], $arquivo))
    echo "Arquivo recebido!";
else
    echo "Arquivo não recebido."; */

?>
