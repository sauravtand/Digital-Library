<?php

include("data_class.php");

$book = $_POST['book'];
$userselect = $_POST['userselect'];

// get today date
// $getdate = date('Y-m-d');
// $returnDate = date('Y-m-d');
// $days = $_POST['days'];


// $returnDate = date('m/d/Y', strtotime('+' . $days . 'days'));
// calculate return date
$returnDate = date('Y-m-d', strtotime($_POST['returndate']));


$obj = new data();
$obj->setconnection();
$obj->issuebook($book, $userselect, $returnDate);
