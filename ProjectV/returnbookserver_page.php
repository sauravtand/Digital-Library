<?php
include("data_class.php");

$returnbook = $_GET['returnbook'];

$obj = new data();
$obj->setconnection();

$obj->returnbook($returnbook);
