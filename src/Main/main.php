<?php
require '../../vendor/autoload.php';

use Automattic\WooCommerce\Client;
use Automattic\WooCommerce\HttpClient\HttpClientException;

$woocommerce = new Client(
    'https://.com.br',
    '',
    '',
    [
        'version' => 'wc/v3',
    ]
);

try {
    




    //PESQUISANDO PRODUTO PARA SABER CÓDIGO
    $results = $woocommerce->get('products?sku=8701012050098786');
    $lastResponse = $woocommerce->http->getResponse();
    $produto = json_decode($lastResponse->getBody());

    //ATUALIZANDO STOCK DO PRODUTO
    $results = $woocommerce->put('products/'.$produto[0]->id, [
        'manage_stock' => 1,
        'stock_quantity' => 10
    ]);

    $produto = json_decode($lastResponse->getBody());  
    echo (string)$produto[0]->stock_quantity;
} catch (HttpClientException $e) {
    echo '<pre><code>' . print_r( $e->getMessage(), true ) . '</code><pre>'; // Error message.
    echo '<pre><code>' . print_r( $e->getRequest(), true ) . '</code><pre>'; // Last request data.
    echo '<pre><code>' . print_r( $e->getResponse(), true ) . '</code><pre>'; // Last response data.
}
