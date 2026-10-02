<?php

function e(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}

function dinero(string $valor): string
{
    return '$ ' . number_format((float) $valor, 2, ',', '.');
}
