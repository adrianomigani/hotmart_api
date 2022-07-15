<?php
include_once 'conecta.php';
$conn = new conecta();

//versao 1.0 hotmart ver no colom usando - descontinada
//$content = $_POST; 
//$nome_produto = $content["data"]["product"]["name"];
//$id_produto = $content["data"]["product"]["id"];
//$content["status"] != 'approved' 
//versao 1.0 hotmart

//versao 2.0 hotmart
$json = file_get_contents('php://input');
$content = json_decode($json, true);



$resultado = "inicio";

if (!$content || !$content["id"] || !$content["event"]) {
    $resultado = 'Impossível Cadastrar';
    exit();
}

$resultado = "fase passar variaveis";

//comprador 

$transaction = $content["data"]["purchase"]["transaction"];
$status = $content["data"]["purchase"]["status"];
$valor_com_taxa_juro = $content["data"]["purchase"]["full_price"]["value"];


$email = $content["data"]["buyer"]["email"];

$prod = $content["data"]["product"]["id"];
$plano = $content["subscription"]["plan"]["name"];



//$nome = utf8_decode($content["data"]["buyer"]["name"]);
//$sobrenome = utf8_decode($content["data"]["buyer"]["last_name"]);
//$cpf_venda = $content["data"]["buyer"]["doc"];
//$nome_completo = $nome . " " . $sobrenome;
//$telefone = $content["data"]["buyer"]["phone_checkout_number"];
//$telefonecode = $content["data"]["buyer"]["phone_checkout_local_code"];
//$whatsapp = $telefonecode . $telefone;


$resultado = "variaveis preenchiadas";


$rsProd = $conn->getProduto($prod);

if (!$rsProd) {
    echo 'Produto não encontrado'. $rsProd;
    exit();
}

$idProd = $rsProd["id"];

$rsUser = $conn->getUser($email);


if (!$rsUser) {

    $rsEmpresa = $conn->setEmpresa("sem telefone", "Nome: " . $email, $email);
    $idEmpresa = $rsEmpresa;

    $senha_inicial = $conn->gerar_senha(8, true, true, true, false);
    
    $rsUser = $conn->setUser("sem telefone", "Nome completo: " . $email, $email, $idEmpresa, $senha_inicial);
    $idUser = $rsUser;
} else {
    $idUser = $rsUser["id"];
}

$setVenda = $conn->setVenda($idUser, $idProd, $status, $transaction, $plano, "sem telefone", "Nome completo: " . $email, "sem cpf", $email);

if ($setVenda) {
    echo 'Vendido :)';
} else {
    echo 'Falha :(' . $setVenda;
}