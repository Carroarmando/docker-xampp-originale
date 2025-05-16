<?php

if (isset($a))
    $a += 1;
else
    $a = 1;

echo $a;

if($a < 50)
    require "fetch.php";

?>