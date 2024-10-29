<?php
// Caminho para o XML com os dados
$xmlFile = 'database/database.xml';

// Carrega o XML
if (file_exists($xmlFile)) {
    // Lê o arquivo XML e armazena o conteúdo
    $xml = simplexml_load_file($xmlFile);
} else {
    // Caso o arquivo XML não exista, exibe uma mensagem de erro
    exit('Erro: O arquivo XML não foi encontrado.');
}
?>
