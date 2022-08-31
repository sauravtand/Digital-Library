<?php
include("data_class.php");

$deletebookreq = $_GET['deletebookreqid'];
$obj = new data();
$obj->setconnection();
$obj->deletebookrequest($deletebookreq);
