<?php

/**
 * Função para deixar somente números
 * 
 * @param string $param
 * @return number
 */
function somenteNumeros($param) {
    return preg_replace('/[^0-9]/', '',  $param);
}

function formatarValor($valor) {
    $newValor = str_replace(['R$','.',','],['','','.'], $valor);
    return $newValor;
}
