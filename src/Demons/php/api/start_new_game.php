<?php
session_start();
$_SESSION["play"] = false;
header("Location: ../cerca_partita.php");
exit();
