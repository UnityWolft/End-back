<?php
function recuperaTexto(string $parametro): false|string
{
 $valor = isset($_REQUEST[$parametro]) ? $_REQUEST[$parametro] : false;
 return $valor;
}