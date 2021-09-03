<?php

/**
 * Função para deixar somente números
 *
 * @param string $param
 * @return integer
 */
function somenteNumeros($param) {
    return preg_replace('/[^0-9]/', '',  $param);
}

/**
 * Função para formatar valores
 *
 * @param string $valor
 * @return decimal
 */
function formatarValor($valor) {
    $newValor = str_replace(['R$','.',','],['','','.'], $valor);
    return $newValor;
}
