<?php
function checkField($field)
{
    return empty($field);
}

function checkPrice($price)
{
    return floatval($price) <= 0;
}

function checkSkuLength($sku)
{
    $skuLength = strlen($sku);
    return !($skuLength >= 8 && $skuLength <= 10);
}
