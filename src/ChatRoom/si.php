<?php
session_start();
include("includes/db.php");
$email = $_SESSION["emailusata"];
echo "non puoi usare questa password poiché è già stata usata da $email";
?>
