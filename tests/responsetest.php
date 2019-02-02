<?php

$data = ["A","B","C","D","E","F","G","H"];

$index = $_REQUEST["id"] ?? -1;
if($index > 0)
{
    $value = $data[$index];
    $ttest = true;
}
?>