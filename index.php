<?php

include_once "includes/init.php";

$db = new db();

$db->get_json();
$db->register();